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
for (let moduleId in window.appModules) {
	routes.push({
		path: '/' + moduleId,
		name: window.appModules[moduleId].name,
		component: modulesComponents[moduleId],
		icon: window.appModules[moduleId].icon,
	});
};

export default new VueRouter({
	routes,
	mode: 'history'
});