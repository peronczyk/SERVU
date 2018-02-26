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
				<form-control
					:fields="[
						{
							type: 'files',
							name: 'files',
							required: true,
							max: 5,
						}
					]"
					:uri="nodeUrl + 'upload-files/'"
					ref="uploadFilesForm"
					title="Upload files"
					cta="Upload"
				/>

				<form-control
					:fields="createDirectoryFields"
					:uri="nodeUrl + 'create-dir/'"
					:success="onCreateDirectorySuccess"
					ref="createDirectoryForm"
					title="Create directory"
					cta="Create"
				/>
			</div>
		</div>
	</div>

</template>


<script>

import axios from 'axios';
import FormControl from '../elements/FormControl.vue';

export default {
	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'files/',
			pathChunks: [],
			filesList: [],
		}
	},

	computed: {
		createDirectoryFields() {
			return [
				{
					type: 'hidden',
					name: 'location',
					fieldValue: this.pathChunks,
				},
				{
					type: 'text',
					name: 'dirname',
					label: 'Directory name',
					required: true,
				}
			];
		},

		actualPath() {
			return 'DUPA';
			return (this.pathChunks.length)
				? join('/')
				: '';
		}
	},

	methods: {
		getList(parent = null) {
			let action = 'list';

			if (parent) {
				if (parent == '../') {
					if (this.pathChunks.length > 0) {
						this.pathChunks.pop();
					}
				}
				else {
					this.pathChunks.push(parent);
				}
			}

			if (this.pathChunks.length > 0) {
				action += '?location=' + this.actualPath;
			}

			axios.get(this.nodeUrl + action)
				.then(result => {
					this.filesList = result.data.data;
				});
		},

		onCreateDirectorySuccess(result) {
			if (result.errors) {
				this.$store.commit('openToast', 'Direcotory creation failed.<br>Returned error: ' + result.errors[0].message);
			}
			else {
				this.$store.commit('openToast', 'Directory created');
				this.$refs.createDirectoryForm.resetForm();
				this.getList();
			}
		},

		deleteFile(fileId) {
			console.log('Delete: ' . fileId);
		}
	},

	created() {
		this.getList();
	},

	components: { FormControl }
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';



</style>
