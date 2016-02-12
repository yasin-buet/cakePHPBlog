<nav class="navbar navbar-inverse">
  	<div class="container-fluid">
    	<div class="navbar-header">
      		<a class="navbar-brand" href="#">CakePHP Blog</a>
    	</div>
	    <ul class="nav navbar-nav">
	      	<li class="active"><?php echo $this->Html->link('All Posts', array('controller' => 'posts', 'action' => 'index')); ?></li>
	      	<li class="active"><?php echo $this->Html->link('New Posts', array('controller' => 'posts', 'action' => 'add')); ?></li>
	      	<li><?php echo $this->Html->link('All Users', array('controller' => 'users', 'action' => 'index')); ?></li>
	    </ul>
	    <ul class="nav navbar-nav" style="float: right">
	    	<li><a href="#"><?= AuthComponent::user('username') ?></a></li>
	    	<li><?php echo $this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout')); ?></li>
	    </ul>
  	</div>
</nav>