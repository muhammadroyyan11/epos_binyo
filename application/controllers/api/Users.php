<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('Musers', 'user');
    }

    function index_get() {
        $id = $this->get('id');
        if ($id === null) {
            $user = $this->user->getall();
        } else {
            $this->db->where('id', $id);
            $user = $this->user->getall($id);
		}
				
        if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'data' => 'id not found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	// DELETE
	function index_delete() {
        $id = $this->delete('categori_id');
        if ($id === null) {
			$this->response([
				'status' => false,
				'message' => 'provide an id'
			], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->categori->deleteCategori($id) > 0) {
				$this->response([
					'status' => true,
					'categori_id' => $id,
					'message' => 'deleted'
				], REST_Controller::HTTP_OK);	
			} else {
				$this->response([
					'status' => false,
					'message' => 'id not found!'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
	
	// POST
	public function index_post(){
		$data = [
			'name' => $this->post('name'),
		];

		if ($this->categori->createCategori($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new categori has been created'
			], REST_Controller::HTTP_CREATED);	
		} else {
			$this->response([
				'status' => false,
				'message' => 'failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	// PUT
	public function index_put(){
		$id = $this->put('categori_id');
		$data = [
			'name' => $this->put('name'),
		];
		if ($this->categori->updateCategori($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new categori has been updated'
			], REST_Controller::HTTP_OK);	
		} else {
			$this->response([
				'status' => false,
				'message' => 'failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
?>
