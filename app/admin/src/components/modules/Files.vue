<template>

	<div>
		<header class="o-Header">
			<h1>Files</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8 Col-12@LG">
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
							<th style="width: 100px;">Extension</th>
							<th style="width: 160px;">Options</th>
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

						<!--
							Directories
						-->
						<tr v-for="(file, fileIndex) in filesList" v-if="file.type == 'directory'" :key="fileIndex">
							<td colspan="2">
								<a @click.prevent="getList(file.name)">
									<icon size="24" glyph="folder" />
									{{ file.name }}
								</a>
							</td>
							<td>
								<a @click.prevent="deleteFile(file)">delete</a>
							</td>
						</tr>

						<!--
							Files
						-->
						<tr v-for="(file, fileIndex) in filesList" v-if="file.type != 'directory'" :key="fileIndex">
							<td>
								<icon size="24" glyph="file" />
								{{ file.name }}
							</td>
							<td>
								{{ file.extension }}
							</td>
							<td>
								<a @click.prevent="copyLink(fileIndex)">copy url</a> /
								<a @click.prevent="deleteFile(file)">delete</a>
							</td>
						</tr>

					</tbody>
				</table>
			</div>

			<div class="Col-4 Col-12@LG">
				<form-control
					:fields="[
						{
							type: 'files',
							name: 'files',
							required: true,
							max: 5,
						}
					]"
					:uri="nodeUrl + 'upload/'"
					:success="onUploadFilesSuccess"
					ref="uploadFilesForm"
					title="Upload files"
					cta="Upload"
				/>

				<form-control
					:fields="[
						{
							type: 'hidden',
							name: 'location',
							value: actualPath,
						},
						{
							type: 'text',
							name: 'name',
							label: 'Directory name',
							required: true,
						}
					]"
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
		actualPath() {
			return (this.pathChunks.length)
				? this.pathChunks.join('/')
				: '';
		},
	},

	methods: {
		/**
		 * Get files list from specified path
		 */
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

		/**
		 * Delete file
		 */
		deleteFile(file) {
			let fileLocation = this.actualPath + '/' + file['full-name'];
			axios.post(this.nodeUrl + 'delete', 'file=' + fileLocation)
				.then(result => {
					if (result.data.errors) {
						this.$store.commit('openToast', 'File or directory removal failed.<br>Returned error: ' + result.errors[0].message);
					}
					else if (result.data.success === true) {
						this.$store.commit('openToast', 'File or directory deleted permanently.');
						this.getList();
					}
				});
		},

		/**
		 * Form Control Success : Create directory
		 */
		onCreateDirectorySuccess(result) {
			if (result.errors) {
				this.$store.commit('openToast', 'Directory creation failed.<br>Returned error: ' + result.errors[0].message);
			}
			else {
				this.$store.commit('openToast', 'Directory created');
				this.$refs.createDirectoryForm.resetForm();
				this.getList();
			}
		},

		/**
		 * Form Control Success : Upload Files
		 */
		onUploadFilesSuccess(result) {
			if (result.errors) {
				this.$store.commit('openToast', 'Files upload failed.<br>Returned error: ' + result.errors[0].message);
			}
			else {
				this.$store.commit('openToast', 'Files uploaded');
				this.$refs.uploadFilesForm.resetForm();
				this.getList();
			}
		}
	},

	created() {
		this.getList();
	},

	components: { FormControl }
}

</script>
