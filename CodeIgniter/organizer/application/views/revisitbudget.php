<header>
	<h1><?php echo $cBudget->title.": ".$cBudget->saldo; ?> лв.</h1>
</header>
<!--spendings-->
<section>
	<h1>Spendings</h1>
	<ul>
		<?php foreach($cBudget->spending->all as $spending):?>
			<li>
				<?php echo $spending->label.((strlen($spending->label)>0)?" : ":"").(($spending->adding)?"+":"-").$spending->amount." (".$spending->publishtime.")";?>
				<a href="<?php echo site_url()."revisitbudget/revertspending/?id=".$cBudget->id."&sid=".$spending->id; ?>"><button>revert</button></a>
			</li>
		<?php endforeach;?>
	</ul>
	<!--spend form-->
	<form method="POST" action="<?php echo site_url()."revisitbudget/spend/?id=".$cBudget->id; ?>">
		<fieldset>
			<label for="label">label :</label>
			<input placeholder="label" type="textbox" name="label" />
		</fieldset>
		<fieldset>
			<label for="amount">amount *:</label>
			<input placeholder="amount" type="textbox" name="amount" />&nbsp;лв.
		</fieldset>
		<fieldset>
			<label for="type">type :</label>
			<select name="type">
				<option selected="selected" value="subtract">subtract</option>
				<option value="add">add</option>
			</select>
		</fieldset>
		<input type="submit" value="Spend">
	</form>
</section>

