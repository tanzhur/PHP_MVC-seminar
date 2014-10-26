<h1>Tasks</h1>
<?php $pr=false; ?>
<!--tasks list-->
<dl>
	<?php foreach($tasks as $task):?>
		<?php $pr=true; ?>
		<div style="border:1px solid <?php echo $task->PriorityToColor($min_p,$max_p) ?>;">
			<dt>
				<?php echo $task->title." (".(($task->status==0)?"priority: ".$task->priority:"completed").") "; ?>
				<?php if($task->status==1): ?>
					<a href="<?php echo site_url()."tasks/status/?id=".$task->id."&status=0";?>"><button>not completed</button></a>
				<?php else: ?>
					<a href="<?php echo site_url()."tasks/status/?id=".$task->id."&status=1";?>"><button>complete</button></a>
				<?php endif; ?>
				<a href="<?php echo site_url()."tasks/delete/?id=".$task->id; ?>"><button>delete</button></a>
			</dt>
			<dd>
				<pre><?php echo $task->content; ?></pre>
			</dd>
		</div>
	<?php endforeach;?>
</dl>
<?php if($pr==false):?>
	No new tasks.
<?php endif;?>
