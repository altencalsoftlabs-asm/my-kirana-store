<?php
class ModelKiranaUserType extends Model {
	const SUPER_ADMIN_ID=1;
	const APPROVAL_ADMIN_ID=2;
	const DATAENTRY_ADMIN_ID=3;
	const NORMAL_ADMIN_ID=4;
	public function getUserType($user_type_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_type WHERE user_type_id = '" . (int)$user_type_id . "'");

		$user_type = array(
			'name'       => $query->row['name']
		);

		return $user_type;
	}

	public function getUserTypes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "user_type";

		$sql .= " ORDER BY name";

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getApprovalUsers() {
		$sql = "SELECT user_id FROM " . DB_PREFIX . "user";
        $sql .= " where user_type_id='".self::APPROVAL_ADMIN_ID."' AND status='1'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalUserTypes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user_type");

		return $query->row['total'];
	}
	
}