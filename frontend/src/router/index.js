import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'


Vue.use(VueRouter)

  const routes = [

    //Authenticated users
    {
      path: '/logout',
      name: 'logout',
      component: () => import('../components/Auth/Logout.vue'),
      meta: {
        isAuthenticated: true
      }
    },
    { 
      path: '/profile',
      name: 'profile',
      component: () => import('../components/Profile/Profile.vue'),
      meta: {
        isAuthenticated: true
      }
    },
    { 
      path: '/customer',
      name: 'customer',
      component: () => import('../components/Customer/Customer.vue'),
      meta: {
        isAuthenticated: true
      }
    },
    { 
      path: '/customer2',
      name: 'customer2',
      component: () => import('../components/Customer/Customer2.vue'),
      meta: {
        isAuthenticated: true
      }
    },

    //IsAuthenticated false
    {
      path: '/login',
      name: 'login',
      component: () => import('../components/Auth/Login.vue'),
      meta: {
        isVisitor: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../components/Auth/Register.vue'),
      meta: {
        isVisitor: true
      }
    },
  ]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

//Navigation Guards
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.isAuthenticated)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.loggedIn) {
      next({
        path: '/login',
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.isVisitor)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters.loggedIn) {
      next({
        path: '/profile',
      })
    } else {
      next()
    }
  }
})

export default router
