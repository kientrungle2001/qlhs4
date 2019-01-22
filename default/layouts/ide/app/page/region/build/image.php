<?php
$build = pzk_element('build');
$item = $build->getItem();
?>
<div id="image-client-upload">
	<label for="fileToUpload">Select Files to Upload</label><br />
	<input type="file" name="filesToUpload[]" id="filesToUpload" /><br />
	<button id="uploadButton" disabled="disabled">Upload</button>
	<button id="removeButton" disabled="disabled">Remove</button><br />
	<strong>Preview: </strong><br />
	<output id="image-preview"></output>
</div>
<div id="image-properties">
	Width: <input type="text" name="width" value="{item[width]}" onchange="imgObj.width = this.value; imgObj.serverView();"/><br />
	Height: <input type="text" name="height" value="{item[height]}" onchange="imgObj.height = this.value; imgObj.serverView();"/><br />
	Frame: <input type="text" name="frame" value="{item[frame]}" onchange="imgObj.frame = this.value; imgObj.serverView();"/><br />
	Class: <input type="text" name="class" value="{item[class]}" onchange="imgObj['class'] = this.value; imgObj.serverView();"/><br />
	Style: <br />
	<textarea type="hidden" name="style" id="region-style" onkeyup="$('#style-holder').text($(this).val());">{item[style]}</textarea>
	<style type="text/css" id="style-holder">{item[style]}</style>
</div>
<div id="image-info">
	Title: <input type="text" name="image_title" value="{item[image_title]}" onchange="imgObj.image_title = this.value; imgObj.serverView();"/><br />
	Alt: <input type="text" name="alt" value="{item[alt]}" onchange="imgObj.alt = this.value; imgObj.serverView();"/><br />
</div>
<div id="image-server-upload">
</div>
<input type="hidden" name="code" id="region-code" />
<script>
var imgObj = {
	src: '{item[src]}',
	width: '{item[width]}',
	height: '{item[height]}',
	image_title: '{item[image_title]}',
	frame: <?php echo json_encode(@$item['frame']?@$item['frame'] : '');?>,
	alt: '{item[alt]}',
	file: false,
	image: false,
	'class': '{item[class]}',
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
		that.file = filesToUpload.files[0];
		that.disable();
		that.preview();
	},
	disable: function() {
		$('#filesToUpload').prop('disabled', 'disabled');
		$('#uploadButton').prop('disabled', '');
		$('#removeButton').prop('disabled', '');
	},
	enable: function() {
		$('#filesToUpload').prop('disabled', '');
		$('#uploadButton').prop('disabled', 'disabled');
		$('#removeButton').prop('disabled', 'disabled');
	},
	preview: function() {
		var file = this.file;
		if (!file.type.match('image.*')) {
			return ;
		}

		var reader = new FileReader();
		reader.onload = (function (tFile) {
			return function (evt) {
				var div = '<img style="width: 90px;" src="' + evt.target.result + '" />';
				$('#image-preview').html(div);
			};
		}(file));
		reader.readAsDataURL(file);
	},
	
	upload: function() {
		// upload
		var that = this;
		
		
		if(that.file) {
			var data = new FormData();
			data.append('file', that.file);
			$.ajax({
				url: '{url /media_image}/upload/{item[id]}',
				data: data, type: 'POST',
				cache: false, contentType: false, processData: false,
				success: function(resp){
					resp = eval('(' + resp + ')');
					if(resp.success) {
						that.image = resp.image;
						that.serverView();
						that.closeClient();
					}
				}
			});
		} else {
			alert('No file selected');
			return false;
		}
		
	},
	closeClient: function() {
		this.file = false;
		$('#image-preview').html('');
		$('#filesToUpload').val('');
		$('#image-client-upload').css('display', 'none');
	},
	openClient: function() {
		this.image = false;
		$('#image-client-upload').css('display', 'block');
		$('#image-server-upload').html('');
	},
	remove: function() {
		var that = this;
		$('#image-preview').html('');
		$('#filesToUpload').val('');
		that.file = false;
		that.enable();
	},
	serverRemove: function() {
		var that = this;
		// remove media
		$.ajax({
			url: '{url /media_image}/remove}/' + that.image.id,
			success: function(resp) {
				that.enable();
				that.openClient();
			}
		});
		
		
	},
	serverLoad: function() {
		var that = this;
		$.ajax({
			url: '{url /media_image}/load}/{item[id]}',
			success: function(resp) {
				
				resp = eval('(' + resp + ')');
				if(resp) {
					that.image = resp.image;
					that.closeClient();
					that.serverView();
				}
			}
		});
	},
	serverSave: function() {
	},
	serverView: function() {
		if(this.image){
			var result =  '<div style="'+this.frame+'" class="'+this.class+'"><img src="'+this.image.src+'" style="width:'+this.width+'; height: '+this.height+';" title="'+this.image_title+'" alt="'+this.alt+'" /></div>';
			$('#region-code').val(result);
			$('#image-server-upload').html('<div>'+result+'<br /><input type="button" value="Delete" onclick="imgObj.serverRemove(); return false;"></div>');
		}
		
	}
};
imgObj.serverLoad();
imgObj.initEvents();
</script>