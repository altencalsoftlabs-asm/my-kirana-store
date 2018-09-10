<?php 
class KiranacontrollerCustomerCustomer extends ControllerCustomerCustomer {
	private $error = array();

	public function index() {
		//print 'aadda';
		//exit;
		$this->load->language('customer/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/customer');

		$this->getList();
	}
	
}