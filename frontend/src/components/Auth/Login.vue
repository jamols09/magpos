<template>
<div class="uk-section uk-section-muted uk-animation-fade" uk-height-viewport>
	<div class="uk-width-1-3">
		<div class="uk-container">
			<div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
				<div class="uk-width-1-1@m">
					<div class="uk-margin uk-width-medium uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large uk-background-secondary uk-light">
						<h3 class="uk-card-title uk-text-center">Welcome MPOS!</h3>
						<form @submit.prevent="login">
							<div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: mail"></span>
									<input class="uk-input uk-form-small" placeholder="Username/Email" type="text" v-model="username">
								</div>
							</div>
							<div class="uk-margin">
								<div class="uk-inline uk-width-1-1">
									<span class="uk-form-icon" uk-icon="icon: lock"></span>
									<input class="uk-input uk-form-small" placeholder="Password" type="password" v-model="password">	
								</div>
							</div>
                            <div class="uk-alert-danger" v-if="getAuthMsg" uk-alert>
                                <a class="uk-alert-close" @click.prevent="rmvAuthMsg" uk-close></a>
                                <p>{{getAuthMsg}}</p>
                            </div>
							<div class="uk-margin">
								<button class="uk-button uk-button-primary uk-button-small uk-width-1-1">Login</button>
							</div>
							<div class="uk-text-small uk-text-center">
								Not registered? <router-link :to="{ name: 'register'}"><a href="">Create account</a></router-link>
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
    name: 'login',

    data() {
        return {
            username: "",
            password: "",
        }
    },

    computed: {
        getAuthMsg() {
            return this.$store.getters.getAuthMsg;
        }
    },

    created() {
        this.rmvAuthMsg()
    },

    methods: {
        // userDetails() {
        //     this.$store.dispatch('userDetails')
        // },
        // Remove alert message
        rmvAuthMsg() {
            this.$store.dispatch('rmvAuthMsg')
        },

        login() {
            this.$store.dispatch('retrieveToken', {
                username: this.username,
                password: this.password,
            })
            .then( () => {
                this.$router.push({ name: 'profile'})
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>

<style>

</style>