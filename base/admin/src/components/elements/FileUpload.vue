<template>

	<div class="e-FileUpload">
		<label>
			<span class="Btn Btn--secondary">Select files</span>
			<input type="file" multiple @change="fileInputChange">
		</label>

		<div v-if="filesList.length > 0">
			<ol>
				<li v-for="(file, index) in filesList" :key="index">
					{{ file.name }}
					<small>({{ file.size / 1000 }} KB)</small>
					<a @click.prevent="removeFile(file)">&nbsp;X</a>
				</li>
			</ol>

			<button @click.prevent="upload">Upload</button>
		</div>
	</div>

</template>


<script>

export default {
	data() {
		return {
			filesList: []
		}
	},

	methods: {
		fileInputChange(event) {
			console.log(event.target.files);

			for (let i = 0; i < event.target.files.length; i++) {
				this.filesList.push(event.target.files[i]);
			}
		},

		removeFile(file) {
			console.log(file);
		}
	}
}

</script>



<style lang="scss">

@import '../../assets/styles/_variables';

.e-FileUpload {
	position: relative;
	margin-bottom: $box-margin;
	overflow: hidden;

	[type='file'] {
		visibility: hidden;
		width: 0;
		height: 0;
	}

	ol {
		margin: 16px 0 16px 20px;
		font-size: 13px;

		li {
			margin-bottom: 8px;
		}
	}
}

</style>
