<template>
  <AdminLayout>
    <LoginForm @login="login" url="/admin/login" :user="false" />
  </AdminLayout>
</template>

<script>
import LoginForm from '@/components/common/LoginForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

export default {
  name: 'AdminLogin',

  components: {
    LoginForm,
    AdminLayout,
  },
};
</script>
