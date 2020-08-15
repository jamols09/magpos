<template>

<div class="uk-margin-top">
   <div class="uk-container uk-container-large">
      <!-- Form -->     
      <!-- <h2 class="uk-h3 uk-margin-small-top">Profile</h2> -->
      
      <form class="uk-form-stacked uk-text-small" @submit.prevent="sendProfile">
         <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid >
            <ProfileAvatar/>
         </div>
         <div id="fullname" class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid >
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" v-bind:class="{ 'uk-form-danger' : false }" uk-tooltip="title: Required; pos: left">First name</label>
                  <div class="uk-form-controls">
                     <input name="first" class="uk-input" type="text" v-model="firstName" autocomplete="off">
                     <div v-if="submitted && !$v.user.firstName.required" class="uk-form-danger">First name is required</div>
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" v-bind:class="{ 'uk-form-danger' : false }" uk-tooltip="title: Required; pos: left">Middle name</label>
                  <div class="uk-form-controls">
                     <input name="middle" class="uk-input" type="text" v-model="middleName" autocomplete="off">
                     <div v-if="submitted && !$v.user.middleName.required" class="uk-form-danger">Middle name is required</div>
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" v-bind:class="{ 'uk-form-danger' : false }" uk-tooltip="title: Required; pos: left">Last name</label>
                  <div class="uk-form-controls">
                     <input name="last" class="uk-input" type="text" v-model="lastName" autocomplete="off">
                     <div v-if="submitted && !$v.user.lastName.required" class="uk-form-danger">Last name is required</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text">Date of Birth</label>
                  <div class="uk-form-controls">
                     <input class="uk-input" type="date" placeholder="" v-model="user.dateofbirth">
                     <div v-if="submitted && !$v.user.dateofbirth.required" class="uk-form-danger">Birthdate is required</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
            <div class="uk-margins" v-if="countries">
               <label class="uk-form-label uk-text-bold" for="form-stacked-text">Country</label>
               <div uk-form-custom="target: true" class="uk-form-custom">
                  <select v-model="user.country">
                     <option :value="null">Select country</option>
                     <option v-for="(country,index) in countries" v-bind:value="country" :key="index">{{country}}</option>
                  </select>
                  <span class="uk-select uk-form-width-medium">Please select...</span>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text">City/Province</label>
                  <div class="uk-form-controls">
                     <input class="uk-input" type="text" v-model="city">
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text">Street/House No.</label>
                  <div class="uk-form-controls">
                     <input class="uk-input" type="text" v-model="street">
                  </div>
               </div>
            </div>
         </div>
         <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" uk-tooltip="title: FB/Twitter/Linked-In; pos: left">Profile Link</label>
                  <div class="uk-form-controls">
                     <input class="uk-input" type="text" placeholder="Optional" v-model="user.profile_link">
                  </div>
               </div>
            </div>
            <div class="uk-margins">
               <div class="uk-form-label uk-text-bold">Sex</div>
               <div class="uk-form-controls">
                  <label><input class="uk-radio" type="radio" value="M" v-model="user.gender" /> Male</label>&nbsp;&nbsp;
                  <label><input class="uk-radio" type="radio" value="F" v-model="user.gender" /> Female</label>&nbsp;&nbsp;
                  <label><input class="uk-radio" type="radio" value="N/A" v-model="user.gender" /> Rather not say</label>
               </div>
            </div>
         </div>
         
         <div class="uk-margin-large-bottom"><br></div>
         <div class="footer-buttons">
            <div class="footer-padding">
               <button class="uk-button uk-button-primary uk-icon uk-align-right uk-margin-remove-bottom"><span uk-icon="icon: check;" class="uk-icon"></span> Save </button>
            </div>
         </div>
      </form>
      
      <!-- Form -->
   </div>
</div>

</template>

<script>
import axios from 'axios'
import { required } from "vuelidate/lib/validators"

//Avatar
import ProfileAvatar from './ProfileAvatar'

export default {

   components: {
      ProfileAvatar,
   },

   data() {
      return {
         isEmptyFn: false,
         isEmptyMn: false,
         isEmptyLn: false,

         submitted: false,

         user: {
            firstName: '',
            middleName: '',
            lastName: '',
            dateofbirth: '',
            city: '',
            street: '',
            gender: '',
            country: '',
            profileLink: '',
         },
         countries: {},
      }
   },
   //validation plugin
   validations: {
      user: {
         firstName: {required},
         middleName: {required},
         lastName: {required},
         dateofbirth: {required},
      }
   },

   created() {
      this.getProfile()
   },

   computed: {

      sanitize() {
         return /[^a-zA-Z0-9-. ]/g
      },

      firstName: {
         get() {return this.user.firstName},
         set(e) {return this.user.firstName = e.replace(this.sanitize, "")}
      },

      middleName: {
         get() {return this.user.middleName},
         set(e) {return this.user.middleName = e.replace(this.sanitize, "")}
      },

      lastName: {
         get() {return this.user.lastName},
         set(e) {return this.user.lastName = e.replace(this.sanitize, "")}
      },

      city: {
         get() {return this.user.city},
         set(e) {return this.user.city = e.replace(this.sanitize, "")}
      },

      street: {
         get() {return this.user.street},
         set(e) {return this.user.street = e.replace(this.sanitize, "")}
      }

   },

   methods: {
      getProfile() {
         if(this.$store.state.token) {
            return new Promise((resolve,reject) => {
               axios.get('/user/profile', {
                  headers: { Authorization: 'Bearer '+this.$store.state.token, },
               })
               .then(response => {
                  // user details
                  const {data:{data}} = response
                  this.user.firstName = data.first_name
                  this.user.middleName = data.middle_name
                  this.user.lastName = data.last_name
                  this.user.dateofbirth = data.dob
                  this.user.city = data.city
                  this.user.street = data.street
                  this.user.gender = data.gender
                  this.user.country = data.country
                  this.user.profileLink = data.profile_link
                  
                  this.countries = response.data.country
                  resolve(response)
               })
               .catch( error => {
                  console.log(error)
                  reject(error)
               })
            })
         }
      },

      sendProfile() {
         this.submitted = true
         this.$v.$touch();

         if(this.$v.$invalid) {
            return "Invalid Input"
         }

         let data = {
            first_name: this.user.firstName,
            middle_name: this.user.middleName,
            last_name: this.user.lastName,
            dob: this.user.dateofbirth,
            country: this.user.country,
            city: this.user.city,
            street: this.user.street,
            gender: this.user.gender,
            profile_link: this.user.profileLink,
         };

         let header = {
            headers: {Authorization: 'Bearer '+this.$store.state.token}
         };

         axios.post('/user/profile', data, header)
         .then(response => {
            console.log(response.data.message)
         })
         .catch( error => {
            console.log(error)
         })

      }
   }
}
</script>

<style>

</style>