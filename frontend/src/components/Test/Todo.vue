<template>
  <div>
      <input type="text" class="input" v-model="todoTitle" @keyup.enter="addItem">

      <TodoItemsFile v-for="(todo,index) in selectedFilter" :key="todo.id" :todo="todo" :index="index"
      :checkAllItems="checkbox"
      class="item"/>

      <div class="todo-container">
          <TodoCheckAll :checkbox="checkbox"/>
          <TodoItemsRemaingFile :remaining="remaining" />
      </div>
      
      <div class="todo-container">
          <TodoFilter/>
      </div>
  </div>
</template>

<script>
import TodoItemsFile from './TodoItems'
import TodoCheckAll from './TodoCheckAll'
import TodoItemsRemaingFile from './TodoItemsRemaining'
import TodoFilter from './TodoFilter'

export default {
    name: 'todo',
    components: {
        TodoItemsFile,
        TodoItemsRemaingFile,
        TodoCheckAll,
        TodoFilter,
    },
    data() {
        return {
            idTodo: 0,
            titleCache: '',
            todoTitle: '',
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
        }
    },
    created() {
        this.$eventBus.$on('removeItem', (index) => this.removeItem(index))
        this.$eventBus.$on('emit_save', (data) => this.emit_save(data))
        this.$eventBus.$on('checkAllChanged', (checkbox) => this.checkAll(checkbox))
        this.$eventBus.$on('filterChange', (filter) => this.$store.state.filter = filter)
    },
    beforeDestroy() {
        this.$eventBus.$off('removeItem', (index) => this.removeItem(index))
        this.$eventBus.$off('emit_save', (data) => this.emit_save(data))
        this.$eventBus.$off('checkAllChanged', (checkbox) => this.checkAll(checkbox))
        this.$eventBus.$off('filterChange', (filter) => this.$store.state.filter = filter)
    },
    computed : {
        remaining() {
            return this.$store.state.todoArr.filter( todoArr => !todoArr.completed ).length
        },
        checkbox() {
            return this.remaining == 0
        },
        selectedFilter() {
            if(this.$store.state.filter === 'all') {
                return this.$store.state.todoArr
            } else if(this.$store.state.filter === 'active') {
                return this.$store.state.todoArr.filter(todoArr => !todoArr.completed)
            } else if(this.$store.state.filter === 'completed') {
                return this.$store.state.todoArr.filter(todoArr => todoArr.completed)
            }

            return this.$store.state.todoArr
        }
    },
    methods: {

        addItem() {
            if(this.todoTitle.length > 0) { //input exists
                this.$store.state.todoArr.push({
                    id:  this.$store.state.todoArr.length + 1,
                    title: this.todoTitle,
                    completed: false,
                })
                this.todoTitle = ''
            }
        },
        removeItem(index) {
            this.$store.state.todoArr.splice(index,1)
        },
        checkAll() {
            if(!this.checkbox) {
                this.$store.state.todoArr.forEach(value => {
                    value.completed = true;
                });
            } else {
                this.$store.state.todoArr.forEach(value => {
                    value.completed = false;
                });
            }
        },
        //emit from TodoItems.vue
        emit_save(data) {
            console.log(data);
            this.$store.state.todoArr.splice(data.index, 1, data.todo)
        }
    }
}
</script>

<style scoped>

.input {
    width: 100%;
    padding: 10px 18px;
    font-size: 18px;
}

.item {
    display: flex;
    padding: 5px;
    justify-content: space-between;
}

.close {
    cursor: pointer;
}

.completed {
    text-decoration-line: line-through;
}

.todo-container {
    display: flex;
    padding: 5px;
    justify-content: space-between;
}

.active {
    background-color: aquamarine;
}
</style>