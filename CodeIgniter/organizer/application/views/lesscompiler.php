<h2>choose file & compile!</h2>
<form method="GET">
	<label for="filename">choose LESS file: </label>
	<input name="filename" type="textbox" value="<?php echo $working_file;?>"/>
	<input type="submit" value="compile!">	
</form>
<h2>output</h2>
<pre><?php echo $output; ?></pre>