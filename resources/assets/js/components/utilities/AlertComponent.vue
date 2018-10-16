<template>
	<b-alert :variant="variant" :show="dismissCountDown" @dismissed="dismissCountDown" @dismiss-count-down="countDownChanged">
		<slot v-if="showProgress"></slot><div v-if="showProgress!=true">{{this.textUpdate}}</div>

		<b-progress v-if="showProgress" :max="dismissSecs" :value="dismissCountDown" height="4px" />
	</b-alert>
</template>

<script>
export default{
	props: ['textUpdate'],
	data(){
		return {
			dismissSecs: 2,
			dismissCountDown: 2,
			showDismissibleAlert: true,
			showProgress: true,
			variant: null
		}
	},
	methods:{
		countDownChanged (dismissCountDown){
			this.dismissCountDown = dismissCountDown

			if(dismissCountDown==0){
				this.dismissCountDown = 3600;

				this.variant = "success";

				this.showProgress = false;
			}
		},
		showAlert(){
			this.dismissCountDown = this.dismissSecs
		}
	}
}
</script>