<div class="posts index">
    <h2><?php echo __('Posts'); ?></h2>
    <div class="container">
    <?php echo $this->Html->link('Feed', array('action'=>'index', 'ext'=>'rss')); ?>
        <?php foreach ($posts as $post): ?>
        <div class="well">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="https://cdn0.iconfinder.com/data/icons/avatars-6/500/Avatar_boy_man_people_account_client_male_person_user_work_sport_beard_team_1-128.png">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></h4>
                    <p class="text-right">By
                        <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?></p>
                    <p>
                        <?php echo h($post[ 'Post'][ 'body']); ?>
                    </p>
                    <p>
                        <audio controls>
                            <source src="<?php echo $this->webroot; ?>audio/<?php echo $post['Post']['title']?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </p>
                    <p> 
                        <iframe src="<?php echo $post['Post']['video_file'] ?>" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </p>            
                    <ul class="list-inline list-unstyled">
                        <li><span></i> <?php echo h($post['Post']['created']); ?> </span>
                        </li>
                        <li>|</li>
                        <span></i> 2 comments</span>
                        <li>|</li>
                        <li>
                            <?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add', $post['Post']['id'])); ?></li>
                            <li>
                            <?php if (AuthComponent::user('id') == $post['User']['id']): ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id'])); ?>
                            <?php endif; ?>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <p>
        <?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}') )); ?> 
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('< ' . __('previous '), array(), null, array('class ' => 'prev disabled '));
        echo $this->Paginator->numbers(array('separator ' => ' '));
        echo $this->Paginator->next(__('next ') . '>', array(), null, array('class' => 'next disabled')); ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li>
            <?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?></li>
    </ul>
</div>