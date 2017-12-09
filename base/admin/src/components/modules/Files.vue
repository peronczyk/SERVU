<template>

	<div>
		<header class="o-Header">
			<h1>Files</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8">
				<h3>Files list</h3>

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
						<tr v-for="(file, index) in filesList" :key="file.id">
							<td v-if="file.type == 'directory'">
								<a @click.prevent="getList(file.name)">{{ file.name }}</a>
							</td>
							<td v-else>{{ file.name }}</td>
							<td>delete</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4">
				<h3>Upload files</h3>
				<file-upload />

				<h3>Create directory</h3>
				<form>
					<label>
						<input type="text" placeholder="Directory name">
					</label>

					<button class="Btn">Create</button>
				</form>
			</div>
		</div>
	</div>

</template>


<script>

import axios from 'axios';
import FileUpload from '../elements/FileUpload.vue';

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
					this.filesList = result.data['files-list'];
				});
		},
	},

	created() {
		this.getList();
	},

	components: { FileUpload }
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables';

.o-Path {
	list-style-type: none;
	margin-bottom: 10px;
	color: $color-gray;

	li {
		position: relative;
		display: inline-block;
		padding: 10px 30px 10px 0;
		font-size: 14px;

		&:first-child {
			font-weight: bold;
		}

		&::before,
		&::after {
			content: '';
			position: absolute;
			right: 10px;
			width: 6px;
			height: 1px;
			background-color: $color-gray;
		}

		&::before {
			top: calc(50% - 2px);
			transform: rotate(45deg);
		}

		&::after {
			top: calc(50% + 2px);
			transform: rotate(-45deg);
		}
	}
}

</style>
