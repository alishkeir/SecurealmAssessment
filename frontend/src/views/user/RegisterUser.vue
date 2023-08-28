<template>
  <UserLayout>
    <RegisterForm />
  </UserLayout>
</template>

<script>
import RegisterForm from '@/components/users/RegisterForm.vue';
import UserLayout from '@/layouts/UserLayout.vue';
export default {
  name: 'RegisterUser',
  components: {
    RegisterForm,
    UserLayout,
  },

  computed: {},
};
</script>
