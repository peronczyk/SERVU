export default {
	fieldTypes: [
		{
			id: 'text',
			name: 'Simple text field'
		},
		{
			id: 'rich',
			name: 'Rich text field'
		},
	],

	// Id of content to be edited
	editId: null,

	// Id of parent element of actually displayed content list
	// 0 means it is root of the tree
	currentParentId: 0,
}