<template>

	<div>
		<h1>Files</h1>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4">
						<a @click.prevent="getList(previousParentId)">Go up</a>
					</td>
				</tr>
				<tr v-for="(file, index) in filesList" :key="file.id">
					<td>{{ index + 1 }}.</td>
					<td v-if="file.type == 'dir'">
						<a @click.prevent="getList(file.name)">{{ file.name }}</a>
					</td>
					<td v-else>{{ file.name }}</td>
					<td>delete</td>
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
			nodeUrl: window.appConfig.apiBaseUrl + 'files/',
			pathChunks: [],
			filesList: [],
		}
	},

	methods: {
		getList() {
			axios.get(this.nodeUrl + '/list')
				.then(result => {
					this.filesList = result.data['files-list'];
				});
		},
	},

	created() {
		this.getList();
	}
}

</script>