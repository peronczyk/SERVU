<template>

	<div>
		<header class="o-Header">
			<h1>Users</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8 Col-12@LG">
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
						<tr v-for="entry in usersList" :key="entry.id">
							<td>{{ entry.id }}</td>
							<td>{{ entry.email }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4 Col-12@LG">
				<h3>Add user</h3>
				<form @submit.prevent="addUser">
					<form-field type="email" name="email">Email address</form-field>
					<form-checkbox name="inform" checked>Send email to this user with registration informations.</form-checkbox>

					<button class="Btn" type="submit">Add</button>
				</form>

				<h3>Change your data</h3>
				<form @submit.prevent="modifyData">
					<form-field type="email" name="email">Your email address</form-field>
					<form-field type="password" name="password-actual">Actual password</form-field>
					<form-field type="password" name="password-new">New password</form-field>
					<form-field type="password" name="password-repeat">Repeat new password</form-field>

					<button class="Btn" type="submit">Change</button>
				</form>
			</div>

		</div>
	</div>

</template>


<script>

import axios from 'axios';
import FormField from '../elements/FormField.vue';
import FormCheckbox from '../elements/FormCheckbox.vue';

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
	},

	components: { FormField, FormCheckbox }
}

</script>