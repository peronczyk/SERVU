<template>

	<label class="c-FormFiles" :class="{'is-Error': !isValid}">
		<input
			@change="fileInputChange"
			:disabled="isMax"
			:multiple="max > 1"
			type="file"
		>

		<table v-if="value.length" class="c-FormFiles__list">
			<tr v-for="(file, index) in value" :key="index">
				<td>{{ file.name }}</td>
				<td><small>{{ file.size / 1000 }}&nbsp;KB</small></td>
				<td>
					<a @click.prevent="removeFile(file)">
						<icon size="16" glyph="times" />
					</a>
				</td>
			</tr>
		</table>
	</label>

</template>


<script>

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
				this.$store.commit('openToast', 'Maximal number of files reached: ' + this.max);
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
				console.log(addedFile);

				return addedFile.name != file.name
			});
		}
	}
}

</script>


<style lang="scss">

.c-FormFiles {
	&__list {
		max-width: 100%;

		td:first-child {
			word-break: break-all;
		}
	}
}

</style>
