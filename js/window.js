PzkWindow = PzkObj.pzkExt({
	init: function() {
		var that = this;
		this.$('.pzk_window_close_button:first').click(function(){
			that.close();
		});
	},
	close: function() {
		this.$().remove();
	},
	maximize: function() {
	},
	minimize: function() {
	}
});