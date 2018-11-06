<template>

	<div>
		<header class="o-Header">
			<h1>Collections</h1>

			<div class="o-Header__buttons">
				<button class="Btn" @click.prevent="addCollection()">Add collection</button>
			</div>
		</header>


		<table class="u-Table--styled u-Table--withOptions u-Table--withOptions">
			<thead>
				<tr>
					<th style="width: 30px"></th>
					<th>Name</th>
					<th class="u-Text--center">Fields</th>
					<th class="u-Text--center" style="width: 80px">Options</th>
				</tr>
			</thead>

			<transition name="fade">

				<tbody v-if="isCollectionsFetched">
					<tr v-for="(entry, index) in collectionsList" :key="entry.id">
						<td><small>{{ index + 1 }}.</small></td>
						<td>{{ entry.name }}</td>
						<td class="u-Text--center">{{ entry.fields.length }}</td>
						<td class="u-Text--center">
							<options-menu :options="[
								{name: 'Edit',   action: () => editCollection(entry)},
								{name: 'Delete', action: () => deleteCollection(entry)},
							]" />
						</td>
					</tr>
				</tbody>

			</transition>

			<tbody v-if="isCollectionsFetched && !collectionsList.length">
				<tr>
					<td colspan="5">
						<p class="u-Text--center">
							There is no collections in the database.<br>
							<small>Please use button at the top right corner to add your first collection.</small>
						</p>
					</td>
				</tr>
			</tbody>

		</table>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';

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
		}
	},

	computed: {
		...mapGetters({
			isCollectionsFetched : 'collections/isFetched',
			collectionsList      : 'collections/getList',
		}),
	},

	methods: {
		...mapActions({
			fetchCollectionsList : 'collections/fetchList',
			openModal            : 'modal/open',
			closeModal           : 'modal/close',
			openToast            : 'toast/open',
			openDialog           : 'dialog/open',
		}),

		addCollection() {
			this.openModal(CollectionsForm);
		},

		/** @todo */
		editCollection() {
			this.openToast('This option is not available yet.');
		},

		deleteCollection(entry) {
			this.openDialog({
				message: `Do you really wish to delete collection: <strong>${entry.name}</strong>?`,
				callback: () => {
					axios.post(this.nodeUrl + 'delete/' + entry.id)
						.then(result => {
							if (result.data.errors) {
								this.openToast(result.data.errors[0].message);
							}
							else {
								this.openToast('Collection deleted');
								this.fetchCollectionsList();
							}
						})
						.catch(error => {
							console.log(error);
						});
				}
			});
		},
	},

	created() {
		if (!this.isCollectionsFetched) {
			this.fetchCollectionsList();
		}
	},
}

</script>