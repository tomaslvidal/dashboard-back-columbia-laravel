<template>
		<b-col class="question-answer py-1" cols="12" sm="6" md="4">
			<b-row>
				<b-col cols="12" sm="6" md="4" xl="4">
					<label class="mr-sm-2" :for="'question-'">Respuesta {{key_}}</label>
				</b-col>

				<b-col cols="12" sm="6" md="8" xl="8">
					<b-form-input v-model="item.value" required type="text" placeholder="Escribir respuesta" :id="'question-'+key_"></b-form-input>
				</b-col>
			</b-row>
		</b-col>
</template>

<script>
export default {
	props: ['item', 'model', 'key_'],
	data(){
		return {
			show: true,
			answers: {
			}
		}
	},
	watch: {
		'model.numberAnswers': function (newVal, oldVal){
			oldVal = Number(oldVal);

			newVal = Number(newVal);

			if((oldVal-newVal)>0){
				for (let i = oldVal; i > newVal; i--) {
					this.$delete(this.item.questions, i);
				}
			}
			else{
				for (let i = oldVal; i < newVal; i++) {
					this.$set(this.item.questions, i+1, {
						text: '',
						numberAnswers: null,
						type_question: null
					})

					this.$set(this.item.questions[i+1], 'answers', {})
				}
			}
		}
	},
	methods: {
	}
}
</script>
