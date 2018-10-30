<template>

	<div>
		<header class="o-Header">
			<h1>Content</h1>

			<div class="o-Header__buttons">
				<button class="Btn" @click.prevent="openForm">Add content</button>
			</div>
		</header>


		<ul class="o-Path">
			<li>Start</li>
			<li v-for="(chunk, index) in pathChunks" :key="index">{{ chunk }}</li>
		</ul>

		<table class="u-Table--styled u-Table--withOptions">

			<thead>
				<tr>
					<th style="width: 30px;"></th>
					<th>Name</th>
					<th class="u-Text--center">Children</th>
					<th>Options</th>
				</tr>
			</thead>

			<transition name="fade">

				<tbody v-if="isContentListFetched">

					<tr>
						<td colspan="4" v-if="previousParentId !== null"><a @click.prevent="fetchList(previousParentId)"><strong>Go up</strong></a></td>
					</tr>

					<tr v-for="(entry, index) in contentList" :key="entry.id">
						<td><small>{{ index + 1 }}.</small></td>
						<td><a @click.prevent="fetchList(entry.id)" tabindex="0">{{ entry.name }}</a></td>
						<td class="u-Text--center">{{ entry.children }}</td>
						<td>
							<options-menu :options="[
								{name: 'Edit', action: () => editContent(entry)},
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
import { mapGetters, mapActions } from 'vuex';

// Components
import ContentForm from './ContentForm.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		OptionsMenu
	},

	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'content/',
			isContentListFetched: false,

			// Id of parent element of actually displayed content list
			// 0 means it is root of the tree
			actualParentId: 0,

			// Stores previous parentId to allow of going back (lower) in the tree
			previousParentId: null,

			// Stores received content list for actualParentId
			contentList: [],

			// Breadcrumb address elements
			pathChunks: [],
		}
	},

	computed: {
		...mapGetters({
			isCollectionsFetched : 'collections/isFetched',
		}),
	},

	methods: {
		...mapActions({
			openModal            : 'modal/open',
			openToast            : 'toast/open',
			openDialog           : 'dialog/open',
			fetchCollectionsList : 'collections/fetchList',
		}),

		fetchList(id) {
			// Handle breadcrumbs
			if (!id || id === 0) {
				this.pathChunks = [];
			}
			else {
				this.pathChunks.push(this.contentList.filter(entry => entry.id === id)[0].name);
			}

			this.isContentListFetched = false;

			this.previousParentId = id ? this.actualParentId : null;
			this.actualParentId   = id ? id : 0;

			axios.get(this.nodeUrl + 'list?parent-id=' + this.actualParentId)
				.then(result => {
					this.isContentListFetched = true;

					if (result.data.errors) {
						this.openToast(result.data.errors[0].message);
						console.log(result.data.errors);
					}
					else {
						this.contentList = result.data.data;
					}
				})
				.catch(error => {
					this.isContentListFetched = true;
					console.log(error);
				});
		},

		openForm() {
			this.openModal(ContentForm);
		},

		/** @todo */
		editContent() {
			this.openToast('This option is not available yet.');
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
