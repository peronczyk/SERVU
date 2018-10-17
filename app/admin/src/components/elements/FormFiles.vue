<template>

	<div
		:class="{
			'is-Error'    : !isValid,
			'is-DragOver' : isDragOver,
		}"
		class="c-FormFiles"
	>
		<label
			@drop.prevent="onDrop"
			@dragover.prevent="onDragOver"
			@dragleave.prevent="onDragLeave"
			class="c-FormFiles__dropzone"
		>
			<p>Drag files here or<br> <a>click here to select</a></p>
			<input
				@change="fileInputChange"
				:disabled="isMax"
				:multiple="max > 1"
				type="file"
			>
		</label>

		<table v-if="value.length" class="c-FormFiles__list">
			<tr v-for="(file, index) in value" :key="index">
				<td><small>{{ index + 1 }}</small></td>
				<td>
					{{ file.name }}<br>
					<small>{{ file.size / 1000 }}&nbsp;KB</small>
				</td>
				<td style="width: 20px;">
					<a @click.prevent="removeFile(file)">
						<icon size="16" glyph="times" />
					</a>
				</td>
			</tr>
		</table>
	</div>

</template>


<script>

// Dependencies
import { mapActions } from 'vuex';

// Definitions
const INITIAL_VALUE = [];

export default {
	props: {
		required: Boolean,

		// Maximal number of files added
		max: {
			type: Number,
			default: 1,
		}
	},

	data() {
		return {
			value: INITIAL_VALUE,
			isValid: true,
			isDragOver: false,
		}
	},

	computed: {
		isMax() {
			return this.value.length >= this.max;
		}
	},

	methods: {
		...mapActions({
			openToast: 'toast/open',
		}),

		getValue() {
			return this.value;
		},

		validate() {
			this.isValid = true;

			if ((this.required && !this.value.length) || this.value.length > this.max) {
				this.isValid = false;
			}

			return this.isValid;
		},

		reset() {
			this.value = [];
			this.isValid = true;
		},

		/**
		 * @todo need to validate files - extensions, types and prevent of multiple
		 *   upload.
		 */
		processFileListAdd(files) {
			if (files.length + this.value.length > this.max) {
				this.openToast('Maximal number of files reached: ' + this.max);
				event.target.value = '';
			}
			else {
				for (let i = 0; i < files.length; i++) {
					this.value.push(files[i]);
				}
			}
		},

		fileInputChange(event) {
			this.processFileListAdd(event.target.files);
		},

		removeFile(file) {
			this.value = this.value.filter(addedFile => {
				return addedFile.name != file.name
			});
		},

		onDragOver(event) {
			this.isDragOver = true;
		},

		onDragLeave(event) {
			this.isDragOver = false;
		},

		onDrop(event) {
			let droppedFiles = (event.dataTransfer.files.length)
				? event.dataTransfer.files
				: event.dataTransfer.items;

			this.processFileListAdd(droppedFiles);
			this.isDragOver = false;
		},
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormFiles {
	&__dropzone {
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 10vh;
		margin-bottom: 0;
		overflow: hidden;
		text-align: center;
		background-color: var(--color-bg-light);
		transition: .2s;

		input {
			position: absolute;
			top: 0;
			left: -100%;
			width: 0;
			height: 0;
			opacity: 0;
		}

		.is-DragOver & {
			box-shadow: inset 0 0 40px rgba($color-white, .2);
		}
	}


	&__list {
		margin-top: 10px;
		max-width: 100%;

		td {
			padding: 4px;
			line-height: 1.2em;
			word-break: break-all;

			&:first-child {
				padding-left: 0;
			}
		}
	}
}

</style>
