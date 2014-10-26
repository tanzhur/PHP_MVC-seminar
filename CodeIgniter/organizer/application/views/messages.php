<?php if(isset($allMessages) AND is_array($allMessages)): ?>
	<ul id="messages_list">
	<?php foreach($allMessages as $type=>$messages): ?>
		<?php foreach($messages as $message): ?>
		<li>
			<div class="<?php echo "msg msg_".$type ?>"><?php echo$message;?></div>
		</li>
		<?php endforeach; ?>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>