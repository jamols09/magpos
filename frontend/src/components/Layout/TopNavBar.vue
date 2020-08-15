<template>
<div>
  <nav class="uk-navbar-container uk-margin">
    <div class="uk-container uk-container-expand uk-background-secondary">
        <div class="uk-navbar">
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">
                  <router-link v-if="loggedIn" tag='li' :to="{ name: 'profile'}"><a href="{ name: 'profile'}">Profile</a></router-link>
                  <router-link v-if="loggedIn" tag='li' :to="{ name: 'logout'}"><a href="{ name: 'logout'}">Logout</a></router-link>
                </ul>
            </div>
        </div>
    </div>
  </nav>
</div>
</template>

<script>
export default {
  computed: {
    loggedIn() {
      return this.$store.getters.loggedIn
    }
  }
}
</script>

<style >

</style>
