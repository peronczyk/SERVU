<template>

	<div class="c-CollectionsForm">
		<h3>Create collection</h3>

		<form @submit.prevent="sendForm">
			<label>
				Collection name:
				<input type="text" placeholder="Enter some name" v-model="collectionName" ref="collectionName">
			</label>
			<label>
				Collection ID:
				<input type="text" placeholder="collection-id" v-model="collectionId">
			</label>

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
							<select v-model="addedFields[fieldNumber].typeId">
								<option v-for="(fieldType, index) in fieldTypes" :key="index" :value="fieldType.id">{{ fieldType.name }}</option>
							</select>
						</td>
						<td>
							<input type="text" placeholder="Fill in field name" v-model="addedFields[fieldNumber].name">
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
	}
}
</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.c-CollectionsForm {
}

</style>

