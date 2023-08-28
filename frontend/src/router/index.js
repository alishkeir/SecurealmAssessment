import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';

import UserLogin from '@/views/user/UserLogin.vue';
import UserPage from '@/views/user/UserPage.vue';
import RegisterUser from '@/views/user/RegisterUser.vue';
import EditUser from '@/views/user/EditUser.vue';

import AdminLogin from '../views/admin/AdminLogin.vue';
import CertificatesPage from '../views/admin/CertificatesPage.vue';
import UsersPage from '../views/admin/UsersPage.vue';

const routes = [
  // User Routes
  {
    path: '/',
    name: 'user-profile',
    component: UserPage,
    meta: {
      requiresAuth: true,
      side: 'user',
    },
  },
  {
    path: '/edit-profile',
    name: 'edit-user-profile',
    component: EditUser,
    meta: {
      requiresAuth: true,
      side: 'user',
    },
  },
  {
    path: '/login',
    name: 'user-login',
    component: UserLogin,
    meta: {
      requiresAuth: false,
      side: 'user',
    },
  },

  {
    path: '/register',
    name: 'user-register',
    component: RegisterUser,
    meta: {
      requiresAuth: false,
      side: 'user',
    },
  },
  {
    path: '/:catchAll(.*)', // Matches any path that hasn't matched other routes
    redirect: '/',
  },

  // Admin Routes

  {
    path: '/admin/login',
    name: 'admin-login',
    component: AdminLogin,
    meta: {
      requiresAuth: false,
      side: 'admin',
    },
  },
  {
    path: '/admin',
    name: 'certificates',
    component: CertificatesPage,
    meta: {
      requiresAuth: true,
      side: 'admin',
    },
  },
  {
    path: '/admin/users',
    name: 'users',
    component: UsersPage,
    meta: {
      requiresAuth: true,
      side: 'admin',
    },
  },
  {
    path: '/admin/:catchAll(.*)', // Matches any path that hasn't matched other routes
    redirect: '/admin',
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    if (to.meta.side === 'user') {
      if (!store.getters.isLoggedIn('user')) {
        next('/login');
      } else {
        next();
      }
    }

    if (to.meta.side === 'admin') {
      if (!store.getters.isLoggedIn('admin')) {
        next('/admin/login');
      } else {
        next();
      }
    }
  } else {
    switch (true) {
      case store.getters.isLoggedIn('user') &&
        ['/register', '/login'].includes(to.fullPath):
        next('/');
        break;

      case store.getters.isLoggedIn('admin') &&
        ['/admin/login'].includes(to.fullPath):
        next('/admin');
        break;

      default:
        next();
        break;
    }
  }
});

export default router;
