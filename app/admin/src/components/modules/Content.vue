<template>

	<div>
		<header class="o-Header">
			<h1>Content</h1>

			<div class="o-Header__buttons">
				<button class="Btn" @click.prevent="addContent">Add content</button>
			</div>
		</header>


		<breadcrumbs
			:path="currentPath"
		/>

		<table class="u-Table--styled u-Table--withOptions">

			<thead>
				<tr>
					<th style="width: 30px;"></th>
					<th>Name</th>
					<th>Collection</th>
					<th class="u-Text--center">Children</th>
					<th>Options</th>
				</tr>
			</thead>

			<transition name="fade">

				<tbody v-if="isContentListFetched">

					<tr>
						<td colspan="4" v-if="currentPath.length > 0">
							<a @click.prevent="navigateUp"><strong>Go up</strong></a>
						</td>
					</tr>

					<tr v-for="(entry, index) in contentList" :key="entry.id">
						<td><small>{{ index + 1 }}.</small></td>
						<td>
							<a
								@click.prevent="navigateDown(entry.id, entry.name)"
								:title="'ID: ' + entry.id"
								tabindex="0"
							>{{ entry.name }}</a>
						</td>
						<td>{{ getCollectionName(entry['collection-id']) }}</td>
						<td class="u-Text--center">{{ entry.children }}</td>
						<td>
							<options-menu :options="[
								{name: 'Edit',   action: () => editContent(entry)},
								{name: 'Delete', action: () => deleteContent(entry)},
							]" />
						</td>
					</tr>

				</tbody>

			</transition>

		</table>

	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapGetters, mapActions, mapMutations } from 'vuex';

// Components
import Breadcrumbs from '../elements/Breadcrumbs.vue';
import ContentForm from './ContentForm.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		Breadcrumbs, OptionsMenu
	},

	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'content/',
			isContentListFetched: false,

			// Stores received content list for currentParentId
			contentList: [],

			// Breadcrumb address elements
			currentPath: [],
		}
	},

	computed: {
		...mapGetters({
			currentParentId      : 'content/getCurrentParentId',
			isCollectionsFetched : 'collections/isFetched',
			collectionList       : 'collections/getList',
		}),
	},

	methods: {
		...mapMutations({
			setEditId            : 'content/setEditId',
			setCurrentParentId   : 'content/setCurrentParentId',
		}),

		...mapActions({
			openModal            : 'modal/open',
			openToast            : 'toast/open',
			openDialog           : 'dialog/open',
			fetchCollectionsList : 'collections/fetchList',
		}),

		fetchList(parentId) {
			this.isContentListFetched = false;

			return axios.get(this.nodeUrl + 'list?parent-id=' + (parentId || 0))
				.then(result => {
					this.isContentListFetched = true;

					if (result.data.errors) {
						this.openToast(result.data.errors[0].message);
						console.log(result.data.errors);
					}
					else {
						this.contentList = result.data.data;
						this.setCurrentParentId(parentId || 0);
					}
				})
				.catch(error => {
					this.isContentListFetched = true;
					console.log(error);
				});
		},

		/**
		 * Navigate back through the current content structure
		 */
		navigateUp() {
			let pathLength = this.currentPath.length;

			if (pathLength > 1) {
				this.fetchList(this.currentPath[pathLength - 2].id);
				this.currentPath.splice(-1, 1);
			}
			else {
				this.fetchList(0);
				this.currentPath = [];
			}
		},

		/**
		 * Navigate deeper through the content structure
		 */
		navigateDown(parentId, parentName) {
			this.fetchList(parentId);
			this.currentPath.push({
				id: parentId,
				name: parentName
			});
		},

		addContent() {
			this.setEditId(null);
			this.openModal(ContentForm);
		},

		editContent(entry) {
			this.setEditId(entry.id);
			this.openModal(ContentForm);
		},

		deleteContent(entry) {
			this.openDialog({
				message: `Do you really wish to delete content: <strong>${entry.name}</strong>?`,
				callback: () => {
					axios.post(this.nodeUrl + 'delete/' + entry.id)
						.then(result => {
							if (result.data.errors) {
								this.openToast(result.data.errors[0].message);
							}
							else {
								this.openToast('Content deleted');
								this.fetchList();
							}
						})
						.catch(error => {
							console.log(error);
						});
				}
			});
		},

		getCollectionName(collectionId) {
			let collectionFound = this.collectionList.filter(collection => (collection.id === collectionId));
			return (collectionFound.length)
				? collectionFound[0].name
				: '';
		},
	},

	created() {
		this.fetchList();

		if (!this.isCollectionsFetched) {
			this.fetchCollectionsList();
		}

		this.$root.$on('content-added', () => {
			this.fetchList();
		});
	},
}

</script>
