<?php
class ModelLocalisationPackType extends Model {
	public function addPackType($data) {
		foreach ($data['pack_type'] as $language_id => $value) {
			if (isset($pack_type_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pack_type SET pack_type_id = '" . (int)$pack_type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pack_type SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

				$pack_type_id = $this->db->getLastId();
			}
		}

		$this->cache->delete('pack_type');
		
		return $pack_type_id;
	}

	public function editPackType($pack_type_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pack_type WHERE pack_type_id = '" . (int)$pack_type_id . "'");

		foreach ($data['pack_type'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pack_type SET pack_type_id = '" . (int)$pack_type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('pack_type');
	}

	public function deletePackType($pack_type_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pack_type WHERE pack_type_id = '" . (int)$pack_type_id . "'");

		$this->cache->delete('pack_type');
	}

	public function getPackType($pack_type_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pack_type WHERE pack_type_id = '" . (int)$pack_type_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPackTypees($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "pack_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
			$pack_type_data = $this->cache->get('pack_type.' . (int)$this->config->get('config_language_id'));

			if (!$pack_type_data) {
				$query = $this->db->query("SELECT pack_type_id, name FROM " . DB_PREFIX . "pack_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$pack_type_data = $query->rows;

				$this->cache->set('pack_type.' . (int)$this->config->get('config_language_id'), $pack_type_data);
			}

			return $pack_type_data;
		}
	}

	public function getPackTypeDescriptions($pack_type_id) {
		$pack_type_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pack_type WHERE pack_type_id = '" . (int)$pack_type_id . "'");

		foreach ($query->rows as $result) {
			$pack_type_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $pack_type_data;
	}

	public function getTotalPackTypees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pack_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
	public function getidbyname($language_id,$name) {
		$query = $this->db->query("SELECT pack_type_id FROM " . DB_PREFIX . "pack_type WHERE language_id = '" . (int)$language_id . "' AND name='$name'");
		return $query->row['pack_type_id'];
	}
}