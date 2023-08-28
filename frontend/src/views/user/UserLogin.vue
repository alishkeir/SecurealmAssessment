<template>
  <UserLayout>
    <LoginForm @login="login" url="/user/login" :user="true" />
  </UserLayout>
</template>

<script>
import LoginForm from '@/components/common/LoginForm.vue';
import UserLayout from '@/layouts/UserLayout.vue';

export default {
  name: 'UserLogin',

  components: {
    LoginForm,
    UserLayout,
  },
};
</script>
