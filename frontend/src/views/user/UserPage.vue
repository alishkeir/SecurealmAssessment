<template>
  <UserLayout>
    <h2>User Info</h2>

    <table>
      <tr>
        <th>Name</th>
        <td>{{ userInfo.name }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ userInfo.email }}</td>
      </tr>
      <tr>
        <th>Sex</th>
        <td>{{ userInfo.sex }}</td>
      </tr>
      <tr>
        <th>Blood Type</th>
        <td>{{ userInfo.blood_type }}</td>
      </tr>
    </table>

    <div v-if="certificates">
      <h3>Certificates</h3>
      <ul>
        <li v-for="certificate in certificates" :key="certificate.id">
          {{ certificate.name }}

          <a
            href="#"
            @click="deleteCertificate(certificate.id)"
            class="text-danger"
            >Remove</a
          >
        </li>
      </ul>
    </div>

    <button @click="openModal">Add Certificate</button>

    <AddCertificate v-if="isModalOpen" />
  </UserLayout>
</template>

<script>
import AddCertificate from '@/components/users/AddCertificate.vue';
import UserLayout from '@/layouts/UserLayout.vue';

export default {
  name: 'UserPage',

  components: {
    AddCertificate,
    UserLayout,
  },

  data() {
    return {
      userInfo: {},
      certificates: [],
      isModalOpen: false,
    };
  },

  computed: {},
  created() {
    this.$http
      .get('/user/profile', {
        headers: {
          Authorization: `Bearer ${this.$cookie.get('token')}`,
        },
      })
      .then((response) => {
        this.userInfo = response.data;
      })
      .then(() => {
        this.getUserCertificates();
      })
      .catch((error) => {
        console.log(error);
      });

    this.$bus.on('updateCertificates', this.updateCertificates);
  },
  methods: {
    getUserCertificates() {
      this.$http
        .get(`/user/certificates?id=${this.userInfo.id}`, {
          headers: {
            Authorization: `Bearer ${this.$cookie.get('token')}`,
          },
        })
        .then((response) => {
          this.certificates = response.data.certificates;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    updateCertificates() {
      this.getUserCertificates();
      this.closeModal();
    },
    deleteCertificate(id) {
      this.$http
        .delete(`/user/certificates/delete?id=${id}`, {
          headers: {
            Authorization: `Bearer ${this.$cookie.get('token')}`,
          },
        })
        .then((respone) => {
          this.getUserCertificates();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  beforeUnmount() {
    this.$bus.off('updateCertificates', this.updateCertificates);
  },
};
</script>
