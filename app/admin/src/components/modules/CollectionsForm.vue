<template>

	<div class="c-CollectionsForm">
		<h1>Create collection</h1>

		<transition name="fade">
			<p v-if="creationSuccess" class="u-Info">Collection added</p>
		</transition>

		<form-control
			v-if="!creationSuccess"
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
import { mapGetters, mapActions } from 'vuex';

// Components
import FormControl from '../elements/FormControl.vue';

export default {
	components: {
		FormControl
	},

	data() {
		return {
			apiUri: window.appConfig.apiBaseUrl + 'collections/add/',
			creationSuccess: false,
		}
	},

	computed: {
		...mapGetters('content', {
			fieldTypes: 'fieldTypes',
		}),
	},

	methods: {
		onCreateSuccess() {
			this.$root.$emit('COLLECTION_ADDED');
		},
	},
}

</script>