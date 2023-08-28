<template>
  <header class="header">
    <font-awesome-icon
      :icon="['fas', 'arrow-right-from-bracket']"
      @click="$store.dispatch('logout', 'user')"
    />
  </header>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'NavBar',
  components: {},
};
</script>
