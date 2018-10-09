<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <!-- <h2>Registro</h2> -->

                <form @submit.prevent="register(user)">
                    <div>
                        <div class="form-group" :class="{ 'has-error': errors.name.length }">
                            <label for="name">Nombre</label>

                            <input type="text" class="form-control" id="name" placeholder="Escribir un nombre" v-model="user.name">

                            <p class="help-block">{{ errors.name[errors.name.length-1] }}</p>
                        </div>

                        <div class="form-group" :class="{ 'has-error': errors.last_name.length }">
                            <label for="last_name">Apellido</label>

                            <input type="last_name" class="form-control" id="last_name" placeholder="Escribir un apellido" v-model="user.last_name">

                            <p class="help-block">{{ errors.last_name[errors.last_name.length-1] }}</p>
                        </div>

                        <div class="form-group" :class="{ 'has-error': errors.email.length }">
                            <label for="email">Email</label>

                            <input type="email" class="form-control" id="email" placeholder="Escribir un email" v-model="user.email">

                            <p class="help-block">{{ errors.email[errors.email.length-1] }}</p>
                        </div>

                        <div class="form-group" :class="{ 'has-error': errors.password.length }">
                            <label for="password">Contraseña</label>

                            <input type="password" class="form-control" id="password" placeholder="Escribir una contraseña" v-model="user.password">

                            <p class="help-block">{{ errors.password[errors.password.length-1] }}</p>
                        </div>

<!--                         <div class="form-group" :class="{ 'has-error': errors.password_confirmation.length }">
                            <label for="password_confirmation">Repetir contraseña</label>

                            <input type="password" class="form-control" id="password_confirmation" placeholder="Repetir tu contraseña" v-model="user.password_confirmation">

                            <p class="help-block">{{ errors.password_confirmation[errors.password_confirmation.length-1] }}</p>
                        </div> -->
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary">Registrar</button>
                        
                        <router-link class="btn btn-default" :to="{ name: 'index' }">
                            Inicio
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: null,
                    last_name: null,
                    email: null,
                    password: null,
                },
                errors: {
                    name: [],
                    last_name: [],
                    email: [],
                    password: [],
                },
            }
        },
        methods: {
            resetUser() {
                this.user = {
                    name: null,
                    last_name: null,
                    email: null,
                    password: null,
                }
            },
            register(user) {
                axios.post("/api/users", user)
                    .then(response => {
                        this.resetUser()

                        let successMessage = response.data.message

                        alert(successMessage)
                    })
                    .catch(error => {
                        let data = error.response.data.errors;


                        for(let key in this.errors) {
                            // reset all errors
                            this.errors[key] = []

                            if(data[key]!=undefined){
                                this.errors[key] = data[key]
                            }
                        }
                    })
            }
        },
    }
</script>
