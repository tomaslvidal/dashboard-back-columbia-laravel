<template>
  <div id="app">
<!--     <div class="d-flex justify-content-center">
      <router-link :to="{ name: 'index' }"><img src="/img/logo.png" style="height: 200px; margin-left: -15px;"></router-link>
    </div> -->

    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app',
  mounted(){
    let body = document.querySelector('body'); 

    if(body.classList){
      body.removeAttribute("class");
    }
  }
}
</script>

<style>
#app {
  color: #787878;
  margin-top: 60px;
  background-color: #FFF;
}
</style>