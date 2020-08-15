<template>
  <div>
      Logged out
  </div>
</template>

<script>
export default {
    created() {
        this.$store.dispatch('destroyToken')
        // this.$router.push('name','login')
    }
}
</script>

<style>

</style>