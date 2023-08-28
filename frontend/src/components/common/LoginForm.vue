<template>
  <div class="container">
    <div class="header">
      <h2>Login</h2>
    </div>
    <form id="form" class="form" novalidate @submit.prevent="validateAndLogin">
      <small :class="{ error: failed }" v-if="failed">{{
        failedMessage
      }}</small>

      <div class="form--control" :class="{ error: emailError.length }">
        <label for="username">Email</label>
        <input
          type="email"
          placeholder="example@example.com"
          id="email"
          v-model="email"
        />
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small v-if="emailError.length">{{ emailError }}</small>
      </div>
      <div class="form--control" :class="{ error: passwordError.length }">
        <label for="username">Password</label>
        <input
          type="password"
          placeholder="Password"
          id="password"
          v-model="password"
        />
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small v-if="passwordError">{{ passwordError }}</small>
      </div>

      <router-link v-if="user" to="/admin/login">Are you an Admin?</router-link>

      <router-link v-else to="/login">Are you a User?</router-link>

      <router-link v-if="user" to="/register"
        >Don't have an account?</router-link
      >

      <button>Submit</button>
    </form>

    <a> </a>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'LoginForm',
  components: {},
  data() {
    return {
      email: '',
      password: '',
      emailError: '',
      passwordError: '',
      error: false,
      failed: false,
      failedMessage: '',
    };
  },

  props: {
    url: String,
    user: String,
  },
  methods: {
    validateAndLogin() {
      this.emailError = '';
      this.passwordError = '';
      this.failedMessage = '';
      this.error = false;
      this.failed = false;

      if (this.email.trim() == '') {
        this.emailError = 'Email is required';
        this.error = true;
      }

      if (
        !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
          this.email
        )
      ) {
        this.emailError = 'Invalid Email';
        this.error = true;
      }

      if (this.password.trim() == '') {
        this.passwordError = 'Password is required';
        this.error = true;
      }

      if (this.error) return;

      this.emailError = '';
      this.passwordError = '';

      this.$http
        .post(this.url, {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          this.$cookie.set('token', response.data.access_token, {
            expires: new Date(new Date().getTime() + 60 * 60 * 1000), // expire in 1 hour
          });

          if (this.user) {
            this.$cookie.set('user_id', response.data.user.id);
          }
        })
        .then(() => {
          if (this.user) {
            this.$router.push('/');
          } else {
            this.$router.push('/admin');
          }
        })
        .catch((error) => {
          this.failed = true;
          if (error?.response?.data?.error)
            this.failedMessage = error.response.data.error;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,500&display=swap');

* {
  box-sizing: border-box;
}

a {
  color: inherit;
  text-align: center;
  width: 100%;
  display: block;

  &:hover {
    text-decoration: underline;
  }
}

.container {
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  width: 400px;
  max-width: 100%;
  padding: 0;
}

.header {
  border-bottom: 1px solid #f0f0f0;
  background-color: #f7f7f7;
  padding: 20px 40px;
}

.header h2 {
  margin: 0;
}

.form {
  padding: 30px 40px;
}

.form--control {
  margin-bottom: 10px;
  padding-bottom: 20px;
  position: relative;
}

.form--control label {
  display: inline-block;
  margin-bottom: 5px;
}

.form--control input {
  border: 2px solid #f0f0f0;
  border-radius: 4px;
  display: block;
  font-family: inherit;
  font-size: 14px;
  padding: 10px;
  width: 100%;
}

.form--control input:focus {
  outline: 0;
  border-color: #777;
}

.form--control.success input {
  border-color: #2ecc71;
}

.form--control.error input {
  border-color: #e74c3c;
}

.form--control i {
  visibility: hidden;
  position: absolute;
  top: 40px;
  right: 10px;
}

.form--control.success i.fa-check-circle {
  color: #2ecc71;
  visibility: visible;
}

.form--control.error i.fa-exclamation-circle {
  color: #e74c3c;
  visibility: visible;
}

form small {
  color: #e74c3c;
  visibility: hidden;
}

.form--control small {
  position: absolute;
  bottom: 0;
  left: 0;
}
.form--control.error small,
small.error {
  visibility: visible;
}

.form button {
  background-color: #8e44ad;
  border: 2px solid #8e44ad;
  border-radius: 4px;
  color: #fff;
  display: block;
  font-family: inherit;
  font-size: 16px;
  padding: 10px;
  margin-top: 20px;
  width: 100%;
}

/* SOCIAL PANEL CSS */
.social-panel-container {
  position: fixed;
  right: 0;
  bottom: 80px;
  transform: translateX(100%);
  transition: transform 0.4s ease-in-out;
}

.social-panel-container.visible {
  transform: translateX(-10px);
}

.social-panel {
  background-color: #fff;
  border-radius: 16px;
  box-shadow: 0 16px 31px -17px rgba(0, 31, 97, 0.6);
  border: 5px solid #001f61;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-family: 'Muli';
  position: relative;
  height: 169px;
  width: 370px;
  max-width: calc(100% - 10px);
}

.social-panel button.close-btn {
  border: 0;
  color: #97a5ce;
  cursor: pointer;
  font-size: 20px;
  position: absolute;
  top: 5px;
  right: 5px;
}

.social-panel button.close-btn:focus {
  outline: none;
}

.social-panel p {
  background-color: #001f61;
  border-radius: 0 0 10px 10px;
  color: #fff;
  font-size: 14px;
  line-height: 18px;
  padding: 2px 17px 6px;
  position: absolute;
  top: 0;
  left: 50%;
  margin: 0;
  transform: translateX(-50%);
  text-align: center;
  width: 235px;
}

.social-panel p i {
  margin: 0 5px;
}

.social-panel p a {
  color: #ff7500;
  text-decoration: none;
}

.social-panel h4 {
  margin: 20px 0;
  color: #97a5ce;
  font-family: 'Muli';
  font-size: 14px;
  line-height: 18px;
  text-transform: uppercase;
}

.social-panel ul {
  display: flex;
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.social-panel ul li {
  margin: 0 10px;
}

.social-panel ul li a {
  border: 1px solid #dce1f2;
  border-radius: 50%;
  color: #001f61;
  font-size: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50px;
  width: 50px;
  text-decoration: none;
}

.social-panel ul li a:hover {
  border-color: #ff6a00;
  box-shadow: 0 9px 12px -9px #ff6a00;
}

.floating-btn {
  border-radius: 26.5px;
  background-color: #001f61;
  border: 1px solid #001f61;
  box-shadow: 0 16px 22px -17px #03153b;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  line-height: 20px;
  padding: 12px 20px;
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 999;
}

.floating-btn:hover {
  background-color: #ffffff;
  color: #001f61;
}

.floating-btn:focus {
  outline: none;
}

.floating-text {
  background-color: #001f61;
  border-radius: 10px 10px 0 0;
  color: #fff;
  font-family: 'Muli';
  padding: 7px 15px;
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  z-index: 998;
}

.floating-text a {
  color: #ff7500;
  text-decoration: none;
}

@media screen and (max-width: 480px) {
  .social-panel-container.visible {
    transform: translateX(0px);
  }

  .floating-btn {
    right: 10px;
  }
}

button {
  cursor: pointer;
}
</style>
