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
				>
					{{ field.label }}
				</form-field>

				<form-select
					v-if="field.type == 'select'"
					:ref="field.name"
					:required="field.required"
				/>

				<form-files
					v-if="field.type == 'files'"
					:ref="field.name"
					:required="field.required"
					:max="field.max"
				/>

				<form-checkbox
					v-if="field.type == 'checkbox'"
					:ref="field.name"
					:required="field.required"
				>
					{{ field.label }}
				</form-checkbox>

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

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

// Components
import FormField from '../elements/FormField.vue';
import FormFiles from '../elements/FormFiles.vue';
import FormSelect from '../elements/FormSelect.vue';
import FormCheckbox from '../elements/FormCheckbox.vue';
import FormHiddenField from '../elements/FormHiddenField.vue';

export default {
	components: {
		FormField, FormFiles, FormSelect, FormCheckbox, FormHiddenField
	},

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
		...mapActions({
			openToast: 'toast/open',
		}),

		resetForm() {
			for (let refName in this.$refs) {
				this.$refs[refName][0].value = '';
			}
		},

		submitForm() {
			this.isFormValid = true;

			let formData = new FormData();
			let axiosConfig = {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			};

			// Validate all fields
			for (let refName in this.$refs) {
				let ref = this.$refs[refName][0];

				if (!ref.validate()) {
					this.isFormValid = false;
				}

				// Value is an array
				if (ref.value instanceof Array) {
					ref.value.forEach((refElement, index) => {
						// If elements of array are files add them to formData
						if (refElement instanceof File) {
							formData.append(refName + '[' + index + ']', refElement);
						}
					});
				}

				// Regular value
				else {
					formData.append(refName, ref.value);
				}
			}


			// Check if all fields are valid and fire API call
			if (this.isFormValid) {
				axios.post(this.uri, formData, axiosConfig)
					.then(result => {

						// Check if there are errors in response
						if (result.data.errors && result.data.errors.length) {

							// Fire error hook
							if (typeof this.error === 'function') {
								this.error(result);
							}

							// Or show toast message
							else {
								console.warn('Api call responded with errors:');
								console.log(result.data.errors);

								let errorMessages = result.data.errors.map(error => error.message).join('<br>');
								this.openToast('<small>This action caused the following error:</small><br>' + errorMessages);
							}
						}

						// Fire success hook
						else if (typeof this.success === 'function') {
							this.success(result.data);
						}

						// Open toast if there is no success hook
						else {
							this.openToast('Submitting <em>"' + this.title + '"</em> form was successful.');
						}
					})
					.catch(error => {
						console.warn('Api call error:');
						console.log(error);

						// Fire error hook
						if (typeof this.error === 'function') {
							this.error(error);
						}
						else {
							this.openToast('<small>Api call failed</small><br>' + error);
						}
					});
			}
		}
	},
}

</script>
