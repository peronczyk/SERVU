<template>

	<div>
		<header class="o-Header">
			<h1>Users</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8">
				<h3>Users list</h3>

				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Email</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(entry, index) in usersList" :key="entry.id">
							<td>{{ entry.id }}.</td>
							<td>{{ entry.email }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4">
				<h3>Add user</h3>
				<form @submit.prevent="addUser">
					<label>
						<input type="email" placeholder="Email address">
					</label>
					<label>
						<input type="checkbox">
						Send email to this user with registration informations.
					</label>

					<button class="Btn" type="submit">Add</button>
				</form>

				<h3>Change your data</h3>
				<form @submit.prevent="modifyData">
					<label>
						<input type="email" placeholder="Your email address">
					</label>
					<label>
						<input type="password" placeholder="Actual password">
					</label>
					<label>
						<input type="password" placeholder="New password">
					</label>
					<label>
						<input type="password" placeholder="Repeat new password">
					</label>

					<button class="Btn" type="submit">Change</button>
				</form>
			</div>

		</div>
	</div>

</template>


<script>

import axios from 'axios';

export default {
	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'users/',
			usersList: [],
		}
	},

	methods: {
		getList() {
			axios.get(this.nodeUrl + 'list')
				.then(result => {
					this.usersList = result.data['users-list'];
				});
		},
	},

	created() {
		this.getList();
	}
}

</script>