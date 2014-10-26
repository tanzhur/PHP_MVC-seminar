<!--insert budget-->
<h1>Create new budget:</h1>
<form method="POST" action="<?php echo site_url()."budgets/insert"?>">
	<fieldset>
		<label for="title">budget title *:</label>
		<input type="textbox" value="<?php echo $title; ?>" name="title" placeholder="budget title"/>
	</fieldset>
	<fieldset>
		<label for="saldo">budget saldo *:</label>
		<input type="textbox" name="saldo" value="<?php echo $saldo; ?>" placeholder="budget saldo"/>&nbsp;лв.
	</fieldset>
	<input type="submit" value="Create budget"/>
</form>