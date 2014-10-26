<?php
	//links
	$su=site_url();
	$dashboard=$su."dashboard";
	$home=$dashboard;
	$notes=$su."notes/";
	$tasks=$su."tasks/";
	$budgets=$su."budgets/";
?>
<ul>
	<li><a href="<?php echo $home; ?>">home</a></li>
	<li><a href="<?php echo $notes; ?>">notes</a></li>
	<li><a href="<?php echo $tasks; ?>">tasks</a></li>
	<li><a href="<?php echo $budgets; ?>">budgets</a></li>
</ul>