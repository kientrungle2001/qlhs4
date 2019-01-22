<?php
$build = pzk_element('build');
$item = $build->getItem();
$app = _db()->getParent('profile_resource', $item['id'], 'type="Application"');
$pages = _db()->select('*')->from('profile_resource')->where('parentId=' . $app['id'])->result();
?>
Heading: <input name="heading" onchange="sectionObj.heading = $(this).val();sectionObj.serverView();" value="{item[heading]}" /><br />
Body: <br />
<?php $data->body->display();?>
Ordering: <select id="build-section-ordering" name="ordering" value="{item[ordering]}" onchange="sectionObj.ordering = $(this).val();sectionObj.serverView();">
	<option value="heading-image-body">Heading - Image - Body</option>
	<option value="heading-body">Heading - Body</option>
	<option value="heading-image">Heading - Image</option>
	<option value="image-body">Image - Body</option>
	<option value="image-heading">Image - Heading</option>
	<option value="image-heading-body">Image - Heading - Body</option>
</select>
<br />
Link to: <select id="build-section-link" name="link" onchange="sectionObj.link = $(this).val();sectionObj.serverView();">
	<option value="">None</option>
	{each $pages as $page}
		<option value="{url /page}/{page[id]}">{page[title]}</option>
	{/each}
</select><br />
<script>
	$('#build-section-ordering').val('{item[ordering]}');
	$('#build-section-link').val('{item[link]}');
</script>
<div id="image-client-upload">
	<label for="fileToUpload">Select Files to Upload</label><br />
	<input type="file" name="filesToUpload[]" id="filesToUpload" /><br />
	<button id="uploadButton" disabled="disabled">Upload</button>
	<button id="removeButton" disabled="disabled">Remove</button><br />
	<strong>Preview: </strong><br />
	<output id="image-preview"></output>
</div>
<div id="image-properties">
	Width: <input type="text" name="width" value="{item[width]}" onchange="sectionObj.width = this.value; sectionObj.serverView();"/><br />
	Height: <input type="text" name="height" value="{item[height]}" onchange="sectionObj.height = this.value; sectionObj.serverView();"/><br />
	Frame: <input type="text" name="frame" value="{item[frame]}" onchange="sectionObj.frame = this.value; sectionObj.serverView();"/><br />
	Class: <input type="text" name="class" value="{item[class]}" onchange="sectionObj['class'] = this.value; sectionObj.serverView();"/><br />
	Style: <br />
	<textarea type="hidden" name="style" id="region-style" onkeyup="$('#style-holder').text($(this).val());">{item[style]}</textarea>
	<style type="text/css" id="style-holder">{item[style]}</style>
</div>
<div id="image-info">
	Title: <input type="text" name="image_title" value="{item[image_title]}" onchange="sectionObj.image_title = this.value; sectionObj.serverView();"/><br />
	Alt: <input type="text" name="alt" value="{item[alt]}" onchange="sectionObj.alt = this.value; sectionObj.serverView();"/><br />
</div>
<div id="image-server-upload">
</div>
<input type="hidden" name="code" id="region-code" />
<script>
var sectionObj = {
	heading: '{item[heading]}',
	body: <?php echo json_encode(@$item['body']?@$item['body']: '');?>,
	ordering: '{item[ordering]}',
	link: '{item[link]}',
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
		this.body = $('textarea[name=body]').val();
		var result = '';
		var arr = {};
		if(this.link) {
			arr.heading = '<h2><a href="'+this.link+'">'+this.heading+'</a></h2>';
		} else {
			arr.heading = '<h2>'+this.heading+'</h2>';
		}
		arr.body = '<p>'+this.body+'</p>';
		if(this.image){
			arr['image'] =  '<p><img class="'+this.class+'" src="'+this.image.src+'" style="width:'+this.width+'; height: '+this.height+';" title="'+this.image_title+'" alt="'+this.alt+'" /></p>';
		}
		var orders = this.ordering.split('-');
		result += '<section>';
		for(var i = 0; i < orders.length; i++) {
			var order = orders[i];
			if(arr[order]) {
				result += arr[order];
			}
		}
		result += '</section>';
		$('#region-code').val(result);
		$('#image-server-upload').html('<div>'+result+'<br /><input type="button" value="Delete" onclick="sectionObj.serverRemove(); return false;"></div>');
	}
};
sectionObj.serverLoad();
sectionObj.initEvents();
</script>