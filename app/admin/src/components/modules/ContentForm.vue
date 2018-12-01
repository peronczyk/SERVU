<template>

	<div class="c-ContentForm">
		<h1>{{ formTitle }}</h1>

		<form-control
			v-if="collectionsList.length"
			:fields="[
				{
					type: 'text',
					name: 'name',
					label: 'Content name',
					required: true,
				},
				{
					type: 'select',
					name: 'collection-id',
					label: 'Collection',
					options: collectionsOptions,
					changeCallback: onCollectionChange,
				},
				{
					type: 'hidden',
					name: 'parent-id',
					value: parentId,
				},
				...collectionFields,
			]"
			:uri="baseApiUri + ((isEditMode) ? apiModifyNode : apiAddNode)"
			:fetch-uri="(isEditMode) ? this.baseApiUri + this.apiGetNode + this.id : null"
			:success="onAddSuccess"
			:cta="formCtaLabel"
		/>

		<p class="u-Info" v-else>There is no collections in the database. Please add at least one.</p>
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
		parentId: Number,
	},

	data() {
		return {
			baseApiUri       : window.appConfig.apiBaseUrl + 'content/',
			apiAddNode       : 'add/',
			apiGetNode       : 'get/',
			apiModifyNode    : 'modify/',
			collectionFields : [{
				type  : 'description',
				value : 'Choose collection.'
			}],
		}
	},

	computed: {
		...mapGetters({
			collectionsList: 'collections/getList',
		}),

		/**
		 * Defines if the form will edit data or add new one
		 */
		isEditMode() {
			return (this.id >= 0);
		},

		formTitle() {
			return (this.isEditMode)
				? 'Modify content'
				: 'Add new content';
		},

		formCtaLabel() {
			return (this.isEditMode)
				? 'Apply changes'
				: 'Add content';
		},

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
		...mapActions({
			closeModal : 'modal/close',
			openToast  : 'toast/open',
		}),

		onAddSuccess() {
			this.closeModal();
			this.openToast('Content added.');
			this.$root.$emit('content-added');
		},

		/**
		 * @param {Number} collectionId
		 */
		onCollectionChange(collectionId) {
			if (!collectionId) {
				this.collectionFields = [];
				return false;
			}

			let collectionFields = [];

			for (let collection of this.collectionsList) {
				if (collection.id === collectionId) {
					for (let field of collection.fields) {
						collectionFields.push({
							type  : field.typeId,
							name  : field.name,
							label : field.name,
						});
					}

					break;
				}
			}

			this.collectionFields = collectionFields;
		},
	},
}

</script>