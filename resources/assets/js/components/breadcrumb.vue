<template>
  <b-breadcrumb :items="items"/>
</template>

<script>
export default {
  data () {
    return {
      items: [{
        text: 'Inicio',
        href: '#'
      }]
    }
  }
}
</script>