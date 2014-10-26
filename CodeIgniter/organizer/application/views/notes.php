<h1>Notes</h1>
<!--notes list-->
<dl>	
<?php $pr=false; ?>
<?php foreach($notes as $note):?>	
	<dt>
		<?php $pr=true; ?>
		<?php echo $note->title." (".$note->publishtime.")";?>
		<a href="<?php echo site_url()."notes/delete/?id=".$note->id; ?>"><button>delete</button></a>
	</dt>
	<dd><?php echo $note->content;?></dd>
<?php endforeach;?>
</dl>
<?php if(!$pr): ?>
	No new notes.
<?php endif; ?>