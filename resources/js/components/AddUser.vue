<template>
    <div>
        <h4 class="text-center">Add User</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="text" class="form-control" v-model="user.email">
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" v-model="user.password">
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <select class="form-select" aria-label="Default select example" v-model="user.role">                            
                            <option value="suscriber">Suscriber</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Add User</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {},
            name: null,
            id: null
        }
    },
    created() {
        if (window.Laravel.user) {
            this.id = window.Laravel.user.id
            this.name = window.Laravel.user.name
            this.user.user_id = this.id
            this.user.author = this.name
        }
    },
    methods: {
        addUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/users/add', this.user)
                    .then(response => {
                        this.$router.push({name: 'users'})
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