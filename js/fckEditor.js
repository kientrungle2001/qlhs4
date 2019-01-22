PzkFckEditor = PzkObj.pzkExt({
	init: function() {
		if (this.submitted) return false;
		var self = this;
		
		$(function() {
			setTimeout(function() {
				var sBasePath = BASE_URL + '/3rdparty/jquery/fckeditor/';
			
				var oFCKeditor = new FCKeditor( self.name, self.width, self.height, 'Basic', self.value || '' );
				oFCKeditor.BasePath	= sBasePath;
				oFCKeditor.Value = self.value || '';
				oFCKeditor.ToolbarSet = 'Default';
				oFCKeditor.ReplaceTextarea();
			}, 10);
			self.intervalId = setInterval(function() {
				var elem = self.$();
				if (elem.length == 0) {
					clearInterval(self.intervalId);
					return false;
				}
				if ((typeof FCKeditorAPI != 'undefined') && (typeof FCKeditorAPI.Instances != 'undefined') && (typeof FCKeditorAPI.Instances[self.name] != 'undefined')) {
					elem.text(FCKeditorAPI.Instances[self.name].GetHTML());
				}
			}, 100);
		});
	}
});