<template>

	<div class="c-ContentForm">
		<h1>Add new content</h1>

		<form-control
			v-if="collectionsList.length"
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
					value: parentId,
				},
				...collectionFields,
			]"
			:uri="apiUri"
			:success="onAddSuccess"
			cta="Add content"
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
			baseApiUri       : window.appConfig.apiBaseUrl + 'content',
			addApiUri        : '/add/',
			modifyApiUri     : '/modify/',
			collectionFields : [{
				type: 'description',
				value: 'Choose collection.'
			}],
		}
	},

	computed: {
		...mapGetters({
			collectionsList: 'collections/getList',
		}),

		apiUri() {
			return this.baseApiUri + ((this.id)
				? this.modifyApiUri
				: this.addApiUri);
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

		fetchFormValues(contentId) {
			axios.get(this.baseApiUri + '/list?parent-id=' + (contentId || 0))
				.then(result => {
					console.log(result);

				})
				.catch(error => {
					this.isContentListFetched = true;
					console.log(error);
				});
		},
	},

	created() {
		console.log(this.id);

		if (this.id !== null) {
			this.fetchFormValues(this.id);
		}
	},
}

</script>