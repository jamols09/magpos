<template>

<!-- The sidebar -->

    <aside id="sidenavbar" class="uk-light">
        <div class="logo">
            <a class="uk-navbar-item uk-logo" href="#">
                <img src="./../../assets/banner.png" width="100px;" alt="Logo" srcset="">
            </a>
        </div>
        <div class="bar-wrap">
            <ul class="uk-nav-default uk-nav-parent-icon uk-nav uk-text-small" uk-nav="">
                <li>
                    <router-link v-if="loggedIn" tag='li' :to="{ name: 'customer'}"><a href="{ name: 'customer'}" class="uk-text-center " uk-icon="icon: users" uk-tooltip="title: Customers; pos: right"></a></router-link>
                </li>     
                
                <li class="uk-parent">
                    <a href="#" class="uk-text-center" uk-icon="icon: database" uk-tooltip="title: Admin; pos: right"></a>
                    <ul class="uk-nav-sub" hidden="" aria-hidden="true">
                        <li><a href="#" class="uk-text-center">Sub item</a></li>
                        <li><a href="#" class="uk-text-center">Sub item</a></li>
                    </ul>
                </li>               
            </ul>
        </div>
    </aside>


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

<style scoped>
#sidenavbar {
  position: fixed;
  left: 0;
  top:0;
  bottom:0;
  overflow-x: hidden;
  overflow-y: auto;
  background-color: #222;
  width: 170px;
  z-index: 0;
}
.bar-wrap {
  margin-top: 10px;
  padding: 1rem;
}

li {
    padding-top: 12px;
}

</style>