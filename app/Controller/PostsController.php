<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session', 'RequestHandler');
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$options = array();
		// $post['Post']['id'] = 1;
		// $total = $this->Post->Comment->find('count');
		// debug($total);

		

		$posts = $this->Post->find('all', array(
   		 	// 'fields' => array(
        		// 'Post.id', 
       	 		// 'COUNT(Comment.id)'
    		// ),
    		'group' => array('Post.id'),
    		'joins' => array(
        		array(
	            	'table' => 'comments',
	            	'alias' => 'Comment',
	            	'conditions' => array(
	            		'Post.id = Comment.post_id'
		            )
		        )
		    ),
		    'order' => array('COUNT(Comment.id)' => 'desc')
		));
		debug($posts);





		// debug($result);
		// $options = array('order' => array('Post.title' => 'asc'));

  		if ($this->RequestHandler->isRss()) {
    		$options = array_merge($options, array(
       			'order' => array('Post.created' => 'desc'),
       			'limit' => 5)
    		);
  		}

  	$params = array();
	$params = array(
		    // 'conditions' => array('Model.field' => $thisValue), //array of conditions
		    // 'recursive' => 1, //int
		    //array of field names
		    // 'fields' => array('Model.field1', 'DISTINCT Model.field2'),
		    //string or array defining order
		    'order' => array('Post.body DESC'),
		    // 'group' => array('Model.field'), //fields to GROUP BY
		    // 'limit' => n, //int
		    // 'page' => n, //int
		    // 'offset' => n, //int
		    // 'callbacks' => true //other possible values are false, 'before', 'after'
		);

  		// $options = array_merge($options, $result);
		// $posts = $this->Post->find('all', $options);
		// $posts = $this->Post->find('all', $params);
	// $posts = $this->Post->find('all');
	// debug($posts);

		$this->set(compact('posts'));

	  	$this->Post->recursive = 0;
		$this->paginate = array('limit' => 3);
		$this->set('posts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$this->set('post', $this->Post->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			

			if(!empty($this->data['Post']['audio_file']['name']))
            {
                $file = $this->data['Post']['audio_file'];
                $ary_ext = array('jpg','jpeg','gif','png', 'mp3'); 
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); 
                if(in_array($ext, $ary_ext))
                {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'audio/'.$this->request->data['Post']['title']);
                    $this->request->data['Post']['audio_file'] = time().$file['name'];
                }
            }

			$url = $this->request->data['Post']['video_file'];
			preg_match(
				'/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/',
				$url,
				$matches
			);		
			$this->request->data['Post']['video_file'] = "http://player.vimeo.com/video/".$matches[2];
			$this->request->data['Post']['audio_file'] = $this->request->data['Post']['title'];
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Flash->success(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The post could not be saved. Please, try again.'));
			}
		}
		$users = $this->Post->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Post->save($this->request->data)) {
				$this->Flash->success(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
		$users = $this->Post->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Post->delete()) {
			$this->Flash->success(__('The post has been deleted.'));
		} else {
			$this->Flash->error(__('The post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
