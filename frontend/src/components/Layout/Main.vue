<template>
<div>
<!--top navigation bar-->
    <div v-if="isLoggedIn">
        <TopNavBar/>
    </div>
<!--side navigation bar-->
    <div v-if="isLoggedIn">
        <SideNavBar/>
    </div>
<!--content-->
    <div id="content-wrapper" v-if="isLoggedIn">    
        <router-view/>
    </div>
    <div v-if="!isLoggedIn">
        <router-view/>
    </div>

<!--footer-->
</div>
</template>

<script>
import TopNavBar from './TopNavBar'
import SideNavBar from './SideNavBar'

export default {
    components: {
        TopNavBar,
        SideNavBar,
    },

    computed: {
        isLoggedIn() {
            console.log("Logged In: "+this.$store.getters.loggedIn)
            return this.$store.getters.loggedIn
        }
    },

}
</script>

<style>
#content-wrapper {

  margin-left: 190px;
  margin-top: 30px;

}
</style>