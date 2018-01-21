<template>

	<div class="c-ContentForm">
		<h1>Add content</h1>

		<form @submit.prevent="sendForm">
			<form-select label="Choose collection">
				<option v-for="(collection, index) in collections" :key="index" :value="collection.id">{{ collection.name }}</option>
			</form-select>
		</form>
	</div>

</template>


<script>

import FormField from '../elements/FormField.vue';
import FormSelect from '../elements/FormSelect.vue';

export default {
	data() {
		return {
			collections: [
				{
					id: 'text',
					name: 'Text',
				}
			],
		}
	},

	methods: {
		sendForm() {
			console.log('Send content form');
		}
	},

	components: { FormField, FormSelect }
}

</script>