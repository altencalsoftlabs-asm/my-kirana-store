<?php
class ModelKiranaApproval extends Model {
	public function editApprover($product_id,$data) {
		$this->load->model('kirana/approval_user');
		$this->load->model('catalog/product');
		$this->model_kirana_approval_user->editApprovaluserbyproductid($product_id,$data);
		//if product approved success change status form disable to enable
		//reject case
		$actiontaken=$data['actiontaken'];
		if($actiontaken==0){
			$this->model_catalog_product->updatekiranastatus($product_id);
		}
		$this->model_catalog_product->updateproductstaus($product_id);
	}
	public function editApproverbysuperadmin($product_id,$data) {
		$user_id=$this->user->getId();
		$this->load->model('kirana/approval_user');
		$this->load->model('catalog/product');
		$actiontaken=$data['actiontaken'];
		$fld_comment=$data['fld_comment'];
		$fld_message='';
		$approval_status='';
		$status='';
		$kirana_status='';
		if($actiontaken==''){
		if($actiontaken==1){
			$approval_status=ModelKiranaApprovalUser::APPROVAL_STATUS_SUCCESS;
			$status=KiranamodelCatalogProduct::STATUS_ENABLE;
			$kirana_status=KiranamodelCatalogProduct::KIRANA_STATUS_SUCCESS;
			$fld_message=$data['text_superadminapprove'];
		}else if($actiontaken==0){
			$approval_status=ModelKiranaApprovalUser::APPROVAL_STATUS_REJECT;
			$fld_message=$data['text_superadminreject'];
			$status=KiranamodelCatalogProduct::STATUS_DISABLE;
			$kirana_status=KiranamodelCatalogProduct::KIRANA_STATUS_REJECT;
		}
		$this->db->query("UPDATE " . DB_PREFIX . "product_approval_user SET 	approval_status='$approval_status',fld_message='$fld_message',date_modified = NOW() WHERE product_id = '" . (int)$product_id . "' AND approval_status='".ModelKiranaApprovalUser::APPROVAL_STATUS_PENDING."'");
		//save comment if any
		if($fld_comment!=''){
			 $this->db->query("INSERT INTO `" . DB_PREFIX . "product_approval_comment` SET product_id = '" . (int)$product_id . "', user_id = '" . (int)$user_id . "',fld_comment='" . $this->db->escape($fld_comment) . "', date_added = NOW()");
		 }
		$this->db->query("UPDATE " . DB_PREFIX . "product SET status='$status',	kirana_status='$kirana_status',date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
		}
	}
	public function getTotalapprovalhistory() {
		$user_id=$this->user->getId();
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_approval_user pau where pau.user_id='$user_id'");
		return $query->row['total'];
	}
	public function getApprovalhistory($data = array()) {
		$user_id=$this->user->getId();
		$sql = "SELECT * FROM " . DB_PREFIX . "product_approval_user pau LEFT JOIN " . DB_PREFIX . "product_description pd ON (pau.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pau.user_id='$user_id'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'pd.name',
			'pau.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

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
	
	public function getApprovaltext($approval_status) {
		$this->load->model('kirana/approval_user');
		$text_approval_status='text_approval_status_pending';
		if($approval_status==ModelKiranaApprovalUser::APPROVAL_STATUS_PENDING){
			$text_approval_status='text_approval_status_pending';
		}else if($approval_status==ModelKiranaApprovalUser::APPROVAL_STATUS_SUCCESS){
			$text_approval_status='text_approval_status_success';
		}else if($approval_status==ModelKiranaApprovalUser::APPROVAL_STATUS_REJECT){
			$text_approval_status='text_approval_status_reject';
		}
		return $text_approval_status;
	}
	
}