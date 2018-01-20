<template>

	<div>
		<header class="o-Header">
			<h1>Files</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8">
				<ul class="o-Path">
					<li>Uploads</li>
					<li v-for="(index, chunk) in pathChunks" :key="index">{{ chunk }}</li>
				</ul>

				<table>
					<thead>
						<tr>
							<th>File name</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4">
								<a @click.prevent="getList(previousParentId)"><strong>Go up</strong></a>
							</td>
						</tr>
						<tr v-for="file in filesList" :key="file.id">
							<td v-if="file.type == 'directory'">
								<a @click.prevent="getList(file.name)">{{ file.name }}</a>
							</td>
							<td v-else>{{ file.name }}</td>
							<td><a>delete</a></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4">
				<h3>Upload files</h3>
				<form-file-upload />

				<h3>Create directory</h3>
				<form>
					<form-field name="directory-name">Directory name</form-field>

					<button class="Btn">Create</button>
				</form>
			</div>
		</div>
	</div>

</template>


<script>

import axios from 'axios';
import FormField from '../elements/FormField.vue';
import FormFileUpload from '../elements/FormFileUpload.vue';

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
			axios.get(this.nodeUrl + 'list')
				.then(result => {
					this.filesList = result.data.data;
				});
		},
	},

	created() {
		this.getList();
	},

	components: { FormFileUpload, FormField }
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';



</style>
