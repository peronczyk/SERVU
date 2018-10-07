<template>

	<div class="c-CollectionsForm">
		<h1>Create collection</h1>

		<form-control
			:fields="[
				{
					type: 'text',
					name: 'collection-name',
					label: 'Collection name',
					required: true,
				},
				{
					type: 'list',
					name: 'field-list',
					label: 'Fields list',
					required: true,
				},
			]"
			:uri="apiUri"
			:success="onCreateSuccess"
			cta="Create new collection"
		/>
	</div>

</template>


<script>

// Dependencies
import { mapGetters } from 'vuex';

// Components
import FormControl from '../elements/FormControl.vue';

export default {
	components: {
		FormControl
	},

	data() {
		return {
			apiUri: '',
		}
	},

	computed: {
		...mapGetters('content', {
			fieldTypes: 'fieldTypes',
		}),
	},

	methods: {
		onCreateSuccess() {
			console.log('SUCCESS');
		},
	},
}

</script>