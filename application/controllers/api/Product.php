<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Product extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('Mproduct', 'product');
    }

    function index_get() {
        $id = $this->get('ID');
        if ($id === null) {
            $product = $this->product->getall();
        } else {
            $this->db->where('ID', $id);
            $product = $this->product->getall($id);
		}
				
        if ($product) {
			$this->response([
				'status' => true,
				'data' => $product
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
        $id = $this->delete('ID');
        if ($id === null) {
			$this->response([
				'status' => false,
				'message' => 'provide an id'
			], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->product->deleteProduct($id) > 0) {
				$this->response([
					'status' => true,
					'ID' => $id,
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
