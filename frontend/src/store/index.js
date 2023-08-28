import API from '@/api';
import { createStore } from 'vuex';
import cookie from 'js-cookie';
import jwt from 'jsonwebtoken';
import router from '@/router';

const store = createStore({
  state() {
    return {
      //   isUserLoggedIn: false,
      userData: [],
      userType: 'user',
    };
  },
  mutations: {
    //^ ====== User mutations ======
    logoutUser(state) {
      state.isUserLoggedIn = false;
    },
    loginUser(state) {
      state.isUserLoggedIn = true;
    },

    //^ ====== Admin mutations ======
  },
  getters: {
    isLoggedIn: () => (userType) => {
      let loggedIn = false;
      if (cookie.get('token')) {
        jwt.verify(
          cookie.get('token'),
          process.env.VUE_APP_JWT_SECRET,
          (err, decoded) => {
            if (err) {
              cookie.remove('token');
              cookie.remove('user_id');
            } else {
              if (
                decoded.iss !==
                `${process.env.VUE_APP_API_URL}/${userType}/login`
              ) {
                cookie.remove('token');
                cookie.remove('user_id');
              } else {
                loggedIn = true;
              }
            }
          }
        );
      }

      return loggedIn;
    },
  },
  actions: {
    //^ ====== User mutations ======
    // for async methods (API calls or so)
    logout(context, userType) {
      API.post(`/${userType}/logout`, null, {
        headers: {
          Authorization: `Bearer ${cookie.get('token')}`,
        },
      })
        .then(() => {
          cookie.remove('token');
          cookie.remove('user_id');

          if (window.location.pathname.includes('admin')) {
            router.push('/admin/login');
          } else {
            router.push('/login');
          }
        })
        .catch((err) => {
          console.log({ ...err });
        });
    },

    //^ ====== Admin mutations ======
  },
});

export default store;
