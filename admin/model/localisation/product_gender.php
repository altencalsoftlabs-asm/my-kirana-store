<?php
class ModelLocalisationProductGender extends Model {
	public function addProductGender($data) {
		foreach ($data['product_gender'] as $language_id => $value) {
			if (isset($product_gender_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_gender SET product_gender_id = '" . (int)$product_gender_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_gender SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

				$product_gender_id = $this->db->getLastId();
			}
		}

		$this->cache->delete('product_gender');
		
		return $product_gender_id;
	}

	public function editProductGender($product_gender_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_gender WHERE product_gender_id = '" . (int)$product_gender_id . "'");

		foreach ($data['product_gender'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_gender SET product_gender_id = '" . (int)$product_gender_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('product_gender');
	}

	public function deleteProductGender($product_gender_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_gender WHERE product_gender_id = '" . (int)$product_gender_id . "'");

		$this->cache->delete('product_gender');
	}

	public function getProductGender($product_gender_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_gender WHERE product_gender_id = '" . (int)$product_gender_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProductGenderes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product_gender WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
			$product_gender_data = $this->cache->get('product_gender.' . (int)$this->config->get('config_language_id'));

			if (!$product_gender_data) {
				$query = $this->db->query("SELECT product_gender_id, name FROM " . DB_PREFIX . "product_gender WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$product_gender_data = $query->rows;

				$this->cache->set('product_gender.' . (int)$this->config->get('config_language_id'), $product_gender_data);
			}

			return $product_gender_data;
		}
	}

	public function getProductGenderDescriptions($product_gender_id) {
		$product_gender_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_gender WHERE product_gender_id = '" . (int)$product_gender_id . "'");

		foreach ($query->rows as $result) {
			$product_gender_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $product_gender_data;
	}

	public function getTotalProductGenderes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_gender WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
}