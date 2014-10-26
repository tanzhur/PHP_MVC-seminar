<h1>Budgets</h1>
<!--budgets list-->
<ul>	
	<?php $pr=false; ?>
	<?php foreach($budgets as $budget):?>	
		<li>
			<?php $pr=true; ?>
			<a href="<?php echo site_url()."revisitbudget/?id=".$budget->id; ?>"><?php echo $budget->title.": ".$budget->saldo; ?> лв.</a>
			<a href="<?php echo site_url()."budgets/delete/?id=".$budget->id; ?>"><button>delete</button></a>
		</li>
	<?php endforeach;?>
</ul>
<?php if(!$pr): ?>
	No new budgets.
<?php endif; ?>