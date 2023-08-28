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
  name: 'AdminLayout',
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
  }
}
</style>
