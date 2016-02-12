<div class="posts form">
<?php echo $this->Form->create('Post',  array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Post'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('body');
        echo $this->Form->file('audio_file');
		echo $this->Form->input('video_file');?>	
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('All Posts'), array('action' => 'index')); ?></li>
	</ul>
</div>
