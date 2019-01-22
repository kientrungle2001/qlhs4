<?php
$build = pzk_element('build');
$item = $build->getItem();
?>
Facebook: <input type="text" name="facebook" value="{item[facebook]}" onkeyup="socialObj.facebook = this.value; socialObj.serverView();"/><br />
Twitter: <input type="text" name="twitter" value="{item[twitter]}" onkeyup="socialObj.twitter = this.value; socialObj.serverView();"/><br />
Youtube: <input type="text" name="youtube" value="{item[youtube]}" onkeyup="socialObj.youtube = this.value; socialObj.serverView();"/><br />
Google+: <input type="text" name="google" value="{item[google]}" onkeyup="socialObj.google = this.value; socialObj.serverView();"/><br />
Blogger: <input type="text" name="blogger" value="{item[blogger]}" onkeyup="socialObj.blogger = this.value; socialObj.serverView();"/><br />
<div id="social-result">
</div>
<input type="hidden" name="code" id="region-code" />
<script>
socialObj = {
	facebook : '{item[facebook]}',
	twitter : '{item[twitter]}',
	youtube : '{item[youtube]}',
	google : '{item[google]}',
	blogger : '{item[blogger]}',
	serverView: function() {
		var result = '';
		if(this.facebook) {
			result += '<a href="'+this.facebook+'"><img src="{'+'turl images/icon/facebook.png}" /></a>';
		}
		if(this.twitter) {
			result += '<a href="'+this.twitter+'"><img src="{'+'turl images/icon/twitter.png}" /></a>';
		}
		if(this.youtube) {
			result += '<a href="'+this.youtube+'"><img src="{'+'turl images/icon/youtube.png}" /></a>';
		}
		if(this.google) {
			result += '<a href="'+this.google+'"><img src="{'+'turl images/icon/google.png}" /></a>';
		}
		if(this.blogger) {
			result += '<a href="'+this.blogger+'"><img src="{'+'turl images/icon/blogger.png}" /></a>';
		}
		$('#region-code').val(result);
	}
};
socialObj.serverView();
</script>