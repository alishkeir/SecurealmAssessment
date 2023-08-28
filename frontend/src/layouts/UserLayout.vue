<template>
  <div class="main">
    <Navbar />

    <div class="content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import Navbar from '@/components/common/Navbar.vue';

// @ is an alias to /src

export default {
  name: 'UserLayout',
  components: { Navbar },
};
</script>

<style lang="scss">
.main {
  min-height: 100vh;
  width: 100vw;
  display: flex;
  flex-direction: column;

  .content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex: 1;

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
      width: fit-content;
    }
  }
}
</style>
