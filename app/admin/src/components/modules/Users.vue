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
							<td>
								<a><icon size="16" glyph="edit" /> edit</a> /
								<a><icon size="16" glyph="trash" /> delete</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="Col-4 Col-12@LG">
				<form-control
					:fields="[
						{
							type: 'email',
							name: 'email',
							label: 'Email address',
							required: true,
						},
						{
							type: 'checkbox',
							name: 'inform',
							label: 'Send email to this user with registration informations'
						}
					]"
					:uri="nodeUrl + 'add-user/'"
					ref="addUserForm"
					title="Add user"
					cta="Add"
				/>

				<form-control
					:fields="[
						{
							type: 'email',
							name: 'email',
							label: 'Your email address',
							required: true,
						},
						{
							type: 'password',
							name: 'password-actual',
							label: 'Actual password',
							required: true,
						},
						{
							type: 'password',
							name: 'password-new',
							label: 'New password',
							required: true,
						},
						{
							type: 'password',
							name: 'password-repeat',
							label: 'Repeat new password',
							required: true,
						},
					]"
					:uri="nodeUrl + 'change-data/'"
					ref="changeCurrentUserDataForm"
					title="Change your data"
					cta="Change"
				/>
			</div>

		</div>
	</div>

</template>


<script>

import axios from 'axios';
import FormControl from '../elements/FormControl.vue';

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
					this.usersList = result.data['data'];
				});
		},
	},

	created() {
		this.getList();
	},

	components: { FormControl }
}

</script>