<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <!-- <h2>Ingreso</h2> -->

                <form @submit.prevent="login(user)">
                    <div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Escribe tu email" v-model="user.email">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Escribe tu contraseña" v-model="user.password">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary">Ingresar</button>

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
            login(user) {
                this.$store.dispatch('Accounts/ENTER_ACCOUNT', user);
            }
        },
    }
</script>

<style>
.text-left {
    justify-content: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
/*
.div-general{
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}*/

</style>