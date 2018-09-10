<?php
class ModelKiranaApprovalUser extends Model {
	const APPROVAL_STATUS_PENDING=0;
	const APPROVAL_STATUS_SUCCESS=1;
	const APPROVAL_STATUS_REJECT=2;
	public function addApproval($data) {
		$query=$this->db->query("select approval_id,approval_status FROM `" . DB_PREFIX . "product_approval_user` WHERE product_id = '" . (int)$data['product_id'] . "' AND  user_id = '" . (int)$data['user_id'] . "'");
		$approval_id=$query->row['approval_id'];
		$approval_status=$query->row['approval_status'];
		if($approval_id==''){
		$this->db->query("INSERT INTO `" . DB_PREFIX . "product_approval_user` SET product_id = '" . (int)$data['product_id'] . "', user_id = '" . (int)$data['user_id'] . "', date_added = NOW(), date_modified = NOW()");
		}else{
			$this->db->query("UPDATE `" . DB_PREFIX . "product_approval_user` SET approval_status = '" . APPROVAL_STATUS_PENDING . "', date_modified = NOW() where approval_id='$approval_id'");
		}
		//return $this->db->getLastId();
	}
	public function editApprovaluserbyproductid($product_id,$data) {
		$user_id=$this->user->getId();
		
		$actiontaken=$data['actiontaken'];
		$fld_comment=$data['fld_comment'];
		$approval_status='';
		if($actiontaken==1){
			$approval_status=self::APPROVAL_STATUS_SUCCESS;
		}else if($actiontaken==0){
			$approval_status=self::APPROVAL_STATUS_REJECT;
		}
		if($approval_status!=''){
		$this->db->query("UPDATE " . DB_PREFIX . "product_approval_user SET 	approval_status='$approval_status',date_modified = NOW() WHERE product_id = '" . (int)$product_id . "' AND user_id='$user_id'");
		//save comment
		 if($fld_comment!=''){
			 $this->db->query("INSERT INTO `" . DB_PREFIX . "product_approval_comment` SET product_id = '" . (int)$product_id . "', user_id = '" . (int)$user_id . "',fld_comment='" . $this->db->escape($fld_comment) . "', date_added = NOW()");
		 }
		}
	}
	public function getTotalApprovebystatus($product_id,$approval_status) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_approval_user where product_id='$product_id' AND approval_status='$approval_status'");
		return $query->row['total'];
	}
	public function getNoOfApproval($product_id) {
		$query = $this->db->query("SELECT no_of_approval,status FROM " . DB_PREFIX . "product where product_id='$product_id'");
		return $query->row;
	}
	public function checkalreadytakenaction($product_id){
		$user_type_id=$this->user->getTypeId();
			$this->load->model('kirana/user_type');
			if(($user_type_id==ModelKiranaUserType::SUPER_ADMIN_ID OR $user_type_id==ModelKiranaUserType::DATAENTRY_ADMIN_ID)){
				return 1;
			}else{
		$user_id=$this->user->getId();
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_approval_user where approval_status='".self::APPROVAL_STATUS_PENDING."' AND user_id='$user_id' AND product_id = '" . (int)$product_id . "'");
		return $query->row['total'];
			}
	}
	
}