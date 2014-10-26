<!--change title form-->
<h1>Change title:</h1>
<form method="POST" action="<?php echo site_url()."revisitbudget/update/?id=".$cBudget->id; ?>">
	<fieldset>
		<label for="title">budget title *:</label>
		<input type="textbox" placeholder="budget title" name="title" value="<?php echo $cBudget->title; ?>"/>
	</fieldset>
	<input type="submit" value="Change title"/>
</form>