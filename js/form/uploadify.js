PzkFormUploadify = PzkObj.pzkExt({
	folder: 'uploads',
	init: function() {
		var that = this;
		$('#' + this.id + '_uploadify').uploadify({
	    	'uploader'  : BASE_URL +'/3rdparty/jquery/uploadify2/uploadify.swf',
	    	'script'    : BASE_URL +'/3rdparty/jquery/uploadify2/uploadify.php',
	    	'cancelImg' : BASE_URL + '/3rdparty/jquery/uploadify2/cancel.png',
	    	'folder'    : that.folder,
			'multi'     : false,
	    	'auto'      : true,
			'onComplete'  : function(event, ID, fileObj, response, data) {
				var src = response;
				that.$().val(src);
				$('#' + that.id + '_image').attr('src', src);
			},
			'onError': function(a, b, c, d) {
				 if (d.status == 404)
				 alert('Could not find upload script. Use a path relative to: ' + '<?= getcwd() ?>');
				 else if (d.type === "HTTP")
				 alert('error ' + d.type + ": " + d.info);
				 else if (d.type === "File Size")
				 alert(c.name + ' ' + d.type + ' Limit: ' + Math.round(d.sizeLimit / 1024) + 'KB');
				 else
				 alert('error ' + d.type + ": " + d.info);
 			}
	  	});
	}
});