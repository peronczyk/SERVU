<template>

	<div class="c-Files">
		<header class="o-Header">
			<h1>Files</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8 Col-12@LG">

				<breadcrumbs
					:path="currentPath"
				/>

				<table class="u-Table--styled u-Table--withOptions">

					<thead>
						<tr>
							<th>Name</th>
							<th style="width: 100px;">Extension</th>
							<th>Options</th>
						</tr>
					</thead>

					<transition name="fade">

						<tbody v-if="isFilesFetched">

							<tr v-if="currentPath.length > 0">
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
							<tr
								v-for="(file, fileIndex) in filesList"
								v-if="file.type == 'directory'"
								:key="file.name + fileIndex"
							>
								<td>
									<a @click.prevent="getList(file.name)">
										<icon size="24" glyph="folder-closed" />
										{{ file.name }}
									</a>
								</td>
								<td></td>
								<td>
									<options-menu :options="[
										{name: 'Delete directory', action: () => deleteFile(file)}
									]" />
								</td>
							</tr>

							<!--
								Files
							-->
							<tr
								v-for="(file, fileIndex) in filesList"
								v-if="file.type != 'directory'"
								:key="file.name + fileIndex"
							>
								<td>
									<icon size="24" glyph="file" />
									{{ file.name }}
								</td>
								<td>
									{{ file.extension }}
								</td>
								<td>
									<options-menu :options="[
										{name: 'Copy url', action: () => copyLink(fileIndex)},
										{name: 'Delete file', action: () => deleteFile(file)}
									]" />
								</td>
							</tr>

						</tbody>

					</transition>

					<tbody v-if="isFilesFetched && !filesList.length">
						<tr>
							<td colspan="5">
								<p class="u-Text--center">
									There is no files uploaded.<br>
									<small>Please use one of the forms on the right to uplload your first file or create new directory.</small>
								</p>
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
							max: 5
						},
						{
							type: 'hidden',
							name: 'location',
							value: currentPathString
						}
					]"
					:uri="nodeUrl + 'upload/'"
					:success="onUploadFilesSuccess"
					ref="uploadFilesForm"
					title="Upload files:"
					cta="Upload"
				/>

				<form-control
					:fields="[
						{
							type: 'hidden',
							name: 'location',
							value: currentPathString,
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
					title="Create directory:"
					cta="Create"
				/>
			</div>
		</div>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

// Components
import Breadcrumbs from '../elements/Breadcrumbs.vue';
import FormControl from '../elements/FormControl.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		Breadcrumbs, FormControl, OptionsMenu,
	},

	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'files/',
			isFilesFetched: false,
			currentPath: [],
			filesList: [],
		}
	},

	computed: {
		currentPathString() {
			return (this.currentPath.length)
				? this.currentPath.map(chunk => chunk.name).join('/')
				: '';
		},
	},

	methods: {
		...mapActions({
			openToast  : 'toast/open',
			openDialog : 'dialog/open',
		}),

		/**
		 * Get files list from specified path
		 */
		getList(parent = null) {
			this.isFilesFetched = false;

			let action = 'list';

			if (parent) {
				if (parent == '../') {
					if (this.currentPath.length > 0) {
						this.currentPath.pop();
					}
				}
				else {
					this.currentPath.push({
						name: parent
					});
				}
			}

			if (this.currentPath.length > 0) {
				action += '?location=' + this.currentPathString;
			}

			axios.get(this.nodeUrl + action)
				.then(result => {
					this.isFilesFetched = true;
					this.filesList = result.data.data;
				})
				.catch(error => {
					this.isFilesFetched = true;
					console.log(error);
				});
		},

		/**
		 * Delete file
		 */
		deleteFile(file) {
			this.openDialog({
				message: (file.type === 'directory')
					? `Do you really want to delete directory <strong>${file['full-name']}</strong> and all it's contents?`
					: `Do you really want to delete file <strong>${file['full-name']}</strong>?`,
				callback: () => {
					let fileLocation = this.currentPathString + '/' + file['full-name'];
					axios.post(this.nodeUrl + 'delete', 'file=' + fileLocation)
						.then(result => {
							if (result.data.success === true) {
								this.openToast('File or directory deleted permanently.');
								this.getList();
							}
							else if (result.data.errors) {
								this.openToast('File or directory removal failed.<br>Returned error: ' + result.data.errors[0].message);
							}
							else {
								console.log(result.data);
							}
						});
				}
			})
		},

		/**
		 * Copy link
		 * @todo
		 */
		copyLink() {
			this.openToast('This feature is in ToDo list...');
		},

		/**
		 * Form Control Success : Create directory
		 */
		onCreateDirectorySuccess(resultData) {
			if (resultData.errors) {
				this.openToast(`Directory creation failed.<br>Returned error: ${resultData.errors[0].message}`);
			}
			else {
				this.openToast('Directory created');
				this.$refs.createDirectoryForm.resetForm();
				this.getList();
			}
		},

		/**
		 * Form Control Success : Upload Files
		 */
		onUploadFilesSuccess(resultData) {
			if (resultData.errors) {
				this.openToast(`Files upload failed.<br>Returned error: ${resultData.errors[0].message}`);
			}
			else {
				this.openToast('Files uploaded');
				this.$refs.uploadFilesForm.resetForm();
				this.getList();
			}
		}
	},

	created() {
		this.getList();
	},
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-Files {
	table {
		td {
			.Icon {
				margin: 0 10px;
				color: $color-text-lvl-3;
			}
		}
	}
}

</style>
