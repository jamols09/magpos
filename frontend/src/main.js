import Vue from 'vue'
import Main from './components/Layout/Main.vue'
// import Layout from './components/Layout/Layout.vue'
import router from './router' //automatically calls index file when there is no file indicated
import store from './store' //automatically calls index file when there is no file indicated
import Vuelidate from 'vuelidate'
//css framework
// import Vuikit from 'vuikit'
// import VuikitIcons from '@vuikit/icons'
// import '@vuikit/theme'

// Vue.use(Vuikit);
// Vue.use(VuikitIcons);
import "../node_modules/uikit/src/less/uikit.less";
import Uikit from 'uikit'
import Icons from 'uikit/dist/js/uikit-icons'
Uikit.use(Icons)
Vue.use(Vuelidate)

Vue.config.productionTip = false;
Vue.prototype.$eventBus = new Vue()

export const bus = new Vue();

new Vue({
  router,
  store,
  render: h => h(Main)
}).$mount('#app')

