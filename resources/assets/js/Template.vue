<template>
    <component :is="layout">      
      <router-view/>
    </component>
</template>

<script>
const default_layout = "default";

export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + "-layout";
    }
  },

  // created() {
  //   console.log(this.$route, this.$route.meta.layout);
  // },

  // updated() {
  //   console.log(this.$route, this.$route.meta.layout);
  // }
};
</script>