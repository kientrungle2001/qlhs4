PzkTableController = PzkController.pzkExt({
	add: function(data, callback) {
		pzk.elements.admin.loadMode(null, data, callback);
		return true;
	},
	edit: function(data, callback) {
		pzk.elements.admin.loadMode(null, data, callback);
		return true;
	},
	del: function(data, callback) {
	}
});