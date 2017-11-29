import Vue from 'vue/dist/vue.esm.js';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// Add home route
const routes = [{
	path: '/',
	name: 'Home',
	icon: 'home',
}];

// Add modules routes
window.appModules.forEach(module => {
	routes.push({
		path: '/' + module.node,
		name: module.name,
		icon: module.icon,
	});
});

export default new VueRouter({
	routes,
	mode: 'history'
});