<template>
   <!-- Table List -->
   <div>  
        <table class="uk-table uk-table-hover uk-table-divider">
            <caption>Customer List</caption>
            <thead>
                <tr>
                    <th></th>
                    <th v-for="header in headersProp" :key="header.index"> 
                        {{header.title}}
                    </th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="customer in customerProp" :key="customer.index">
                <td><input type="checkbox" ></td>
                <td v-for="item in headersProp" :key="item.index">{{ customer[item.key] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {    
    name: 'customerTable',
    
    props: ['customerProp','headersProp'],
    
}
</script>

<style>

</style>