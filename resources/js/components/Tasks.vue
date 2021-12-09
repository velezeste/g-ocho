<template>
    <div>      
        <h4 class="text-center">All Tasks</h4><br/>
        <input class="form-control" id="myInput" type="text" placeholder="Search..">        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tarea</th>
                <th>Detalles</th>
                <th>Creado el</th>
                <th>Finaliza el</th>
                <th>Actualizado el</th>
                <th>Autor</th>
                <th>Estado</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="myTable">
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.id }}</td>
                <td>{{ task.task }}</td>
                <td>{{ task.detail }}</td>
                <td>{{ task.created_at }}</td>
                <td>{{ task.dataEnd }}</td>
                <td>{{ task.updated_at }}</td>
                <td>{{ task.author }}</td>
                <td v-if="task.state == true">Activo</td>
                <td v-else>Inactivo</td>
                <td>
                    <div class="btn-group" role="group" v-show="task.author == name || role == 'admin'">
                        <router-link :to="{name: 'edittask', params: { id: task.id }}" class="btn btn-primary">Editar
                        </router-link>
                        <button class="btn btn-danger" @click="deleteTask(task.id)">Eliminar</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-info" @click="this.$router.push('/tasks/add')">Add Task</button>
    </div>
</template>

<script>
import $ from 'jquery'
export default {    
    data() {
        return {
            tasks: [],
            name: null,
            role: null,            
        }
    },    
    created() {
        this.name = window.Laravel.user.name
        this.role = window.Laravel.user.role
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteTask(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/tasks/delete/${id}`)
                    .then(response => {
                        let i = this.tasks.map(item => item.id).indexOf(id); // find index of your object
                        this.tasks.splice(i, 1)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    mounted () {
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    },    
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>