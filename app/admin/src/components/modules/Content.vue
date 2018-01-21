<template>

	<div>
		<header class="o-Header">
			<h1>Content</h1>

			<div class="o-Header__buttons">
				<a class="Btn" @click.prevent="openForm">Add content</a>
			</div>
		</header>


		<ul class="o-Path">
			<li>Start</li>
			<li v-for="(index, chunk) in pathChunks" :key="index">{{ chunk }}</li>
		</ul>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Children</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4" v-if="previousParentId !== null"><a @click.prevent="getList(previousParentId)">Go up</a></td>
				</tr>
				<tr v-for="(entry, index) in contentList" :key="entry.id">
					<td>{{ index + 1 }}.</td>
					<td v-if="entry.children > 0"><a @click.prevent="getList(entry.id)">{{ entry.name }}</a></td>
					<td v-else>{{ entry.name }}</td>
					<td>{{ entry.children }}</td>
					<td><a>edit</a> / <a>delete</a></td>
				</tr>
			</tbody>
		</table>

	</div>

</template>


<script>

import axios from 'axios';
import ContentForm from './ContentForm.vue';

export default {
	data() {
		return {
			nodeUrl: window.appConfig.apiBaseUrl + 'content/',

			// Id of parent element of actually displayed content list
			// 0 means it is root of the tree
			actualParentId: 0,

			// Stores previous parentId to allow of going back (lower) in the tree
			previousParentId: null,

			// Stores received content list for actualParentId
			contentList: [],

			// Breadcrumb address elements
			pathChunks: [],
		}
	},

	methods: {
		getList(id) {
			this.previousParentId = id ? this.actualParentId : null;
			this.actualParentId = id ? id : 0;

			axios.get(this.nodeUrl + 'list?parent-id=' + this.actualParentId)
				.then(result => {
					this.contentList = result.data.data;
				});
		},

		openForm() {
			this.$store.commit('openModal', ContentForm);
		}
	},

	created() {
		this.getList();
	}
}

</script>
