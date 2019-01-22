<form>
	<table width="100%">
		<tr>
			<td>Subject: </td>
			<td><form.textField name="subject" width="500px"></form.textField></td>
		</tr>
		<tr>
			<td>Image: </td>
			<td><form.uploadify name="image" folder="uploads" scriptTo="head"></form.uploadify></td>
		</tr>
		<tr>
			<td>Brief: </td>
			<td><form.fckEditor name="brief" scriptTo="head" width="500px" height="300px"></form.fckEditor></td>
		</tr>
		<tr>
			<td>Content: </td>
			<td><form.fckEditor name="content" scriptTo="head" width="500px" height="300px"></form.fckEditor></td>
		</tr>
	</table>
</form>