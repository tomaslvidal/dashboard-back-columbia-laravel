<template>
  <div>
  	Destinations
  </div>
</template>

<script>
export default {
	created(){
		if(this.$store.state.Destinations.request_made==false){
			this.$store.dispatch('Destinations/FETCH_DESTINATIONS');
		}

		// let item = {
		// 	id: 10,
		// 	data: {
		// 		description: "daso345",
		// 		subtitle: "asd"
		// 	}
		// }

		// setTimeout(() => {
		// 	this.$store.dispatch('Destinations/UPDATE_DESTINATION', item);
		// }, 10000);
	}
}
</script>