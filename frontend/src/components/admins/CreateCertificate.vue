<template>
  <div class="popup">
    <small v-if="error" class="error">{{ error }}</small>

    <div class="form--control" :class="{ error: nameEror.length }">
      <label for="password">Certificate Name</label>
      <input
        type="text"
        placeholder="Certificate Name"
        id="certificate"
        v-model="name"
      />
      <i class="fas fa-check-circle"></i>
      <i class="fas fa-exclamation-circle"></i>
      <small v-if="nameEror">{{ nameEror }}</small>
    </div>

    <button @click="addNewCertificate">Add Certificate</button>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'CreateCertificate',
  data() {
    return {
      name: '',
      nameEror: '',
      error: '',
    };
  },

  methods: {
    addNewCertificate() {
      this.error = '';
      this.nameEror = '';

      if (!this.name) {
        this.nameEror = 'Name is required';
        return;
      }

      this.$http
        .post(
          `/certificates/add`,
          {
            name: this.name,
          },
          {
            headers: {
              Authorization: `Bearer ${this.$cookie.get('token')}`,
            },
          }
        )
        .then(() => {
          console.log(object);

          this.$bus.emit('updateAllCertificates');
        })
        .catch((error) => {
          console.log(error);
          this.failed = true;
          if (error?.response?.data?.message)
            this.error = error.response.data.message;
        });
    },
  },
};
</script>
