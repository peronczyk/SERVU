<template>

	<div class="c-FormList">
		<div class="Grid Grid--center">
			<div class="Col-6">
				<h4><slot /></h4>
				<transition name="fade">
					<p v-if="!isValid && isNotEnough" class="u-Error">
						There should be at least <strong>{{ min }}</strong> fields added.
					</p>
				</transition>
			</div>

			<div class="Col-6 u-Text--right">
				<a class="Btn Btn--hollow" @click.prevent="addField">Add field</a>
			</div>
		</div>

		<table>
			<tbody>
				<!--
					List of fields
				-->
				<tr v-for="(field, fieldNumber) in fieldsList" :key="fieldNumber">
					<td class="u-Text--center">{{ fieldNumber + 1 }}
					<td>
						<form-select ref="typeIds" label="Field type" required>
							<option
								v-for="(fieldType, fieldTypeNumber) in getFieldTypes"
								:key="fieldTypeNumber"
								:value="fieldType.id"
							>{{ fieldType.name }}</option>
						</form-select>
					</td>
					<td>
						<form-field ref="names" required>Field name</form-field>
					</td>
					<td class="u-Text--center">
						<a @click.prevent="removeField(fieldNumber)"><icon size="16" glyph="times" /></a>
					</td>
				</tr>

				<!--
					Info about empty list
				-->
				<tr v-if="fieldsList.length === 0">
					<td colspan="4">
						<p class="u-Info u-Text--center">There are no fields added</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</template>


<script>

// Dependencies
import { mapGetters } from 'vuex';

// Components
import FormField from './FormField.vue';
import FormSelect from './FormSelect.vue';

export default {
	components: {
		FormField, FormSelect
	},

	props: {
		required: Boolean,

		min: {
			type: Number,
			default: 1
		},
	},

	data() {
		return {
			fieldColumns: ['names', 'typeIds'],
			fieldsList: [],
			isValid: true,
		};
	},

	computed: {
		...mapGetters('content', [
			'getFieldTypes',
		]),

		isNotEnough() {
			return (this.required && this.fieldsList.length < this.min);
		},
	},

	methods: {
		/**
		 * @todo
		 */
		getValue() {
			let computedValue = [];
			console.log(this.$refs);
			return 'TEST';
		},

		validate() {
			this.isValid = true;

			if (this.isNotEnough) {
				this.isValid = false;
			}

			this.fieldColumns.forEach(column => {
				let columnRefs = this.$refs[column] || [];

				for (let index in columnRefs) {
					let fieldIsValid = columnRefs[index].validate();

					// Change component valid state to false on first invalid element
					if (!fieldIsValid && this.isValid) {
						this.isValid = false;
					}
				}
			});

			return this.isValid;
		},

		addField() {
			this.fieldsList.push({
				typeId: null,
				name: null
			});
		},

		removeField(fieldNumber) {
			this.addedFields.splice(fieldNumber, 1);
		},
	}
}

</script>


<style lang="scss">

.c-FormList {
	margin-top: 20px;

	h4 {
		margin: 0;
	}
}

</style>
