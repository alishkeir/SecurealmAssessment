<template>
  <div>
    <LoginForm @login="login" url="/admin/login" :user="false" />
  </div>
</template>

<script>
import LoginForm from '@/components/common/LoginForm.vue';

export default {
  name: 'AdminLogin',

  components: {
    LoginForm,
  },
};
</script>
