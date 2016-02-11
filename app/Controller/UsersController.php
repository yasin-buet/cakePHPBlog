<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	// public $components = array('Paginator', 'Flash', 'Session');
	public $components = array(
		'Paginator',
		'Flash',
		'Session',
	    'Auth' => array(
	        'authenticate' => array(
	            'Form' => array(
	                'fields' => array(
	                    'username' => 'username',
	                    'password' => 'password'
	                ),
	            )
	        )
	    )
    );
	public $helpers = array('Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);

			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function beforeFilter() {
    parent::beforeFilter();
      $this->Auth->authenticate = array(          
                    'Form' => array(
                        'fields' => array(
                            'username' => 'username',
                            'password' => 'password'
                                )
                            )
                        );
    // Allow users to register and logout.
    $this->Auth->allow('login', 'add', 'logout', 'social_login','social_endpoint');
}

	public function login() {
	    if ($this->request->is('post')) {
	    	
	    	debug(env('PHP_AUTH_USER'));

	    	debug($this->Auth->identify($this->request, $this->response));
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirectUrl());
	        }
	        // echo $this->Session->flash('auth');
	        // debug($this->Session->flash());
	        $this->Flash->error(__('Invalid username or password, try again'));
	    }
	}
	public function social_login($provider) {
	    if ($this->Hybridauth->connect($provider)){
	        $this->_successfulHybridauth($provider,$this->Hybridauth->user_profile);
	    } else {
	        // error
	        $this->Session->setFlash($this->Hybridauth->error);
	        $this->redirect($this->Auth->loginAction);
	    }
	}

	public function logout() {
    	return $this->redirect($this->Auth->logout());
	}
}
