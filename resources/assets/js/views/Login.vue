<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-2">
                <div class="text-center">
                    <img src="//www.columbiaviajes.com.ar/img/columbia-logo.png" alt="Columbia Viajes">
                </div>
                <form @submit.prevent="login">
                    <div>
                        <div class="form-group">
                            <label for="email">Email</label>

                            <input type="email" class="form-control" id="email" placeholder="Escribe tu email" v-model="user.email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>

                            <input type="password" class="form-control" id="password" placeholder="Escribe tu contraseña" v-model="user.password" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Ingresar</button>

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
                    email: null,
                    password: null,
                },
            }
        },
        methods: {
            login(user){
                this.$store.dispatch('Accounts/ENTER_ACCOUNT', this.user);
            }
        },
    }
</script>

<style scoped>
.text-left {
    justify-content: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
form{
    padding: 10px;
    background: #f3f3f3;
    margin-top: 10px;
    border-radius: 10px;
}
</style>