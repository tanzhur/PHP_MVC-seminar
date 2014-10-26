<!--insert note-->
<h1>Add a new note:</h1>
<form method="POST" action="<?php echo site_url()."notes/insert"?>">
	<fieldset>
		<label for="title">note title *:</label>
		<input type="textbox" name="title" value="<?php echo $title; ?>" placeholder="note title"/>
	</fieldset>
	<fieldset>
		<label for="content">note content:</label>
		<textarea name="content" placeholder="note content"><?php echo $content; ?></textarea>
	</fieldset>
	<input type="submit" value="Add note"/>
</form>