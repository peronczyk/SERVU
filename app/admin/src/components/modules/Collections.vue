<template>

	<div>
		<header class="o-Header">
			<h1>Collections</h1>

			<div class="o-Header__buttons">
				<a class="Btn" @click.prevent="addCollection()">Add collection</a>
			</div>
		</header>

		<transition name="fade">
			<table v-if="isCollectionsFetched">
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
		</transition>
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
		}),

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
	},

	created() {
		if (!this.isCollectionsFetched) {
			this.fetchCollectionsList();
		}
	},
}

</script>