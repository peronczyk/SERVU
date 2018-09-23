<template>

	<div class="c-FormControl">
		<h3 v-if="title">{{ title }}</h3>

		<form @submit.prevent="submitForm">

			<fieldset v-for="(field, index) in fields" :key="index">

				<form-field
					v-if="field.type == 'text' || field.type == 'password' || field.type == 'email'"
					:type="field.type"
					:ref="field.name"
					:required="field.required"
				>{{ field.label }}</form-field>

				<form-file
					v-if="field.type == 'file'"
					:ref="field.name"
					:required="field.required"
				>{{ field.label }}</form-file>

				<form-select
					v-if="field.type == 'select'"
					:ref="field.name"
					:required="field.required"
				></form-select>

				<form-files
					v-if="field.type == 'files'"
					:ref="field.name"
					:required="field.required"
					:max="field.max"
				></form-files>

				<form-checkbox
					v-if="field.type == 'checkbox'"
					:ref="field.name"
					:required="field.required"
				>{{ field.label }}</form-checkbox>

				<form-hidden-field
					v-if="field.type == 'hidden'"
					:value="field.value"
					:ref="field.name"
				/>

			</fieldset>

			<p class="u-Error" v-if="!isFormValid">
				Please fill in all required fields
			</p>

			<button class="Btn">{{ cta }}</button>
		</form>
	</div>

</template>


<script>

import axios from 'axios';
import FormField from '../elements/FormField.vue';
import FormFiles from '../elements/FormFiles.vue';
import FormSelect from '../elements/FormSelect.vue';
import FormCheckbox from '../elements/FormCheckbox.vue';
import FormHiddenField from '../elements/FormHiddenField.vue';
import queryString from 'querystring';

export default {
	props: {
		fields: {
			type: Array,
			required: true,
		},

		uri: {
			type: String,
			required: true,
		},

		cta: {
			type: String,
			default: 'Send',
		},

		title: {
			type: String,
		},

		// Hook fired when form succesfully receives data
		success: {
			type: Function,
		},

		// Hook fired when form call ends with error
		error: {
			type: Function,
		},
	},

	data() {
		return {
			isFormValid: true,
		}
	},

	methods: {
		resetForm() {
			for (let refName in this.$refs) {
				this.$refs[refName][0].value = '';
			}
		},

		submitForm() {
			this.isFormValid = true;

			let formData    = {};
			let filesData   = new FormData();
			let axiosConfig = {};

			console.info('Form submit');

			// Validate all fields
			for (let refName in this.$refs) {
				let ref = this.$refs[refName][0];

				if (!ref.validate()) {
					this.isFormValid = false;
				}


				console.log(' - ' + refName + ': ' + ref.value);

				if (ref.value instanceof File) {

				}
				else {
					formData[refName] = ref.value;
				}
			}

			// Check if all fields are valid and fire API call
			if (this.isFormValid) {
				let query = queryString.stringify(formData);

				axios.post(this.uri, query)
					.then(result => {
						console.log(result);

						// Check if there are errors in response
						if (result.data.errors && result.data.errors.length) {

							// Fire error hook
							if (typeof this.error === 'function') {
								this.error(result);
							}

							// Or show toast message
							else {
								this.$store.commit('openToast', '<small>This action caused the following error:</small><br>' + result.data.errors[0].message);
							}
						}

						// Fire success hook
						else if (typeof this.success === 'function') {
							this.success(result.data);
						}
					})
					.catch(error => {
						console.warn('Api call error');
						console.log(error);

						// Fire error hook
						if (typeof this.error === 'function') {
							this.error(error);
						}
					});
			}
		}
	},

	components: { FormField, FormFiles, FormSelect, FormCheckbox, FormHiddenField }
}

</script>
