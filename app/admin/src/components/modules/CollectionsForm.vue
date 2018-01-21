<template>

	<div class="c-CollectionsForm">
		<h1>Create collection</h1>

		<form @submit.prevent="sendForm">
			<form-field ref="collectionName">Collection name</form-field>
			<form-field ref="collectionId">Collection ID</form-field>

			<h4>Fields list</h4>
			<a class="Btn Btn--hollow" @click.prevent="addField">Add field</a>
			<table>
				<thead>
					<tr>
						<th>Field type</th>
						<th>Field name</th>
						<th class="u-Text--center">Options</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(field, fieldNumber) in addedFields" :key="fieldNumber">
						<td>
							<form-select :ref="addedFields[fieldNumber].typeId" label="Select field name">
								<option v-for="(fieldType, index) in fieldTypes" :key="index" :value="fieldType.id">{{ fieldType.name }}</option>
							</form-select>
						</td>
						<td>
							<form-field :ref="addedFields[fieldNumber].name">Fill in field name</form-field>
						</td>
						<td class="u-Text--center">
							<a @click.prevent="removeField(fieldNumber)">X</a>
						</td>
					</tr>

					<tr v-if="addedFields.length == 0">
						<td colspan="3">
							<p class="u-Info u-Text--center">There are no fields added</p>
						</td>
					</tr>
				</tbody>
			</table>

			<button type="submit" class="Btn">Create</button>
		</form>
	</div>

</template>


<script>

import FormField from '../elements/FormField.vue';
import FormSelect from '../elements/FormSelect.vue';

export default {
	data() {
		return {
			fieldTypes: this.$store.state.contentFieldTypes,
			collectionName: '',
			collectionId: '',
			addedFields: [],
		}
	},

	methods: {
		sendForm() {
			console.log('Send');
			console.log(this.$refs);
			if (this.collectionName.length < 2) {
				this.$refs.collectionName.focus();
			}
		},

		addField() {
			this.addedFields.push({
				typeId: null,
				name: null,
			});
		},

		getFieldTypeName(fieldId) {
			for (let i = 0; i < this.fieldTypes.length; i++) {
				if (this.fieldTypes[i].id == fieldId) {
					return this.fieldTypes[i].name;
				}
			}
			return 'Unknown';
		},

		removeField(fieldNumber) {
			this.addedFields.splice(fieldNumber, 1);
		},
	},

	components: { FormField, FormSelect }
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-CollectionsForm {
}

</style>

