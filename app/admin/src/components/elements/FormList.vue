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
				<button
					@click.prevent="addField"
					class="Btn Btn--hollow"
				>Add field</button>
			</div>
		</div>

		<table class="c-FormList__table u-Table--padded u-Table--withOptions">
			<tbody>
				<!--
					List of fields
				-->
				<tr v-for="(field, fieldNumber) in fieldsList" :key="fieldNumber">
					<td class="u-Text--center"><small>{{ fieldNumber + 1 }}</small></td>
					<td>
						<form-select
							:options="fieldTypesOptions"
							ref="typeId"
							label="Field type"
							required
						>
							Field type
						</form-select>
					</td>
					<td>
						<form-field
							:name="'field-name-' + fieldNumber"
							ref="name"
							required
						>Field name</form-field>
					</td>
					<td>
						<a
							@click.prevent="removeField(fieldNumber)"
							class="c-FormList__table__remove"
							tabindex="0"
						>
							<icon size="16" glyph="times" />
						</a>
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

// Definitions
const INITIAL_VALUE = [];

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
			fieldColumns: ['name', 'typeId'],
			fieldsList: INITIAL_VALUE,
			isValid: true,
		};
	},

	computed: {
		...mapGetters('content', [
			'getFieldTypes',
		]),

		fieldTypesOptions() {
			return this.getFieldTypes.map(type => {
				return {
					name: type.name,
					value: type.id,
				};
			});
		},

		isNotEnough() {
			return (this.required && this.fieldsList.length < this.min);
		},
	},

	methods: {
		/**
		 * Field value getter
		 * @return Array
		 */
		getValue() {
			let computedValue = [];

			// Iterate column types
			this.fieldColumns.forEach(column => {
				let columnRefs = this.$refs[column] || [];

				// Iterate refs of selected column type
				for (let index in columnRefs) {
					if (!computedValue[index]) {
						computedValue[index] = {};
					}
					computedValue[index][column] = columnRefs[index].getValue();
				}
			});

			return computedValue;
		},

		/**
		 * Field validator
		 * @return Boolean
		 */
		validate() {
			this.isValid = true;

			if (this.isNotEnough) {
				this.isValid = false;
			}

			// Iterate column types
			this.fieldColumns.forEach(column => {
				let columnRefs = this.$refs[column] || [];

				// Iterate refs of selected column type
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

		reset() {
			this.fieldsList = [];
			this.isValid = true;
		},

		addField() {
			this.fieldsList.push({
				typeId: null,
				name: null
			});
		},

		removeField(fieldNumber) {
			this.fieldsList.splice(fieldNumber, 1);
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

	&__table {
		margin-bottom: 20px;

		&__remove {
			display: inline-block;
			padding: 6px;
		}
	}
}

</style>
