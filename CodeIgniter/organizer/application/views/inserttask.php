<!--insert task-->
<h1>Add a new task:</h1>
<form method="POST" action="<?php echo site_url()."tasks/insert/"; ?>" >
	<fieldset>
		<label for="title">task title *:</label>
		<input name="title" type="textbox" placeholder="task title" />
	</fieldset>
	<fieldset>
		<label for="content">task content :</label>
		<textarea name="content" placeholder="content"></textarea>
	</fieldset>
	<fieldset>
		<label for="priority">task priority *:</label>
		<input type="textbox" name="priority" placeholder="priority" />
	</fieldset>
	<input type="submit" value="Add task"/>
</form>