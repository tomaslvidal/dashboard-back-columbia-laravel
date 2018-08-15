<template>
  <div>
  	Users
  </div>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Users.request_made==false){
			this.$store.dispatch('Users/FETCH_USERS');
		}
	}
}
</script>