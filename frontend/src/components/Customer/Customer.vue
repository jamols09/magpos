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
                <!-- List -->
                <table class="uk-table uk-table-hover uk-table-divider">
                    <caption>Customer List</caption>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Company</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="uk-checkbox js-indeterminate" type="checkbox"></td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                        </tr>
                        <tr>
                            <td><input class="uk-checkbox js-indeterminate" type="checkbox"></td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                            <td>Table Data</td>
                        </tr>
                    </tbody>
                </table>
                <div class="uk-first-column">
                    <div class="uk-margins">``
                        <ul class="uk-pagination uk-flex-center" uk-margin>
                            <li><a href="#"><span uk-pagination-previous></span></a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#"><span uk-pagination-next></span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="uk-first-column">
                    <div class="uk-margins">
                     <button class="uk-button uk-background-red uk-light uk-icon uk-align-right uk-margin-remove-bottom"><span uk-icon="icon: ban;" class="uk-icon"></span> Hide </button>
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
import axios from 'axios'

const getCustomers = (page,callback) => {
    const params = { page };
    axios.get('/customer/list', { 
        headers: { Authorization: 'Bearer '+ localStorage.getItem('access_token') },
        params
        })
        .then(response => {
            console.log(response.data);
            callback(null,response.data);
        }).catch(error => {
            callback(error, error.response.data);
        });
};

export default {

   data() {
        return {
            customers: null,
            meta: null,
            links: {
                first: null,
                last: null,
                next: null,
                prev: null,
            },
            error: null,
        };
    },

    // if they only change the route parameters (?page=2) 
    // then vue won't trigger beforeRoutEnter, as it will re-use the existing component. 
    // It does however trigger beforeRouteUpdate in that scenario.

    beforeRouteEnter(to, from, next) {
        getCustomers(to.query.page, (err, data) => {
            next(vm => vm.setData(err,data));
        });
    },


    beforeRouteUpdate (to, from, next) {
        this.customers = this.links = this.meta = null
        getCustomers(to.query.page, (err, data) =>  {
            this.setData(err, data);
            next();
        });
    },

   
    methods: {
        setData(err, { data: customers, links, meta }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.customers = customers;
                this.links = links;
                this.meta = meta;
            }
        },
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
</style>