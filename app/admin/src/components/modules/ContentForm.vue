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
					name: 'collection-id',
					label: 'Collection',
					options: collectionsOptions,
					changeCallback: onCollectionChange,
				},
				{
					type: 'hidden',
					name: 'parent-id',
					value: contentCurrentParentId,
				},
				...collectionFields,
			]"
			:uri="apiUri"
			:success="onAddSuccess"
			cta="Add content"
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
			apiUri: window.appConfig.apiBaseUrl + 'content/add/',
			collectionFields: [{
				type: 'description',
				value: 'Choose collection.'
			}],
		}
	},

	computed: {
		...mapGetters({
			contentCurrentParentId : 'content/getCurrentParentId',
			collectionsList        : 'collections/getList',
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
		...mapActions({
			closeModal : 'modal/close',
			openToast  : 'toast/open',
		}),

		onAddSuccess() {
			this.closeModal();
			this.openToast('Content added.');
			this.$root.$emit('content-added');
		},

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
							type: field.typeId,
							name: field.name,
							label: field.name,
						});
					}

					break;
				}
			}

			this.collectionFields = collectionFields;
		}
	},
}

</script>