<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categori_model extends CI_Model {

	public function getCategori($id=null){
		if ($id === null) {
			return $this->db->get('p_categori')->result_array();
		} else {
			return $this->db->get_where('p_categori', ['categori_id' => $id])->result_array();
		}
	}

	public function deleteCategori($id){
		$this->db->delete('p_categori', ['categori_id' => $id]);
		return $this->db->affected_rows();
	}

	public function createCategori($data){
		$this->db->insert('p_categori', $data);
		return $this->db->affected_rows();
		
	}

	public function updateCategori($data, $id){
		$this->db->update('p_categori', $data, ['categori_id' => $id]);
		return $this->db->affected_rows();
		
	}

}

/* End of file Mahasiswa_model.php */

?>
