<template>
    <div>
        <h4 class="text-center">Add Task</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addTask">
                    <div class="form-group">
                        <label>Tarea</label>
                        <input type="text" class="form-control" v-model="task.task">
                    </div>
                    <div class="form-group">
                        <label>Detalles</label>
                        <input type="text" class="form-control" v-model="task.detail">
                    </div>
                    <div class="form-group">
                        <label>Finaliza el</label>
                        <input type="datetime-local" class="form-control" v-model="task.dataEnd">
                    </div>
                    <div class="form-group">
                        <label>Id Autor</label>
                        <input type="text" class="form-control" v-model="task.user_id" disabled>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="task.author" disabled>
                    </div>
                    <div class="form-check form-switch">
                        <label>Estado</label>
                        <input type="checkbox" class="form-check-input" v-model="task.state" checked>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            task: {},
            name: null,
            id: null
        }
    },
    created() {
        if (window.Laravel.user) {
            this.id = window.Laravel.user.id
            this.name = window.Laravel.user.name
            this.task.user_id = this.id
            this.task.author = this.name
        }
    },
    methods: {
        addTask() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/tasks/add', this.task)
                    .then(response => {
                        this.$router.push({name: 'tasks'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>