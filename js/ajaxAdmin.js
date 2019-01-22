PzkAjaxAdmin = PzkObj.pzkExt({
	
	mode: false,
	
	init: function() {
		this.loadMode('list');
	},
	
	loadMode: function(mode, params, callback) {
		var self = this;
		this.mode = mode = mode || this.mode; 
		params = params || {};
		params.page = 'components/'+this.component+'/' + mode;
		$.ajax({
			url: BASE_URL + '/index.php',
			data: params,
			type: 'post',
			success: function(resp) {
				self.$().html(resp);
				if(callback)
					callback(resp);
			}
		});
	}
});