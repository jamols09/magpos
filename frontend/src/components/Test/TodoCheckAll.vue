<template>
    <div><input type="checkbox" :checked="checkbox" @change="allChecked"><label>All</label></div>
</template>

<script>
export default {
    name: 'todo-checkall',
    props: {
        checkbox: {
            type: Boolean,
            required: true,
        }
    },

    methods: {
        allChecked() {
            this.$eventBus.$emit('checkAllChanged', this.checkbox)
        }
    }
}
</script>