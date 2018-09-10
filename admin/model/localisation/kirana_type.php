<?php
class ModelLocalisationKiranaType extends Model {
	public function addKiranaType($data) {
		foreach ($data['kirana_type'] as $language_id => $value) {
			if (isset($kirana_type_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_type SET kirana_type_id = '" . (int)$kirana_type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_type SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

				$kirana_type_id = $this->db->getLastId();
			}
		}

		$this->cache->delete('kirana_type');
		
		return $kirana_type_id;
	}

	public function editKiranaType($kirana_type_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "kirana_type WHERE kirana_type_id = '" . (int)$kirana_type_id . "'");

		foreach ($data['kirana_type'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_type SET kirana_type_id = '" . (int)$kirana_type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('kirana_type');
	}

	public function deleteKiranaType($kirana_type_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "kirana_type WHERE kirana_type_id = '" . (int)$kirana_type_id . "'");

		$this->cache->delete('kirana_type');
	}

	public function getKiranaType($kirana_type_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kirana_type WHERE kirana_type_id = '" . (int)$kirana_type_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getKiranaTypees($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "kirana_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
		} else {
			$kirana_type_data = $this->cache->get('kirana_type.' . (int)$this->config->get('config_language_id'));

			if (!$kirana_type_data) {
				$query = $this->db->query("SELECT kirana_type_id, name FROM " . DB_PREFIX . "kirana_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$kirana_type_data = $query->rows;

				$this->cache->set('kirana_type.' . (int)$this->config->get('config_language_id'), $kirana_type_data);
			}

			return $kirana_type_data;
		}
	}

	public function getKiranaTypeDescriptions($kirana_type_id) {
		$kirana_type_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kirana_type WHERE kirana_type_id = '" . (int)$kirana_type_id . "'");

		foreach ($query->rows as $result) {
			$kirana_type_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $kirana_type_data;
	}

	public function getTotalKiranaTypees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "kirana_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
	public function getidbyname($language_id,$name) {
		$query = $this->db->query("SELECT kirana_type_id FROM " . DB_PREFIX . "kirana_type WHERE language_id = '" . (int)$language_id . "' AND name='$name'");
		return $query->row['kirana_type_id'];
	}
}