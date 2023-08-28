<template>
  <header class="header">
    <img
      class="logo"
      src="https://securealm.net/wp-content/uploads/2019/01/securealm-logo.png"
    />

    <router-link to="/admin/login" class="first" v-if="user">
      <font-awesome-icon :icon="['fas', 'gear']" />
    </router-link>

    <router-link to="/login" v-if="!user">
      <font-awesome-icon :icon="['fas', 'user-tie']" />
    </router-link>

    <div
      class="logout"
      @click="$store.dispatch('logout', 'user')"
      v-if="showLogout"
    >
      <font-awesome-icon :icon="['fas', 'arrow-right-from-bracket']" />
    </div>
  </header>
</template>

<script>
// @ is an alias to /src
import { mapGetters } from 'vuex';

export default {
  name: 'NavBar',

  props: {
    user: Boolean,
  },
  components: {},
  computed: {
    ...mapGetters(['isLoggedIn']),
    showLogout() {
      if (this.user) {
        return this.isLoggedIn('user');
      } else {
        return this.isLoggedIn('admin');
      }
    },
  },
  methods: {},
  created() {
    // console.log(this.showLogout());
  },
};
</script>
<style lang="scss">
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  font-size: 20px;

  .logo {
    width: 290px;
  }

  .logout {
    cursor: pointer;
  }

  a {
    margin-right: 20px;
    color: inherit;

    &.first {
      margin-left: auto;
    }
  }
}
</style>
