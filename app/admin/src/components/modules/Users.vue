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
							<th class="u-Text--center" style="width: 80px">Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="entry in usersList" :key="entry.id">
							<td>{{ entry.id }}</td>
							<td>{{ entry.email }}</td>
							<td class="u-Text--center">
								<options-menu :options="[
									{name: 'Edit', action: () => editUser(entry)},
									{name: 'Delete', action: () => deleteUser(entry)},
								]" />
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

// Dependencies
import axios from 'axios';

// Components
import FormControl from '../elements/FormControl.vue';
import OptionsMenu from '../elements/OptionsMenu.vue';

export default {
	components: {
		FormControl, OptionsMenu
	},

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

		editUser() {},

		deleteUser() {},
	},

	created() {
		this.getList();
	},
}

</script>