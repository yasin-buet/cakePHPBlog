<?php 
	$this->set('channel', array(
	   'title' => 'Recent posts',
	   'link' => $this->Rss->url('/', true),
	   'description' => 'New posts on my blog'
	));
	$items = array();
	foreach($posts as $post) {
	 	$items[] = array(
		   	'title' => $post['Post']['title'],
		   	'link' => array('action'=>'view', $post['Post']['id']),
		    'description' => array('cdata'=>true, 'value'=>$post['Post']['body']),
		    'publishDate' => $post['Post']['created']
	    );
	}
	echo $this->Rss->items($items);
?>
