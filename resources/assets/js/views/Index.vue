<template>
  <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="text-center">
                    <router-link :to="{ name: 'register' }" class="btn btn-default">
                        Registrar Test
                    </router-link>

                    <router-link :to="{ name: 'login' }" class="btn btn-default">
                        Ingresar
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
