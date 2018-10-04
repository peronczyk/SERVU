export default {
	getUserAccess : state => state.userAccessLvl,
	isLoggedIn    : state => (state.userAccessLvl > 0),
}