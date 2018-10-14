<template>

	<label
		:class="{
			'is-Dirty'   : isDirty,
			'is-Focused' : isFocused,
			'is-Error'   : !isValid,
		}"
		class="c-FormRich"
	>
		<div class="c-FormRich__label">
			<slot />
			<span class="u-Required" v-if="required"></span>
		</div>

		<div class="c-FormRich__content">
			<div class="c-FormRich__buttons">
				<div class="c-FormRich__buttons__select">
					<li
						v-for="textStyle in textStyles"
						v-html="textStyle.name"
						:key="textStyle.name"
					></li>
				</div>
				<ul>
					<li
						v-for="format in formats"
						v-html="format.name"
						@click="formatText(format.operation)"
						:key="format.operation"
					></li>
				</ul>
			</div>

			<div
				@focus="onFocus"
				@input="onChange"
				@blur="onBlur"
				class="c-FormRich__field"
				contenteditable="true"
			></div>
		</div>
	</label>

</template>


<script>

const INITIAL_VALUE = '';

export default {
	props: {
		required: Boolean
	},

	data() {
		return {
			value: INITIAL_VALUE,
			isDirty: false,
			isFocused: false,
			isValid: false,
			textStyles: [
				{ name: 'Normal' },
				{ name: 'Header 1' },
			],
			formats: [
				{ name: '<strong>B</strong>', operation: 'bold' },
				{ name: '<em>I</em>', operation: 'italic' },
			],
		};
	},

	methods: {
		getValue() {
			return this.value;
		},

		validate() {
			return true;
		},

		reset() {
			this.value = INITIAL_VALUE;
		},

		onFocus() {
			this.isValid = true;
			this.isFocused = true;
			this.isDirty = true;
		},

		onBlur() {
			this.value = event.target.innerText;
			this.isFocused = false;
		},

		onChange(event) {
			this.value = event.target.innerText;
		},

		/**
		 * Handle clicking on formatting buttons
		 */
		formatText(type) {
			console.log(type);

			switch (type) {
				case 'bold':
					document.execCommand('bold');
					break;

				case 'italic':
					document.execCommand('italic');
					break;
			}

			this.isFocused = true;

			return true;
		}
	}
}

</script>


<style lang="scss">

@import '../../assets/styles/definitions';

.c-FormRich {
	margin-bottom: 20px;


	&__label {
		margin-bottom: 10px;
	}


	&__content {
		border: 1px solid $color-inputs-border;
		transition: .2s;

		.is-Focused & {
			border-color: var(--color-brand);
		}
	}


	&__buttons {
		display: flex;
		background-color: var(--color-bg-light);

		ul {
			display: flex;
			list-style-type: none;

			li {
				display: flex;
				align-items: center;
				justify-content: center;
				width: var(--tool-btn-size);
				height: var(--tool-btn-size);
				text-align: center;

				&:hover {
					background-color: rgba($color-white, .05);
				}
			}
		}

		&__select {

		}
	}


	&__field {
		min-height: 100px;
		padding: 20px;
		cursor: text;
		font-size: var(--font-size-base);
		color: var(--color-text-base);
	}
}

</style>
