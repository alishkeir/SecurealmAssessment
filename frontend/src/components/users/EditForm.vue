<template>
  <div class="container">
    <div class="header">
      <h2>Create Account</h2>
    </div>
    <form id="form" class="form" novalidate @submit.prevent="validateAndUpdate">
      <small :class="{ error: failed }" v-if="failed">{{
        failedMessage
      }}</small>

      <div class="form--control" :class="{ error: nameError.length }">
        <label for="name">Name</label>
        <input type="text" placeholder="Name" id="name" v-model="name" />
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small v-if="nameError.length">{{ nameError }}</small>
      </div>

      <div class="form--control" :class="{ error: passwordError.length }">
        <label for="password">Password</label>
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

      <div class="form--control">
        <label>Sex</label>
        <select v-model="sex">
          <option selected value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <div class="form--control">
        <label>Blood Type</label>

        <select v-model="blood_type">
          <option selected value="A+">A+</option>
          <option selected value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>

          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
        </select>
      </div>

      <button>Submit</button>
    </form>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'EditForm',
  components: {},
  data() {
    return {
      email: '',
      password: '',
      name: '',
      sex: 'Male',
      blood_type: 'A+',

      emailError: '',
      passwordError: '',
      nameError: '',

      error: false,
      failed: false,
      failedMessage: '',
    };
  },

  created() {
    this.$http
      .get('/user/profile', {
        headers: {
          Authorization: `Bearer ${this.$cookie.get('token')}`,
        },
      })
      .then((response) => {
        this.email = response.data.email;
        this.name = response.data.name;
        this.sex = response.data.sex;
        this.blood_type = response.data.blood_type;
      });
  },

  props: {},
  methods: {
    validateAndUpdate() {
      this.emailError = '';
      this.passwordError = '';
      this.nameError = '';
      this.failedMessage = '';

      this.error = false;
      this.failed = false;

      if (this.name.trim() == '') {
        this.nameError = 'Name is required';
        this.error = true;
      }

      if (this.error) return;

      this.$http
        .put(
          'user/update',
          {
            name: this.name,
            email: this.email,
            password: this.password ? this.password : undefined,
            sex: this.sex,
            blood_type: this.blood_type,
            id: this.$cookie.get('user_id'),
          },
          {
            headers: {
              Authorization: `Bearer ${this.$cookie.get('token')}`,
            },
          }
        )
        .then(() => {
          this.$router.push('/');
        })
        .catch((error) => {
          console.log(error);
          this.failed = true;
          if (error?.response?.data?.message)
            this.failedMessage = error.response.data.message;
        });
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,500&display=swap');

* {
  box-sizing: border-box;
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

.form--control input,
.form--control select {
  border: 2px solid #f0f0f0;
  border-radius: 4px;
  display: block;
  font-family: inherit;
  font-size: 14px;
  padding: 10px;
  width: 100%;
  display: block;
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
