PzkFormFilter = PzkObj.pzkExt({
	value: false,
	init: function() {
		var that = this;
	},
	select: function(value, label) {
		this.value = value;
		this.$().find('.selected_value').text(label);
		this.$().find('.selected_clear').text('Xóa');
		this.$().find('.filter_list').hide();
	},
	clear: function() {
		this.value = '';
		this.$().find('.selected_value').text('Tất cả');
		this.$().find('.selected_clear').text('');
		this.$().find('.filter_list').show();
	}
});