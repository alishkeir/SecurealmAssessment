<template>
  <AdminLayout>
    <h2>Certificates</h2>

    <div v-if="certificates">
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

    <button @click="openModal">New Certificate</button>

    <CreateCertificate v-if="isModalOpen" />
  </AdminLayout>
</template>

<script>
import CreateCertificate from '@/components/admins/CreateCertificate.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

export default {
  name: 'CertificatesPage',
  components: { CreateCertificate },
  data() {
    return {
      certificates: [],
      isModalOpen: false,
    };
  },
  created: function () {
    this.getCertificates();
    this.$bus.on('updateAllCertificates', this.updateCertificates);
  },
  methods: {
    getCertificates() {
      this.$http
        .get(`/certificates/get`, {
          headers: {
            Authorization: `Bearer ${this.$cookie.get('token')}`,
          },
        })
        .then((response) => {
          this.certificates = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteCertificate(id) {
      this.$http
        .delete(`/certificates/delete/${id}`, {
          headers: {
            Authorization: `Bearer ${this.$cookie.get('token')}`,
          },
        })
        .then(() => {
          this.getCertificates();
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
      this.getCertificates();
      this.closeModal();
    },
    beforeUnmount() {
      this.$bus.off('updateAllCertificates', this.updateCertificates);
    },
  },
  components: { CreateCertificate, AdminLayout },
};
</script>
