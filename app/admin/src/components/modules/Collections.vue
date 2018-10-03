<template>

	<div>
		<header class="o-Header">
			<h1>Collections</h1>

			<div class="o-Header__buttons">
				<a class="Btn" @click.prevent="openForm">Create collection</a>
			</div>
		</header>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Fields</th>
					<th class="u-Text--center" style="width: 80px">Options</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(entry, index) in collectionsList" :key="entry.id">
					<td>{{ index + 1 }}.</td>
					<td>{{ entry.name }}</td>
					<td>{{ entry.fields.length }}</td>
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

// Components
import CollectionsForm from './CollectionsForm.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		CollectionsForm, OptionsMenu
	},

	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'collections/',
			collectionsList: [],
		}
	},

	methods: {
		getList() {
			axios.get(this.nodeUrl + 'list')
				.then(result => {
					this.collectionsList = result.data.data;
				});
		},

		openForm() {
			this.$store.commit('openModal', CollectionsForm);
		}
	},

	created() {
		this.getList();
	},
}

</script>