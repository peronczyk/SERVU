<template>

	<div class="c-CollectionsForm">
		<h1>{{ formTitle }}</h1>

		<form-control
			:fields="[
				{
					type: 'text',
					name: 'name',
					label: 'Collection name',
					required: true,
				},
				{
					type: 'list',
					name: 'fields',
					label: 'Fields list:',
					required: true,
				},
			]"
			:uri="baseApiUri + ((isEditMode) ? apiModifyNode : apiAddNode)"
			:fetch-uri="(isEditMode) ? this.baseApiUri + this.apiGetNode + this.id : null"
			:success="onAddSuccess"
			:cta="formCtaLabel"
		/>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';

// Components
import FormControl from '../elements/FormControl.vue';

export default {
	components: {
		FormControl
	},

	props: {
		id: Number,
	},

	data() {
		return {
			baseApiUri    : window.appConfig.apiBaseUrl + 'collections/',
			apiAddNode    : 'add/',
			apiGetNode    : 'get/',
			apiModifyNode : 'modify/',
		}
	},

	computed: {
		...mapGetters('content', {
			fieldTypes: 'fieldTypes',
		}),

		isEditMode() {
			return (this.id >= 0);
		},

		formTitle() {
			return (this.isEditMode)
				? 'Modify collection'
				: 'Add new collection';
		},

		formCtaLabel() {
			return (this.isEditMode)
				? 'Apply changes'
				: 'Add collection';
		}
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