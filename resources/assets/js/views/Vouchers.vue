<template>
  <div>
    Vouchers
  </div>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Vouchers.request_made==false){
			this.$store.dispatch('Vouchers/FETCH_VOUCHERS');
		}
	}
}
</script>