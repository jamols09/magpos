<template>
  <div>
        <input type="checkbox" v-model="completed" @change="save">
        <div @dblclick="editstate=true" v-if="!editstate" :class="{ completed : completed }">   
        {{title}}
        </div>
        <input v-else type="text" v-model="title" @blur="save" @keyup.enter="save" v-focus>
        <div>
            <button @click="pluralize">Plural</button>
            <span class="close" @click="removeItem(index)">&times;</span>
        </div>
  </div>
</template>

<script>
export default {
    name: 'todoitems-vue',
    props: {
        todo: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
        checkAllItems: {
            type: Boolean,  
            required: true,
        }
    },
    //wait for data from parent component, watch props
    watch: {
        checkAllItems() {
            this.completed = this.checkAllItems ? true : this.todo.completed
        }
    },

    directives: {
        focus: {
            inserted (el) {
                el.focus()
            }
        }
    },
    
    
    data() {
        //take props as data
        return {
            'id': this.todo.id,
            'title': this.todo.title,
            'completed': this.todo.completed,
            'editstate': this.todo.editstate,
            'titleCache': '',
        }
    },

    created () {
        this.$eventBus.$on('pluralize', this.handlePluralize)
    },

    methods: {
        removeItem(index) {
            this.$eventBus.$emit('removeItem', index) //$emit
        },
        save() {
            this.titleCache = this.title
            if(this.title.length <= 0) {
                this.title = this.titleCache
            }
            this.editstate = false,
            this.$eventBus.$emit('emit_save', {         //send data to parent (emit), parent should listen for event
                'index': this.index,
                'todo': {
                    'id': this.id,
                    'tite': this.title,
                    'completed': this.completed,
                    'editstate': this.editstate
                }
            })
        },
        pluralize() {
            this.$eventBus.$emit('pluralize');
        },
        handlePluralize() {
            this.title = this.title + 's';
            this.$emit('emit_save', {         //send data to parent (emit), parent should listen for event
                'index': this.index,
                'todo': {
                    'id': this.id,
                    'tite': this.title,
                    'completed': this.completed,
                    'editstate': this.editstate
                }
            })
        }
    }
}
</script>

<style>

.close {
    cursor: pointer;
}
.completed {
    text-decoration-line: line-through;
}
</style>