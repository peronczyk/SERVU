<template>

	<div>
		<header class="o-Header">
			<h1>Users</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8">
				<h3>Users list</h3>
			</div>

			<div class="Col-4">
				<h3>Add user</h3>
				<form>
					<input type="email">
				</form>

				<h3>Change your data</h3>
			</div>

		</div>
	</div>

</template>


<script>

import axios from 'axios';

export default {
	created() {
		this.getList();
	}
}

</script>