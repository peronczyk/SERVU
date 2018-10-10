<template>

	<div>
		<header class="o-Header">
			<h1>Users</h1>
		</header>

		<div class="Grid Grid--gutter">

			<div class="Col-8 Col-12@LG">
				<h3>Users list <small>({{ usersList.length }})</small></h3>

				<table class="u-Table--styled u-Table--withOptions">
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
								<options-menu :options="[
									{name: 'Edit',   action: () => editUser(entry)},
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
							type: 'text',
							name: 'password',
							label: 'Password',
							required: true,
						},
						{
							type: 'checkbox',
							name: 'inform',
							label: 'Send email to this user with registration informations'
						}
					]"
					:uri="nodeUrl + 'create/'"
					:success="onUserCreateSuccess"
					title="Create user"
					cta="Create"
					ref="createUserForm"
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
					title="Change your data"
					cta="Change"
					ref="changeCurrentUserDataForm"
				/>
			</div>

		</div>
	</div>

</template>


<script>

// Dependencies
import axios from 'axios';
import { mapActions } from 'vuex';

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
		...mapActions({
			openToast: 'toast/open',
		}),

		getList() {
			axios.get(this.nodeUrl + 'list')
				.then(result => {
					this.usersList = result.data['data'];
				});
		},

		/**
		 * @todo
		 */
		editUser(entry) {
			this.openToast('Operation not available yet');
		},

		/**
		 * @todo
		 */
		deleteUser(entry) {
			this.openToast('Operation not available yet');
		},

		onUserCreateSuccess(resultData) {
			this.openToast('User created');
			this.$refs.createUserForm.resetForm();
			this.getList();
		}
	},

	created() {
		this.getList();
	},
}

</script>