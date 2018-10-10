<template>

	<div class="c-CollectionsForm">
		<h1>Add new collection</h1>

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
			:success="onAddSuccess"
			cta="Add collection"
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
		}
	},

	computed: {
		...mapGetters('content', {
			fieldTypes: 'fieldTypes',
		}),
	},

	methods: {
		...mapActions({
			closeModal       : 'modal/close',
			openToast        : 'toast/open',
			fetchCollections : 'collections/fetchList',
		}),

		onAddSuccess() {
			this.closeModal();
			this.openToast('Collection added.');
			this.fetchCollections();
		},
	},
}

</script>