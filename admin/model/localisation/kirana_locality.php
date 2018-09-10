<?php
class ModelLocalisationKiranaLocality extends Model {
	public function addKiranaLocality($data) {
		foreach ($data['kirana_locality'] as $language_id => $value) {
			if (isset($kirana_locality_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_locality SET kirana_locality_id = '" . (int)$kirana_locality_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_locality SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

				$kirana_locality_id = $this->db->getLastId();
			}
		}

		$this->cache->delete('kirana_locality');
		
		return $kirana_locality_id;
	}

	public function editKiranaLocality($kirana_locality_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "kirana_locality WHERE kirana_locality_id = '" . (int)$kirana_locality_id . "'");

		foreach ($data['kirana_locality'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "kirana_locality SET kirana_locality_id = '" . (int)$kirana_locality_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('kirana_locality');
	}

	public function deleteKiranaLocality($kirana_locality_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "kirana_locality WHERE kirana_locality_id = '" . (int)$kirana_locality_id . "'");

		$this->cache->delete('kirana_locality');
	}

	public function getKiranaLocality($kirana_locality_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kirana_locality WHERE kirana_locality_id = '" . (int)$kirana_locality_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getKiranaLocalityes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "kirana_locality WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
			$kirana_locality_data = $this->cache->get('kirana_locality.' . (int)$this->config->get('config_language_id'));

			if (!$kirana_locality_data) {
				$query = $this->db->query("SELECT kirana_locality_id, name FROM " . DB_PREFIX . "kirana_locality WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$kirana_locality_data = $query->rows;

				$this->cache->set('kirana_locality.' . (int)$this->config->get('config_language_id'), $kirana_locality_data);
			}

			return $kirana_locality_data;
		}
	}

	public function getKiranaLocalityDescriptions($kirana_locality_id) {
		$kirana_locality_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kirana_locality WHERE kirana_locality_id = '" . (int)$kirana_locality_id . "'");

		foreach ($query->rows as $result) {
			$kirana_locality_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $kirana_locality_data;
	}

	public function getTotalKiranaLocalityes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "kirana_locality WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
	public function getidbyname($language_id,$name) {
		$query = $this->db->query("SELECT kirana_locality_id FROM " . DB_PREFIX . "kirana_locality WHERE language_id = '" . (int)$language_id . "' AND name='$name'");
		return $query->row['kirana_locality_id'];
	}
}