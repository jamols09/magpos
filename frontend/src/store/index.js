import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
axios.defaults.headers.common['header'] = 'application/json'

export default new Vuex.Store({
  state: {
    
    //Token
    token: localStorage.getItem('access_token') || null,
    authmsg: null,
    authmsgs: {
      username: null,
      email: null,
      password: null,
      password_confirmation: null
    },
    //User details
    user_details: {
      role: null,
      is_active: null,
      username: null,
    },

    //TODO
    filter: 'all',
    todoArr: [
      {
          id: 1,
          title: 'Test 1',
          completed: false,
          editstate: false,
      },
      {
          id: 2,
          title: 'Test 2',
          completed: false,
          editstate: false,
      }
    ],
    //TODO
  },
  getters: {
    loggedIn(state) {
      return state.token !== null
    },
    getAuthMsg(state) {
      return state.authmsg
    },
    // getUserDetails(state) {
    //   return state.user_details
    // }
  },
  mutations: {
    /* Authentication Login */
    retrieveToken(state,token) {
      state.token = token
    },
    /* Authentication Logout */
    destroyToken(state) {
      state.token = null
    },
    /* Auth Message */
    setAuthMsg(state,msg) {
      state.authmsg = msg
    },
    rmvAuthMsg(state) {
      state.authmsg = null
    },
    /* User details */
    // setUserdetails(state,details){
    //   state.id = details.id
    //   state.is_active = details.is_active
    //   state.role = details.role
    // },
  },
  actions: {

    /* Authentication Register */
    register(context, credentials) {

      return new Promise((resolve,reject) => {
        axios.post('/register', {
          username: credentials.username,
          email: credentials.email,
          password: credentials.password,
          password_confirmation: credentials.password_confirmation
        })
        .then( response => {
          resolve(response)
        })
        .catch( error => {
          console.log(error.response.data)
          reject(error)
        })
      })
    },

    /* Authentication Login */
    retrieveToken(context, credentials) {
      
      return new Promise((resolve,reject) => { //let the parent of the component know what is the state of variable
        axios.post('/login', {
          username: credentials.username,
          password: credentials.password
        })
        .then( response => {
          localStorage.setItem('access_token',  response.data.access_token)
          context.commit('retrieveToken',  response.data.access_token)
          
          resolve(response) //let the parent of the component know what is the state of variable
        })
        .catch( error => {
          context.commit('setAuthMsg', error.response.data.message)
          console.log( error.response.data.message) 
          reject(error) //let the parent of the component know what is the state of variable
        })
      })
    },

    /* Authentication Logout */
    destroyToken(context) {
      axios.defaults.headers.common['Authorization'] = 'Bearer '+context.state.token
      if(context.getters.loggedIn) {
        return new Promise((resolve,reject) => { //let the parent of the component know what is the state of variable
          axios.post('/logout')
          .then(response => {
            localStorage.removeItem('access_token') //destroy token in local browser
            context.commit('destroyToken')
            resolve(response) //let the parent of the component know what is the state of variable
          })
          .catch( error => {
            // context.commit('setAuthMsg', 'erro')
            localStorage.removeItem('access_token') //destroy token in local browser
            context.commit('destroyToken') 
            reject(error)
          })
        })
      }
    },
    
    /* Remove alert message */
    rmvAuthMsg(context) {
      if(context.getters.getAuthMsg) {
        context.commit('rmvAuthMsg')
      }
    },

    /* Get User Details */
    // userDetails(context) {
    //   return new Promise((resolve,reject) => { //let the parent of the component know what is the state of variable
    //     axios.get('/whoami')
    //     .then(response => {
    //       console.log(response.data)
    //       context.commit('setUserdetails', response.data) 
    //       resolve(response) //let the parent of the component know what is the state of variable
    //     })
    //     .catch( error => {
    //       console.log(error.response.data)
    //       reject(error)
    //     })
    //   })
    // },
  },
  modules: {
    
  }
})
