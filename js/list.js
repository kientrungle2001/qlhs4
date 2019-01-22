PzkList = PzkObj.pzkExt({
	filters: false,
	init: function() {
	},
	reload: function() {
		var that = this;
		var data = {task: 'Reload', pageNum: that.pageNum, isAjax: 1, 
				element: that.id, page: 'components/' + pzk.elements.admin.component + '/list'};
		$.ajax({
			url: BASE_URL + '/index.php',
			data: data,
			type: 'post',
			success: function(resp) {
				var bound = $('#' + that.boundId);
				bound.html(resp)
			}
		});
		
	},
	
	gotoPage: function(pageNum) {
		this.pageNum = pageNum;
		this.reload();
	}
});