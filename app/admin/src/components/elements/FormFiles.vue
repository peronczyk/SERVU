<template>

	<div class="c-FormFiles">
		<label
			:class="{'is-Error': !isValid}"
			class="c-FormFiles__input"
		>
			<a class="Btn Btn--hollow">Select files</a>
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
				<td>{{ file.name }}</td>
				<td><small>{{ file.size / 1000 }}&nbsp;KB</small></td>
				<td>
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

export default {
	props: {
		required: {
			type: Boolean,
		},

		// Maximal number of files added
		max: {
			type: Number,
			default: 1,
		}
	},

	data() {
		return {
			value: [],
			isValid: true,
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

		validate() {
			this.isValid = true;

			if ((this.required && !this.value.length) || this.value.length > this.max) {
				this.isValid = false;
			}

			return this.isValid;
		},

		fileInputChange(event) {
			let addedFiles = event.target.files;

			if (addedFiles.length + this.value.length > this.max) {
				this.openToast('Maximal number of files reached: ' + this.max);
				event.target.value = '';
			}
			else {
				for (let i = 0; i < addedFiles.length; i++) {
					this.value.push(addedFiles[i]);
				}
			}
		},

		removeFile(file) {
			this.value = this.value.filter(addedFile => {
				return addedFile.name != file.name
			});
		}
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/_variables.scss';

.c-FormFiles {
	&__input {
		position: relative;
		overflow: hidden;

		input {
			position: absolute;
			top: 0;
			left: -100%;
			opacity: 0;
		}
	}

	&__list {
		margin-top: 6px;
		margin-bottom: $box-margin / 3;
		max-width: 100%;

		td {
			padding: 4px;

			&:first-child {
				padding-left: 0;
				padding-right: 0;
				word-break: break-all;
			}
		}
	}
}

</style>
