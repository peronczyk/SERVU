<template>

	<div class="c-FormControl">
		<h3 v-if="title">{{ title }}</h3>

		<transition name="fade">
			<form @submit.prevent="submitForm" v-show="formReady">

				<fieldset v-for="(field, index) in fields" :key="index">

					<h4
						v-if="field.type == 'header'"
						v-html="field.value"
					></h4>

					<p
						v-else-if="field.type == 'description'"
						v-html="field.value"
						class="c-FormControl__desc"
					></p>

					<form-field
						v-else-if="field.type == 'text' || field.type == 'password' || field.type == 'email'"
						:type="field.type"
						:name="field.name"
						:ref="field.name"
						:required="field.required"
					>
						{{ field.label }}
					</form-field>

					<form-select
						v-else-if="field.type == 'select'"
						:options="field.options"
						:name="field.name"
						:ref="field.name"
						:required="field.required"
						:change-callback="field.changeCallback"
					>
						{{ field.label }}
					</form-select>

					<form-files
						v-else-if="field.type == 'files'"
						:ref="field.name"
						:required="field.required"
						:max="field.max"
					/>

					<form-checkbox
						v-else-if="field.type == 'checkbox'"
						:ref="field.name"
						:required="field.required"
					>
						{{ field.label }}
					</form-checkbox>

					<form-list
						v-else-if="field.type == 'list'"
						:ref="field.name"
						:required="field.required"
					>
						{{ field.label }}
					</form-list>

					<form-rich
						v-else-if="field.type == 'rich'"
						:ref="field.name"
						:required="field.required"
					>
						{{ field.label }}
					</form-rich>

					<form-hidden-field
						v-else-if="field.type == 'hidden'"
						:value="field.value"
						:ref="field.name"
					/>

					<p
						v-else
						class="u-Info"
					>Unhandled field: {{ field.type }}</p>

				</fieldset>

				<transition name="fade">
					<p class="u-Error" v-if="!isFormValid">
						Please fill in all required fields
					</p>
				</transition>

				<div class="c-FormControl__buttons">
					<button type="submit" class="Btn">{{ cta }}</button>
					<button @click.prevent="resetForm" v-if="!hideReset" type="reset" class="Btn Btn--hollow">Reset</button>
				</div>
			</form>
		</transition>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

// Components
import FormCheckbox from '../elements/FormCheckbox.vue';
import FormField from '../elements/FormField.vue';
import FormFiles from '../elements/FormFiles.vue';
import FormHiddenField from '../elements/FormHiddenField.vue';
import FormList from '../elements/FormList.vue';
import FormRich from '../elements/FormRich.vue';
import FormSelect from '../elements/FormSelect.vue';

export default {
	components: {
		FormField, FormFiles, FormCheckbox, FormList, FormHiddenField, FormRich, FormSelect
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

		// API uri that provides values for this form
		fetchUri: String,

		cta: {
			type: String,
			default: 'Send',
		},

		title: String,

		// Hook fired when form succesfully receives data
		success: Function,

		// Hook fired when form call ends with error
		error: Function,

		// Hide reset button
		hideReset: {
			type: Boolean,
			default: false,
		}
	},

	data() {
		return {
			isFormValid: true,
			isValuesFetched: false,
			fetchedValues: {},
		}
	},

	computed: {
		/**
		 * Defines if the form will edit data or add new one
		 */
		isEditMode() {
			return (this.fetchUri);
		},

		formReady() {
			return (this.isEditMode) ? this.isValuesFetched : true;
		},
	},

	methods: {
		...mapActions({
			openToast: 'toast/open',
		}),

		/**
		 * Reset all the fields values by setting their values to fetched ones
		 * or by invoking reset() method on them
		 */
		resetForm() {
			this.isFormValid = true;

			for (let refName in this.$refs) {
				let ref = this.$refs[refName][0];

				// Set fetched value...
				if (this.fetchedValues[refName] && typeof ref.setValue === 'function') {
					ref.setValue(this.fetchedValues[refName]);
				}

				// ...or hard reset
				else if (ref && typeof ref.reset === 'function') {
					ref.reset();
				}

				else {
					console.warn('Form element' + refName + ' does not have fetched value and "reset" method');
				}
			}
		},

		/**
		 * This method can be invoked by other component to fetch values of each of
		 * the fields from defined apiUrl node.
		 *
		 * @param {String} apiUrl
		 */
		fetchValues() {
			axios.get(this.fetchUri)
				.then(result => {
					this.isValuesFetched = true;

					if (result.data.errors) {
						this.openToast(result.data.errors[0].message);
					}
					else if (!result.data.data) {
						this.openToast('There is no values for this form');
					}
					else {
						this.fetchedValues = result.data.data;
						this.resetForm();
					}
				})
				.catch(error => {
					this.openToast('<small>Faetching form values failed</small><br>');
					console.warn(error);
				});
		},

		/**
		 * Action that sends form data to API
		 */
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
				let ref     = this.$refs[refName][0];
				let isValid = ref.validate();

				if (!isValid) {
					// Prevent changing isFormValid multiple times if there is more
					// than one invalid field
					if (this.isFormValid) {
						this.isFormValid = false;
					}
					continue;
				}

				let fieldValue = ref.getValue();

				// Value is an array
				if (fieldValue instanceof Array) {
					fieldValue.forEach((refElement, index) => {
						// If elements of array are files
						if (refElement instanceof File) {
							formData.append(refName + '[' + index + ']', refElement);
						}
						else if (refElement instanceof Object) {
							for (let elementIndex in refElement) {
								formData.append(refName + '[' + index + '][' + elementIndex + ']', refElement[elementIndex]);
							}
						}
					});
				}

				// Regular value
				else {
					formData.append(refName, fieldValue);
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

	created() {
		// If this components was created in edit mode fetch form fields values
		if (this.isEditMode) {
			this.fetchValues();
		}
	},
}

</script>


<style lang="scss">

.c-FormControl {
	&__desc {
		margin-bottom: var(--margin-md) !important;
	}


	&__buttons {
		display: flex;
		margin-top: 20px;

		.Btn {
			margin-right: 10px;
		}
	}
}

</style>
