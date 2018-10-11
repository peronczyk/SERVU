<template>

	<div class="c-LoginInfo">
		<div class="c-LoginInfo__inner">
			<h1>{{ siteName }}</h1>
			<h2>Administration panel</h2>
		</div>
	</div>

</template>


<script>

export default {
	data() {
		return {
			siteName: window.appConfig.siteName,
		}
	}
}

</script>


<style lang="scss">

@import '../assets/styles/definitions';

.c-LoginInfo {
	display: flex;
	align-items: center;
	padding: var(--gutter-xl);
	width: 100%;
	text-align: right;

	&__inner {
		width: 100%;
	}

	h1 {
		margin: 0;
	}
}

</style>
