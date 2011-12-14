<?php

class UsersModel extends BaseModel {

	public function source() {
		return $this->db->select('SQL_CALC_FOUND_ROWS *, (daughters + sons) children')
			->from('users');
	}



	public function save($set) {
		if (@!$set['id'])
			$this->db->insert('users', $set)->execute();
		else
			$this->db->update('users', $set)->where('id = %i', $set['id'])->execute();
	}



	public function delete($id) {
		$this->db->delete('users')->where('id = %i', $id)->execute();
	}
}
