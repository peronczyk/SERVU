import Vue from 'vue/dist/vue.esm.js';
import VueRouter from 'vue-router';

// Auto import all modules components
import modulesComponents from './components/modules/';

Vue.use(VueRouter);

// Add home route
const routes = [{
	path: '/',
	name: 'Home',
	component: modulesComponents['home'],
	icon: 'home',
}];

// Add modules routes
window.appModules.forEach(module => {
	routes.push({
		path: '/' + module.node,
		name: module.name,
		component: modulesComponents[module.node],
		icon: module.icon,
	});
});

export default new VueRouter({
	routes,
	mode: 'history'
});