<template>

	<div>
		<header class="o-Header">
			<h1>Collections</h1>

			<div class="o-Header__buttons">
				<a class="Btn" @click.prevent="addCollection()">Add collection</a>
			</div>
		</header>

		<table>
			<thead>
				<tr>
					<th style="width: 20px"></th>
					<th>Name</th>
					<th class="u-Text--center">Fields</th>
					<th class="u-Text--center" style="width: 80px">Options</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(entry, index) in collectionsList" :key="entry.id">
					<td>{{ index + 1 }}.</td>
					<td><a @click.prevent="editCollection(entry)">{{ entry.name }}</a></td>
					<td class="u-Text--center">{{ entry.fields.length }}</td>
					<td class="u-Text--center">
						<options-menu :options="[
							{name: 'Edit', action: () => editCollection(entry)},
							{name: 'Delete', action: () => deleteCollection(entry)},
						]" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

// Components
import CollectionsForm from './CollectionsForm.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		OptionsMenu
	},

	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'collections/',
			collectionsList: [],
		}
	},

	methods: {
		...mapActions({
			openModal: 'modal/open',
			closeModal: 'modal/close',
			openToast: 'toast/open',
		}),

		getList() {
			axios.get(this.nodeUrl + 'list')
				.then(result => {
					this.collectionsList = result.data.data;
				});
		},

		addCollection() {
			this.openModal(CollectionsForm);
		},

		/** @todo */
		editCollection() {
			this.openToast('This option is not available yet.');
		},

		/** @todo */
		deleteCollection() {
			this.openToast('This option is not available yet.');
		},

		onAddSuccess() {
			this.closeModal();
			this.openToast('Collection added.');
			this.getList();
		},
	},

	created() {
		this.getList();
		this.$root.$on('COLLECTION_ADDED', this.onAddSuccess);
	},

	beforeDestroy() {
		this.$root.$off('COLLECTION_ADDED', this.onAddSuccess);
	},
}

</script>