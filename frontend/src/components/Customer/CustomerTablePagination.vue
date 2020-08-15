<template>
   <div class="uk-first-column">
        <div class="uk-margins">
            <ul class="uk-pagination uk-flex-center" uk-margin>
                <li><a href="#"><span uk-pagination-previous></span><span uk-pagination-previous></span></a></li>
                <li><a href="#"><span uk-pagination-previous></span></a></li>
                <li v-if="pagemeta"><span> of {{totalPage}}</span></li>
                <li><a href="#"><span uk-pagination-next></span></a></li>
                <li><a href="#"><span uk-pagination-next></span><span uk-pagination-next></span></a></li>
            </ul>

        </div>

    </div>
</template>

<script>
export default {
    props: ['totalResult', 'pagemeta'],
    data () {
        return {
            page: 1,

        }
    },

    computed: {
        totalPage() {
            return this.pagemeta.last_page
        }
    },
}
</script>

<style>

</style>