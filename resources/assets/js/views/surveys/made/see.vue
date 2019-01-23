<template>
	<div v-if="Object.keys(item).length>0">
		<h4>Encuesta realizada{{item.id!='' ? ' '+item.id+": "+item.survey.name : ''}}</h4>

		<hr>

		<b-form v-if="show">
			<div class="d-flex flex-column">
				<b-row class="select-number-questions mb-3">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="name">Nombre del usuario</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-input readonly type="text" :value="item.user.name+' '+item.user.last_name" id="user_name"></b-form-input>
					</b-col>
				</b-row>

				<b-row class="select-number-questions mb-3">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="name">Email del usuario</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-input readonly type="text" :value="item.user.email" id="user_email"></b-form-input>
					</b-col>
				</b-row>

				<b-row class="select-number-questions mb-3">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="name">Telefono</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-input readonly type="text" :value="item.user.telephone" id="user_telephone"></b-form-input>
					</b-col>
				</b-row>

				<b-row class="select-number-questions">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="name">Fecha del registro</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-input readonly type="text" :value="item.created_at" id="created_at"></b-form-input>
					</b-col>
				</b-row>

				<div class="div-questions">
					<hr>

					<div class="mb-3" :id="'question-number-'+index_question" :key="index_question" v-for="index_question in item.survey_made_fields.length">
						<b-row class="question-text">
							<b-col cols="12" sm="3" md="2" xl="2">
								<label class="mr-sm-2" :for="'questions-'+index_question">Pregunta {{index_question}}</label>
							</b-col>

							<b-col cols="12" sm="9" md="10" xl="10">
								<b-form-input readonly type="text" :value="item.survey_made_fields[index_question-1].survey_field.name" :id="'questions-'+index_question"></b-form-input>
							</b-col>
						</b-row>

						<b-row class="question-build my-2">
							<b-col class="question-type" cols="12" sm="6" md="6" xl="6">
								<b-row>
									<b-col cols="12" sm="6" md="4" xl="4">
										<label class="mr-sm-2" :for="'type-question-'">Tipo de pregunta</label>
									</b-col>

									<b-col cols="12" sm="6" md="8" xl="8">
										<b-form-input readonly type="text" :value="lists.typesQuestions[item.survey_made_fields[index_question-1].survey_field.type-1].text" :id="'type_questions-'+index_question"></b-form-input>
									</b-col>
								</b-row>
							</b-col>
						</b-row>

						<b-row class="answers-build my-2" v-if="item.survey_made_fields[index_question-1].survey_made_options.length>0">
							<b-col class="div-answers" cols="12" sm="6" md="6" xl="6">
								<b-row>
									<b-col cols="12" sm="6" md="4" xl="4">
										<label class="mr-sm-2" :for="'answers-'+index_question">{{ item.survey_made_fields[index_question-1].survey_field.type==1 ? 'Respuestas' : 'Respuesta'}}</label>
									</b-col>

									<b-col cols="12" sm="6" md="8" xl="8">
										<div v-if="item.survey_made_fields[index_question-1].survey_field.type==1" class="my-1" :key="index_answer" v-for="index_answer in item.survey_made_fields[index_question-1].survey_made_options.length">
											<b-form-input readonly type="text" :value="item.survey_made_fields[index_question-1].survey_made_options[index_answer-1].survey_option.value" :key="index_answer">
											</b-form-input>
									  	</div>

										<div v-if="item.survey_made_fields[index_question-1].survey_field.type==2" class="my-1">
											<b-form-input readonly type="text" :value="item.survey_made_fields[index_question-1].survey_made_options[0].survey_option.value">
											</b-form-input>
									  	</div>

										<div v-else-if="item.survey_made_fields[index_question-1].survey_field.type==3" class="my-1" :key="index_answer" v-for="index_answer in item.survey_made_fields[index_question-1].survey_made_options.length">
											<b-form-input readonly type="text" :value="item.survey_made_fields[index_question-1].survey_made_options[index_answer-1].free_response" :key="index_answer">
											</b-form-input>
										</div>
									</b-col>
								</b-row>
							</b-col>
						</b-row>
					</div>
				</div>
			</div>

			<hr>

		</b-form>
	</div>
</template>

<script>
export default {
	created(){
		this.$store.dispatch('SurveysMade/GET_ITEM', { "id" : this.$route.params.id});

		this.$store.dispatch('Breadcrumb/SET_ITEMS', [
		{
			text: 'Inicio',
			to: {name: 'home'}
		}, 
		{
			text: 'Encuestas Realizadas',
			to: {name: 'surveys_made'}
		}, 
		{
			text: 'Ver',
			active: true
		}
		]);
	},
	data(){
		return {
			show: true,
			lists: {
				typesQuestions: [
					{
						value: 1,
						text: 'Opción Múltiple'
					},
					{
						value: 2,
						text: 'Respuesta Única'
					},
					{
						value: 3,
						text: 'Respuesta Libre'
					}
				],
				numberAnswers: [],
				numberQuestions: []
			}
		}
	},
	destroyed(){
		this.$store.dispatch('SurveysMade/CLEAR_ITEM');
	},
	computed: {
		item(){
			return this.$store.state.SurveysMade.item;
		}
	},
	methods: {

	}
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