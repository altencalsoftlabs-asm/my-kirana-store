<?php
class ModelKiranaBulkupload extends Model {
	const STATUS_PENDING=0;
	const STATUS_PROCESSING=1;
	const STATUS_FAIL=2;
	const STATUS_COMPLETE=3;
	public function addBulkupload($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "bulkupload SET filename = '" . $this->db->escape($data['filename']) . "',date_added = NOW(),date_modified = NOW()");
		$bulkupload_id = $this->db->getLastId();
		//return $bulkupload_id;
	}

	public function editBulkupload($bulkupload_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "bulkupload SET filename = '" . $this->db->escape($data['filename']) . "',date_modified = NOW() WHERE bulkupload_id = '" . (int)$bulkupload_id . "'");
	}
	public function updateBulkuploadstatus($bulkupload_id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX . "bulkupload SET status = '$status' ,date_modified = NOW() WHERE bulkupload_id = '" . (int)$bulkupload_id . "'");
	}
	public function updateBulkuploadda($bulkupload_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "bulkupload SET fld_message='" . $this->db->escape($data['fld_message']) . "',status = '" .$data['status'] . "',date_modified = NOW() WHERE bulkupload_id = '" . (int)$bulkupload_id . "'");
	}

	public function deleteBulkupload($bulkupload_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "bulkupload WHERE bulkupload_id = '" . (int)$bulkupload_id . "'");
	}

	public function getBulkupload($bulkupload_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bulkupload d  WHERE d.bulkupload_id = '" . (int)$bulkupload_id . "'");
		return $query->row;
	}

	public function getBulkuploads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "bulkupload d WHERE 1=1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND d.filename LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'd.filename',
			'd.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY d.filename";
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

	
	public function getTotalBulkuploads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bulkupload");

		return $query->row['total'];
	}
	public function getTextstatus($status) {
		if($status==self::STATUS_PENDING){
			$text_status='text_pending';
		}else if($status==self::STATUS_PROCESSING){
			$text_status='text_processing';
		}else if($status==self::STATUS_FAIL){
			$text_status='text_fail';
		}else if($status==self::STATUS_COMPLETE){
			$text_status='text_complete';
		}
		return $text_status;
	}
	public function validatefile($bulkupload_id){
	  $res=array('errortype'=>false,'msg'=>'');
	  if($bulkupload_id==''){
		  $res['errortype']=true;
		  $res['msg']='warning_blankid';
	  }else if($bulkupload_id!=''){
		  $row=$this->getBulkupload($bulkupload_id);
		  $filepath=DIR_UPLOAD.$row['filename'];
		  $status=$row['status'];
		  if($status==self::STATUS_COMPLETE){
		  $res['errortype']=true;
		  $res['msg']='text_alreadyprocess';
		  }else if(!file_exists($filepath)){
		  $res['errortype']=true;
		  $res['msg']='warning_fileexit';
		  $datasave=array();
		  $datasave['fld_message']="File is not exists.";
		  $datasave['status']=self::STATUS_FAIL;
		  $this->updateBulkuploadda($bulkupload_id,$datasave);
		  }elseif(file_exists($filepath)){
			  @chmod($filepath,0777);
			  $this->load->model('localisation/language');
			require_once DIR_MODIFICATION . 'system/library/phpexcel-1.8/Classes/PHPExcel.php';
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load($filepath);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);
if(count($sheetData)>1){
foreach($sheetData as $k=>$v){
	if($k==1){
		//skip means header
		//change status to processing
		$datasave=array();
		  $datasave['fld_message']='';
		  $datasave['status']=self::STATUS_PROCESSING;
		$this->updateBulkuploadda($bulkupload_id,$datasave);
	}elseif($k>1){
		$language_code=$v['A']; //language
		$product_name=$v['B']; //product name
		$meta_title=$v['C']; //meta tag title
		$model=$v['D']; //Model
		$pack_type=$v['E']; //Packtype
		$rowl=$this->model_localisation_language->getLanguageByCode($language_code);
		$language_id=$rowl['language_id'];
		if($language_id==''){
		  $fld_messgae="Line no. $k language code is incorrect!";
		  $res['errortype']=true;
		  $res['msg']='warning_problemfile';
		  $datasave=array();
		  $datasave['fld_message']=$fld_messgae;
		  $datasave['status']=self::STATUS_FAIL;
		  $this->updateBulkuploadda($bulkupload_id,$datasave);
		  break;
		}else if($meta_title==''){
		  $fld_messgae="Line no. $k meta tag title is blank!";
		  $res['errortype']=true;
		  $res['msg']='warning_problemfile';
		  $datasave=array();
		  $datasave['fld_message']=$fld_messgae;
		  $datasave['status']=self::STATUS_FAIL;
		  $this->updateBulkuploadda($bulkupload_id,$datasave);
		  break;
		}else if($product_name==''){
		  $fld_messgae="Line no. $k product name is blank!";
		  $res['errortype']=true;
		  $res['msg']='warning_problemfile';
		  $datasave=array();
		  $datasave['fld_message']=$fld_messgae;
		  $datasave['status']=self::STATUS_FAIL;
		  $this->updateBulkuploadda($bulkupload_id,$datasave);
		  break;
		}
	}
}
}
		  }
	  }
	  return $res;
    }
	public function parsefile($bulkupload_id){
		$row=$this->getBulkupload($bulkupload_id);
		  $filepath=DIR_UPLOAD.$row['filename'];
			  @chmod($filepath,0777);
			  $this->load->model('localisation/language');
			require_once DIR_MODIFICATION . 'system/library/phpexcel-1.8/Classes/PHPExcel.php';
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load($filepath);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);
if(count($sheetData)>1){
foreach($sheetData as $k=>$v){
	if($k==1){
		//skip means header
		//change status to processing
		$datasave=array();
		  $datasave['fld_message']='';
		  $datasave['status']=self::STATUS_PROCESSING;
		$this->updateBulkuploadda($bulkupload_id,$datasave);
	}elseif($k>1){
		$language_code=$v['A']; //language
		$product_name=$v['B']; //product name
		$meta_title=$v['C']; //meta tag title
		$model=$v['D']; //Model
		$pack_type=$v['E']; //Packtype
		$rowl=$this->model_localisation_language->getLanguageByCode($language_code);
		$language_id=$rowl['language_id'];
			$this->load->model('localisation/pack_type');
			$pack_type_id=$this->model_localisation_pack_type->getidbyname($language_id,$pack_type);
			$this->load->model('catalog/product');
			$datapro=array();
			$datapro['model']=$model;
			$datapro['sku']='';
			$datapro['upc']='';
			$datapro['ean']='';
			$datapro['jan']='';
			$datapro['isbn']='';
			$datapro['mpn']='';
			$datapro['location']='';
			$datapro['quantity']=1;
			$datapro['minimum']=1;
			$datapro['subtract']=1;
			$datapro['stock_status_id']='';
			$datapro['date_available']=date('Y-m-d');
			$datapro['date_available_end']='';
			$datapro['manufacturer_id']='';
			$datapro['shipping']='';
			$datapro['price']='';
			$datapro['points']='';
			$datapro['weight']='';
			$datapro['weight_class_id']=1;
			$datapro['length']='';
			$datapro['width']='';
			$datapro['height']='';
			$datapro['length_class_id']='';
			$datapro['status']=0;
			$datapro['tax_class_id']='';
			$datapro['sort_order']='';
			$datapro['seasonal']='';
			$datapro['seasonal_duration']='';
			$datapro['seasonal_start_date']='';
			$datapro['seasonal_end_date']='';
			$datapro['private_item']='';
			$datapro['product_gender_id']='';
			$datapro['kirana_availability']='';
			$datapro['kirana_type_id']='';
			$datapro['kirana_locality_id']='';
			$datapro['gift_item']='';
			$datapro['regional_product']='';
			$datapro['region_definition']='';
			$datapro['description']='';
			$datapro['tag']='';
			$datapro['meta_description']='';
			$datapro['meta_keyword']='';
			$datapro['pack_type']=$pack_type_id;
			$datapro['product_description'][$language_id]['name']=$product_name;
			$datapro['product_description'][$language_id]['meta_title']=$meta_title;
			$this->model_catalog_product->addProduct($datapro);
		  	
	}
}
$datasave=array();
		  $datasave['fld_message']='';
		  $datasave['status']=self::STATUS_COMPLETE;
		  $this->updateBulkuploadda($bulkupload_id,$datasave);
		  //@unlink($filepath);
}
		  
    }
}