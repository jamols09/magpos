<template>
  <div class="uk-margin-top">
   <div class="uk-container uk-container-large">
      <!-- Customer -->     
      <!-- <h2 class="uk-h3 uk-margin-small-top">Customer</h2> -->
      <form class="uk-form-stacked uk-text-small" @submit.prevent="updateCustomer">
          <!-- Input -->
         <div class="uk-grid-small uk-child-width-1-4@s uk-flex-center" uk-grid >
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" v-bind:class="{ 'uk-form-danger' : false }" uk-tooltip="title: Required; pos: left">*Name</label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" autocomplete="off">
                    
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" uk-tooltip="title: Required; pos: left">Phone Number</label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" placeholder="(Optional)" autocomplete="off">
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" uk-tooltip="title: Required; pos: left">Company</label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" placeholder="(Optional)" autocomplete="off">
                    
                  </div>
               </div>
            </div>
            <div class="uk-first-column">
               <div class="uk-margins">
                  <label class="uk-form-label uk-text-bold" for="form-stacked-text" uk-tooltip="title: Required; pos: left">Address</label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" placeholder="(Optional)" autocomplete="off">
                  </div>
               </div>
            </div>
         </div>

        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center uk-margin-large-top uk-grid" uk-grid="">
            <div class="uk-first-column">
               
               <div class="table">
                    <select v-model="selected" @change="getCustomers()" class="displayCount">
                        <option v-for="option in displayOptions" :key="option.index" :value="option" :selected="option == 5" >{{option}}</option>
                    </select>
                    <!-- Table :customerProp will be used to pass values to its child via prop -->
                    <CustomerTable v-if="customerlist" :customerProp="customerlist" :headersProp="headers"/>
                   
                    <!-- Table Pagination -->
                    <CustomerTablePagination :totalResult="customerlist" :pagemeta="meta" />

                    <div class="uk-first-column">
                        <div class="uk-margins">
                            <button class="uk-button uk-background-red uk-light uk-icon uk-align-right uk-margin-remove-bottom"><span uk-icon="icon: ban;" class="uk-icon"></span> Hide </button>
                        </div>
                    </div>

               </div>                
            </div>
           
        </div>
        
      </form>
      <!-- Form -->
   </div>
</div>
</template>


<script>
import CustomerTable from './CustomerTable'
import CustomerTablePagination from './CustomerTablePagination'
import axios from 'axios'

export default {
    
    components: {
        CustomerTable,
        CustomerTablePagination,
    },

    data () {
        return {
            customerlist: undefined,
            links: {
                first: null,
                last: null,
                next: null,
                prev: null,
            },
            meta: null,

            displayOptions: [5,10,15],

            selected: null,

            headers : [
                {
                    key: 'name',
                    title: 'Name',
                },
                {
                    key: 'company',
                    title: 'Company',
                },
                {
                    key: 'phone_number',
                    title: 'Phone Number',
                },
                {
                    key: 'address',
                    title: 'Address',
                }
            ]
        }
    },

    //use mounted so vue has already rendered the view/html and we can get the data on the display
    mounted() {
        this.getCustomers()
    },

    methods: {
      getCustomers() {
        console.log("this selected "+ this.selected)
        axios.get('/customer/list', {
            headers: { Authorization: 'Bearer '+this.$store.state.token, },
            params: { numOfItems: this.selected ? this.selected : 5 }
        })
        //deconstruction
        .then( ({data}) => {
            // console.log(data)
            this.customerlist = data.data
            this.links = data.links
            this.meta = data.meta
        })
        .catch( (response) => {
            console.log(response)
        })
      }
    }
}


</script>


<style>
.customer-list {
    height: 200px;
    width: auto;
    overflow: auto;
}

.uk-table th {
 text-align: center;
}

.uk-background-red {
    background-color: red;
}

.displayCount {
    float: right;
}

</style>