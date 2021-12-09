<template>
    <div>      
        <h4 class="text-center">All Tasks</h4><br/>
        <input class="form-control mb-2" id="mySearch" type="text" placeholder="Search...">        
        <table id="myTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th @click="sortTable(0)" class="pointer">ID</th>
                <th @click="sortTable(1)" class="pointer">Tarea</th>
                <th @click="sortTable(2)" class="pointer">Detalles</th>
                <th @click="sortTable(3)" class="pointer">Creado el</th>
                <th @click="sortTable(4)" class="pointer">Finaliza el</th>
                <th @click="sortTable(5)" class="pointer">Actualizado el</th>
                <th @click="sortTable(6)" class="pointer">Autor</th>
                <th @click="sortTable(7)" class="pointer">Estado</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="myDatas">
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
        },
        sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                    }
                }
                }
                if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
                } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
                }
            }
        }
    },
    mounted () {
        $(document).ready(function(){
            $("#mySearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myDatas tr").filter(function() {
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