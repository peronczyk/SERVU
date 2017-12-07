<template>

	<div>
		<header class="o-Header">
			<h1>Collections</h1>

			<div class="o-Header__buttons">
				<a class="Btn">Create collection</a>
			</div>
		</header>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Fields</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(entry, index) in collectionsList" :key="entry.id">
					<td>{{ index + 1 }}.</td>
					<td>{{ entry.name }}</td>
					<td>{{ entry.fields.length }}</td>
					<td>edit / delete</td>
				</tr>
			</tbody>
		</table>
	</div>

</template>


<script>

import axios from 'axios';

export default {
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
					this.collectionsList = result.data['collections-list'];
				});
		},
	},

	created() {
		this.getList();
	}
}

</script>