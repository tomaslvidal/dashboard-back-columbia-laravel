<template>
	<div>
		<h4>Encuesta{{item.id ? ' '+item.id : null}}</h4>

		<hr>

		<b-form @submit="onSubmit" v-if="show">
			<div class="d-flex flex-column">
				<b-row class="select-number-questions mb-3">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="name">Nombre de encuesta</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-input required type="text" v-model="item.name" placeholder="Escribir nombre de la encuesta" id="name"></b-form-input>
					</b-col>
				</b-row>

				<b-row class="select-state mb-3">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="state">Estado</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-select required v-model="item.state" id="state" :options="[
							{
								value: '1',
								text: 'Activo'
							},
							{
								value: '0',
								text: 'Inactivo'
							}
						]">
							<option slot="first" :value="null">Elegir...</option>
						</b-form-select>
					</b-col>
				</b-row>

				<b-row class="select-number-questions">
					<b-col cols="12" sm="3" md="2" xl="2">
						<label class="mr-sm-2" for="numberQuestions">Cantidad de preguntas</label>
					</b-col>

					<b-col cols="12" sm="9" md="10" xl="10">
						<b-form-select required v-model="model.numberQuestions" :options="lists.numberQuestions" id="numberQuestions">
							<option slot="first" :value="null">Elegir...</option>
						</b-form-select>
					</b-col>
				</b-row>

				<div class="div-questions" v-if="model.numberQuestions!=null">
					<hr>

					<survey-question :item="item.survey_fields[index_question-1]" :class_="index_question==model.numberQuestions ? '' : 'mb-3'" :lists="lists" :key_="index_question" :key="index_question" v-for="index_question in Number(model.numberQuestions)"/>
				</div>
			</div>

			<hr>

			<b-progress v-if="progress.status" :max="progress.max" animated>
				<b-progress-bar :label="progress.label" :variant="progress.variant" :value="progress.value" />
			</b-progress>

			<br v-if="progress.status">

			<b-button type="submit" variant="primary" :disabled="disabledCreate">Crear</b-button>
		</b-form>
	</div>
</template>

<script>
export default {
	components: {
		'survey-question': require('./components/question.vue'),
	},
	created(){
		this.$store.dispatch('Breadcrumb/SET_ITEMS', [{
			text: 'Inicio',
			to: {name: 'home'}
		}, {
			text: 'Encuestas',
			to: {name: 'surveys'}
		}, {
			text: 'Crear',
			active: true
		}]);

		for (let i = 1; i <= 15; i++){
			this.lists.numberAnswers.push(
			{
				value: i.toString(),
				text: i.toString()
			});

			this.lists.numberQuestions.push(
			{
				value: i.toString(),
				text: i.toString()
			});
		}
	},
	watch: {
		'model.numberQuestions': function (newVal, oldVal){
			oldVal = Number(oldVal);

			newVal = Number(newVal);

			if((oldVal-newVal)>0){
				for (let i = oldVal; i >= newVal; i--) {
					this.$delete(this.item.survey_fields, i);
				}
			}
			else{
				for (let i = oldVal; i < newVal; i++) {
					if(!this.item.survey_fields[i]){
						this.$set(this.item.survey_fields, i, {
							name: "",
							type: null,
						});

						this.$set(this.item.survey_fields[i], 'survey_options', []);
					}
				}
			}
		}
	},
	data(){
		return {
			show: true,
			item: {
				survey_fields:[],
				state: null
			},
			progress: {
				status: false,
				value: 0,
				variant: "primary",
				max: 99,
				label: "0"
			},
			disabledCreate: false,
			model: {
				numberQuestions: null
			},
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
	methods: {
		resetSaveProgress(){
			this.progress.value = 0;

			this.progress.variant = 'primary';
		},
		onSubmit(evt){
			evt.preventDefault();

			this.progress.status = false;

			this.$nextTick( () => { this.resetSaveProgress(); this.progress.status = true });

			const config = {
				onUploadProgress: (progressEvent) => {
					let percentCompleted = Math.round((progressEvent.loaded * 99) / progressEvent.total);

					this.progress.label = percentCompleted.toString();

					this.progress.value = percentCompleted;
				}
			};

			['id', 'created_at'].forEach(e => delete this.item[e]);

			axios.post('/api/surveys', JSON.parse(JSON.stringify(this.item)), config)
			.then((res)=>{
				setTimeout( () => {
					this.progress.variant = "success";

					this.progress.label = "Su registro fue creado con éxito";

					this.item.id = res.data.id;

					this.item.created_at = res.data.created_at;

					this.disabledCreate = true;

					this.$store.dispatch('Surveys/ADD_ITEM', JSON.parse(JSON.stringify(this.item)));

					setTimeout( () => {
						this.$router.push({name: 'surveys'}); // this.$router.go(-1);
					}, 1500);
				}, 1000);
			})
			.catch(()=>{
				setTimeout( () => {
					this.progress.variant = 'danger';

					this.progress.label = "El registro no pudo ser creado"
				}, 1000);
			});
		}
	}
}
</script>