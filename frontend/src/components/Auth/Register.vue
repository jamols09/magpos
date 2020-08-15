<template>
<div class="uk-section uk-section-muted uk-animation-fade" uk-height-viewport>
	<div class="uk-width-1-3">
		<div class="uk-container">
			<div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
				<div class="uk-width-1-1@m">
					<div class="uk-margin uk-width-medium uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-small uk-background-secondary uk-light">
						<h3 class="uk-card-title uk-text-center">Create account</h3>
						<form @submit.prevent="register">
							<div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: user"></span>
									<input class="uk-input uk-form-small" placeholder="Username" type="text" v-model="username">
								</div>
							</div>
              <div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: mail"></span>
									<input class="uk-input uk-form-small" placeholder="Email" type="text" v-model="email">
								</div>
							</div>
              <div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: lock"></span>
									<input class="uk-input uk-form-small" placeholder="Password" type="password" v-model="password">
								</div>
							</div>
							<div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: lock"></span>
									<input class="uk-input uk-form-small" placeholder="Retype password" type="password" v-model="password_confirmation">	
								</div>
							</div>
              <div class="uk-alert-danger" v-for="(message, index) in getAuthMsgError" :key="index" uk-alert>
                <p>{{message}}</p>
              </div>
              <div class="uk-alert-success" v-if="getAuthMsgSuccess" uk-alert>
                <p>{{getAuthMsgSuccess}}</p>
              </div>
							<div class="uk-margin">
								<button class="uk-button uk-button-primary uk-button-small uk-width-1-1">Create Account</button>
							</div>
							<div class="uk-text-small uk-text-center">
                
								Already got an account? <router-link :to="{ name: 'login'}"><a href="">Sign in</a></router-link>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
  name: 'register',

  data() {
    return {
      username: "",
      email: "",
      password: "",
      password_confirmation: "",
      
      error: {
        message: null,
        username: null,
        email: null,
        password: null,
        password_confirmation: null
      },

      success: null,
    }
  },

  computed: {
    getAuthMsgError() {
      //Object.values filters Object value
      //Object.key filters Object keys
      return Object.values(this.error).filter(e => e !== null)
    },

    getAuthMsgSuccess() {
      return this.success
    }
  },

  methods: {

    //Remove alert message
    rmvAuthMsg() {
        this.$store.dispatch('rmvAuthMsg')
    },
    
    register() {
      this.$store.dispatch('register', {
        username: this.username,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      })
      .then( (response) => {
        this.success = response.data.message
        setTimeout( () => this.$router.push({ name: 'login'}), 3000)
      })
      .catch( error => {
        //Clear array first
        this.error.username = null,
        this.error.email = null,
        this.error.password = null,
        this.error.password_confirmation = null

        //fill data with server response
        for(let key1 in error.response.data) {
          for(let key2 in this.error) {
            if(key2 == key1 && error.response.data[key1] !== '') {
              this.error[key2] = error.response.data[key1][0]
            }
          }
        }
        // console.log(this.error)
      })
    }
  }
}
</script>

<style>

</style>