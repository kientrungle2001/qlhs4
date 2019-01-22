<?php
$build = pzk_element('build');
$item = $build->getItem();
/**
Hien thi danh sach cac anh trong gallery
*/
?>
<div id="image-client-upload">
	<label for="fileToUpload">Select Files to Upload</label><br />
	<input type="file" name="filesToUpload[]" id="filesToUpload" multiple="multiple" /><br />
	<button id="uploadButton">Upload</button><br />
	<strong>Preview: </strong><br />
	<output id="image-preview"></output>
</div>
<div id="image-properties">
	Width: <input type="text" name="width" onchange="galleryObj.width = this.value; galleryObj.serverView();"/><br />
	Height: <input type="text" name="height" onchange="galleryObj.height = this.value; galleryObj.serverView();"/><br />
	Frame: <input type="text" name="frame" onchange="galleryObj.frame = this.value; galleryObj.serverView();"/><br />
	Class: <input type="text" name="class" onchange="galleryObj['class'] = this.value; galleryObj.serverView();"/><br />
	Style: <br />
	<textarea type="hidden" name="style" id="region-style" onkeyup="$('#style-holder').text($(this).val());">{item[style]}</textarea>
	<style type="text/css" id="style-holder"></style>
</div>
<div id="image-info">
	Title: <input type="text" name="image_title" onchange="galleryObj.image_title = this.value; galleryObj.serverView();"/><br />
	Alt: <input type="text" name="alt" onchange="galleryObj.alt = this.value; galleryObj.serverView();"/><br />
</div>
<div id="image-server-upload">
</div>
<input type="hidden" name="code" id="region-code" />
<script>
galleryObj = {
	src: '',
	width: 'auto',
	height: 'auto',
	image_title: '',
	alt: '',
	files: false,
	images: [],
	'class': '',
	initEvents: function() {
		var that = this;
		$('#filesToUpload').change(function() {
			that.add();
		});
		$('#uploadButton').click(function() {
			that.upload();
			return false;
		});
		$('#removeButton').click(function() {
			that.remove();
			return false;
		});
		$('#serverRemoveButton').click(function() {
			that.serverRemove();
			return false;
		});
		$('#serverSaveButton').click(function() {
			that.serverSave();
			return false;
		});
	},
	
	add: function() {
		var that = this;
		var filesToUpload = document.getElementById('filesToUpload');
		that.files = [];
		for (var i = 0; i < filesToUpload.files.length; i++) {
			that.files.push(filesToUpload.files[i]);
		}
		that.preview();
	},
	preview: function() {
		var files = this.files;
		$('#image-preview').html('');
		for(var i = 0; i < files.length; i++) {
			var file = files[i];
			if (!file.type.match('image.*')) {
                continue ;
            }
			
            var reader = new FileReader();
            reader.onload = (function (tFile, index) {
                var closeButton = '<br /><input type="button" onclick="galleryObj.remove('+index+'); return false;" value="Remove"/>';
				return function (evt) {
					var div = '<div><img style="width: 90px;" src="' + evt.target.result + '" />'+closeButton+'</div>';
					$('#image-preview').append(div);
                };
            }(file, i));
            reader.readAsDataURL(file);
		}
	},
	
	upload: function() {
		// upload
		var that = this;
		
		
		if(that.files.length) {
			var data = new FormData();
			for(var i = 0; i < that.files.length; i++) {
				data.append('file', that.files[i]);
				$.ajax({
					url: '{url /media_image}/upload/{item[id]}',
					data: data, type: 'POST',
					cache: false, contentType: false, processData: false,
					async: false,
					success: function(resp){
						resp = eval('(' + resp + ')');
						if(resp.success) {
							that.images.push(resp.image);
						}
					}
				});
			}
			that.files.length = 0;
			that.preview();
			that.serverLoad();
		} else {
			alert('No file selected');
			return false;
		}
		
	},
	remove: function(index) {
		var that = this;
		that.files.splice(index, 1);
		that.preview();
	},
	serverRemove: function(id) {
		var that = this;
		// remove media
		$.ajax({
			url: '{url /media_image}/remove}/' + id,
			success: function(resp) {
				that.serverLoad();
			}
		});
	},
	serverLoad: function() {
		var that = this;
		$.ajax({
			url: '{url /media_image}/load}/{item[id]}?multiple=1',
			success: function(resp) {
				
				resp = eval('(' + resp + ')');
				if(resp) {
					that.images = resp;
					that.serverView();
				}
			}
		});
	},
	serverSave: function() {
	},
	serverView: function() {
		var that = this; var result = ''; var resultGallery = '';$('#image-server-upload').html('');
		for(var i = 0; i < that.images.length;i++) {
			var image = that.images[i];
			if(image){
				result =  '<div style="'+this.frame+'" class="'+this.class+'"><img src="'+image.src+'" style="width:'+this.width+'; height: '+this.height+';" title="'+this.image_title+'" alt="'+this.alt+'" /></div>';
				
				resultGallery += result;
				$('#image-server-upload').append('<div>'+result+'<br /><input type="button" value="Delete" onclick="galleryObj.serverRemove('+image.id+'); return false;"></div>');
			}
		}
		$('#region-code').val(resultGallery);
	},
	
	build: function() {
		
	}
};
galleryObj.serverLoad();
galleryObj.initEvents();
</script>