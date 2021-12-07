<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="https://estevanvelez.com" target="_blank"><img style="width: 20%; margin-bottom: 5px;" src="https://www.ospedale.com.co/wp-content/uploads/2021/08/Logo-G-Ocho-pagina-web123.png"></a><br>
            <span class="text-secondary">CRUD with Laravel and Vue JS</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn">
                    <router-link to="/dashboard" class="nav-item nav-link">Inicio</router-link>
                    <router-link to="/tasks" class="nav-item nav-link">Tareas</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Cerrar Sesión</a>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/" class="nav-item nav-link">Inicio</router-link>
                    <router-link to="/login" class="nav-item nav-link">Iniciar Sesión</router-link>
                    <router-link to="/register" class="nav-item nav-link">Registrarse
                    </router-link>
                    <router-link to="/about" class="nav-item nav-link">Sobre Nosotros</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>