<template>
  <div class="popup">
    <small v-if="error" class="error">{{ error }}></small>
    <select v-model="selectedCertificate">
      <option value="">Select a Certificate to add</option>

      <option
        v-for="certificate in certificates"
        :key="certificate.id"
        :value="certificate.id"
      >
        {{ certificate.name }}
      </option>
    </select>

    <button @click="addNewCertificate">Add Certificate</button>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'AddCertificate',
  data() {
    return {
      certificates: [],
      selectedCertificate: '',
      error: '',
    };
  },
  components: {},
  created: function () {
    this.$http
      .get(`/certificates`, {
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

  methods: {
    addNewCertificate() {
      if (!this.selectedCertificate) {
        this.error = 'Please select a certificate';
        return;
      }

      this.$http
        .post(
          `/user/certificates/add`,
          {
            user_id: this.$cookie.get('user_id'),
            certificate_id: this.selectedCertificate,
          },
          {
            headers: {
              Authorization: `Bearer ${this.$cookie.get('token')}`,
            },
          }
        )
        .then(() => {
          this.$bus.emit('updateCertificates');
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
