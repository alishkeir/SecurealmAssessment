<template>
  <div>
    <h2>Users Page</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>

          <th>Name</th>

          <th>Email</th>

          <th>Sex</th>

          <th>Blood Type</th>

          <th>Last Login</th>

          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.sex }}</td>
          <td>{{ user.blood_type }}</td>
          <td>{{ user.last_login }}</td>
          <td>
            <button
              @click="updateApproved(user.id, false)"
              v-if="user.approved"
            >
              Disapprove
            </button>
            <button @click="updateApproved(user.id, true)" v-else>
              Approve
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'UsersPage',
  data() {
    return {
      users: [],
    };
  },
  created() {
    this.getAllUsers();
  },
  methods: {
    getAllUsers() {
      this.$http
        .get('/users/', {
          headers: { Authorization: `Bearer ${this.$cookie.get('token')}` },
        })
        .then((response) => {
          console.log((this.users = response.data));
        });
    },
    updateApproved(id, approve) {
      console.log(approve);

      this.$http
        .put(
          '/admin/user/approve',
          {
            id,
            approved: approve,
          },
          {
            headers: {
              Authorization: `Bearer ${this.$cookie.get('token')}`,
            },
          }
        )
        .then(() => {
          this.getAllUsers();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
