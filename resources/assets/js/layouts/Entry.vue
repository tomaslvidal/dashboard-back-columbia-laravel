<template>
  <div id="app">
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