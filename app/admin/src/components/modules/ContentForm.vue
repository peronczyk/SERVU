<template>

	<div class="c-ContentForm">
		<h1>Add new content</h1>

		<form-control
			:fields="[
				{
					type: 'text',
					name: 'content-name',
					label: 'Content name',
					required: true,
				},
				{
					type: 'select',
					name: 'collection',
					label: 'Collection',
					options: collectionsOptions,
				},
			]"
			:uri="apiUri"
			:success="onAddSuccess"
			cta="Add content"
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
			apiUri: window.appConfig.apiBaseUrl + 'content/add/',
		}
	},

	computed: {
		...mapGetters({
			collectionsList: 'collections/getList',
		}),

		collectionsOptions() {
			return this.collectionsList.map(collection => {
				return {
					name: collection.name + ' (' + (collection.fields.length || 0) + ')',
					value: collection.id,
				};
			});
		},
	},

	methods: {
		onAddSuccess() {
			console.log('Add success');
		},
	},
}

</script>