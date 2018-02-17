<template>

	<div>
		<header class="o-Header">
			<h1>Files</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8">
				<ul class="o-Path">
					<li>Uploads</li>
					<li v-for="(chunk, index) in pathChunks" :key="index">
						{{ chunk }}
					</li>
				</ul>

				<table>
					<thead>
						<tr>
							<th>File name</th>
							<th>File extension</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="pathChunks.length > 0">
							<td colspan="4">
								<a @click.prevent="getList('../')">
									<icon size="24" glyph="back" />
									<strong>Go up</strong>
								</a>
							</td>
						</tr>
						<tr v-for="(file, fileIndex) in filesList" :key="fileIndex">
							<td v-if="file.type == 'directory'" colspan="2">
								<a @click.prevent="getList(file.name)">
									<icon size="24" glyph="folder" />
									{{ file.name }}
								</a>
							</td>
							<template v-else>
								<td>
									<icon size="24" glyph="" />
									{{ file.name }}
								</td>
								<td>
									{{ file.extension }}
								</td>
							</template>
							<td>
								<a @click="copyLink(fileIndex)">copy url</a> /
								<a @click="deleteFile(fileIndex)">delete</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4">
				<h3>Upload files</h3>
				<form-file-upload />

				<h3>Create directory</h3>
				<form @submit.prevent="createDirectory">
					<form-field ref="directory-name">Directory name</form-field>

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
		getList(parent = null) {
			let action = 'list';

			if (parent) {
				if (parent == '../') {
					if (this.pathChunks.length > 0) {
						this.pathChunks.pop();
						action += '?path=' + this.pathChunks.join('/');
					}
				}
				else {
					this.pathChunks.push(parent);
					action += '?path=' + this.pathChunks.join('/');
				}
			}

			axios.get(this.nodeUrl + action)
				.then(result => {
					this.filesList = result.data.data;
				});
		},

		createDirectory() {
			if (this.$refs['directory-name'].fieldValue) {
				console.log(this.$refs['directory-name'].fieldValue);
				axios.post(this.nodeUrl + 'create-dir', 'path=' + this.$refs['directory-name'].fieldValue)
					.then(result => {
						console.log(result['data']);
					});
			}
		},

		deleteFile(fileId) {
			console.log('Delete: ' . fileId);
		}
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
