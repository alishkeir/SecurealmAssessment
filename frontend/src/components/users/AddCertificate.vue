<template>
  <div class="popup">
    <div class="popup-content">
      <div class="close" @click="$bus.emit('closeAddUserCertificateModal')">
        <font-awesome-icon :icon="['fas', 'xmark']" />
      </div>
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

      <button @click="addNewCertificate">Add</button>
    </div>
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

<style lang="scss" scoped>
.popup {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.6);
  left: 0;
  top: 0;

  &-content {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    padding: 0 30px 30px;
    width: 350px;
    height: 250px;
    justify-content: space-between;
    position: relative;

    button {
      background-color: #8e44ad;
      border: 2px solid #8e44ad;
      border-radius: 4px;
      color: #fff;
      display: block;
      font-family: inherit;
      font-size: 16px;
      padding: 10px;
      margin-top: 20px;
      width: 100%;
    }

    select {
      border: 2px solid #f0f0f0;
      border-radius: 4px;
      display: block;
      font-family: inherit;
      font-size: 14px;
      padding: 10px;
      width: 100%;
      height: 45px;
    }

    .close {
      font-size: 20px;
      width: fit-content;
      margin-left: auto;
      margin-top: 10px;
      margin-right: -10px;
      cursor: pointer;
    }
  }
}
</style>
