<template>
  <UserLayout>
    <h2>EditUser</h2>

    <EditForm />
  </UserLayout>
</template>

<script>
import EditForm from '@/components/users/EditForm.vue';
import UserLayout from '@/layouts/UserLayout.vue';

export default {
  name: 'EditUser',
  computed: {},
  created() {},
  components: { EditForm, UserLayout },
};
</script>
