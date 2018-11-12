<template>
	<div v-if="show" :id="'question-number-'+key_" :class="class_">
		<b-row class="question-text my-2">
			<b-col cols="12" sm="3" md="2" xl="2">
				<label class="mr-sm-2" :for="'questions-'+key_">Pregunta {{key_}}</label>
			</b-col>

			<b-col cols="12" sm="9" md="10" xl="10">
				<b-form-input required type="text" v-model="item.name" placeholder="Escribir pregunta" :id="'questions-'+key_"></b-form-input>
			</b-col>
		</b-row>

		<b-row class="question-build my-2">
			<b-col class="question-type my-2" cols="12" sm="6" md="6" xl="6">
				<b-row>
					<b-col cols="12" sm="6" md="4" xl="4">
						<label class="mr-sm-2" :for="'type-question-'">Tipo de pregunta</label>
					</b-col>

					<b-col cols="12" sm="6" md="8" xl="8">
						<b-form-select required :id="'type-question-'" v-model="item.type" :options="lists.typesQuestions">
							<option slot="first" :value="null">Elegir...</option>
						</b-form-select>
					</b-col>
				</b-row>
			</b-col>
			<b-col class="question-number-answers my-2" v-if="item.type == 1 || item.type == 2" cols="12" sm="6" md="6" xl="6">
				<b-row>
					<b-col cols="12" sm="6" md="4" xl="4">
						<label class="mr-sm-2" :for="'number-answers-of-'">N° de respuestas</label>
					</b-col>

					<b-col cols="12" sm="6" md="8" xl="8">
						<b-form-select required :id="'number-answers-of-'" v-model="model.numberAnswers" :options="lists.numberAnswers">
							<option slot="first" :value="null">Elegir...</option>
						</b-form-select>
					</b-col>
				</b-row>
			</b-col>
		</b-row>

		<b-row class="question-answers my-2" v-if="model.numberAnswers!=null && (item.type == 1 || item.type == 2)">
			<survey-answer :item="item.survey_options[index_answer-1]" :key_="index_answer" :key="index_answer" v-for="index_answer in Number(model.numberAnswers)" />
		</b-row>
	</div>
</template>

<script>
export default {
	components: {
		'survey-answer': require('./answer.vue')
	},
	props: ['item', 'lists', 'key_', 'class_'],
	data(){
		return {
			show: false,
			state: {
				checkNumberAnswers: false
			},
			model: {
				numberAnswers: null
			}
		}
	},
	beforeMount(){
		if(!this.state.checkNumberAnswers){
			if(this.item.survey_options){
				this.model.numberAnswers = this.item.survey_options.length == 0 ? null : this.item.survey_options.length;

				this.show = true; this.state.checkNumberAnswers = true;
			}
		}
	},
	watch: {
		'model.numberAnswers': function (newVal, oldVal){
			oldVal = Number(oldVal);

			newVal = Number(newVal);

			if((oldVal-newVal)>0){
				for (let i = oldVal; i >= newVal; i--) {
					this.$delete(this.item.survey_options, i);
				}
			}
			else{
				for (let i = oldVal; i < newVal; i++) {
					if(!this.item.survey_options[i]){
						this.$set(this.item.survey_options, i, {
							value: '',
							survey_field_id: this.item.survey_id
						})
					}
				}
			}
		},
		'item.type': function (newVal){
			newVal = Number(newVal);

			if(newVal==3){
				this.model.numberAnswers = null;
				
				this.$set(this.item, 'survey_options', []);
			}
		}
	},
}
</script>

<style scoped>
	.question-text [for*='questions-'] {
		font-size: 17px;
		font-weight: 500;
	}

	[id*='question-number'] {
		background-color: #f1f1f1;
		padding: 10px;
		border-radius: 4px;
	}
</style>