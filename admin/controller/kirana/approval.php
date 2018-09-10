<?php
class ControllerKiranaApproval extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kirana/approval');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kirana/approval');

	}
	
	public function edit() {
		$this->load->language('kirana/approval');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('kirana/approval');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm() && ($this->request->get['product_id']!='')) {
		//check if order approving by superadmin
		$user_type_id=$this->user->getTypeId();
			$this->load->model('kirana/user_type');
			if(($user_type_id==ModelKiranaUserType::SUPER_ADMIN_ID)){
				$text_superadminapprove=$this->language->get('text_superadminapprove');
				$text_superadminreject=$this->language->get('text_superadminreject');
				$datapost=$this->request->post;
			  	$datapost['text_superadminapprove']=$text_superadminapprove;
			  	$datapost['text_superadminreject']=$text_superadminreject;
				$this->model_kirana_approval->editApproverbysuperadmin($this->request->get['product_id'], $datapost);
				
			}else{
		$this->model_kirana_approval->editApprover($this->request->get['product_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');
		
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['approval_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['actiontaken'])) {
			$data['error_actiontaken'] = $this->error['actiontaken'];
		} else {
			$data['error_actiontaken'] = '';
		}
		if ($this->request->get['product_id']=='') {
			$data['error_productid'] = $this->language->get('error_productid');
		} else {
			$data['error_productid'] = '';
		}
		

		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('kirana/approval/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kirana/approval/edit', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/product', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $this->session->data['user_token'];

		$data['approval_id'] = 0;

		if (isset($this->request->post['fld_comment'])) {
			$data['fld_comment'] = $this->request->post['fld_comment'];
		}else {
			$data['fld_comment'] = '';
		}

		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kirana/approval_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kirana/approval')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$this->load->model('kirana/approval_user');
		$alreadyactiontaken=$this->model_kirana_approval_user->checkalreadytakenaction($this->request->get['product_id']);
	if($alreadyactiontaken==0 && $this->request->get['product_id']!=''){
		$this->error['warning'] = $this->language->get('text_alreadyaction');
	}
		if (($this->request->post['actiontaken']=='')) {
			$this->error['actiontaken'] = $this->language->get('error_actiontaken');
		}
		return !$this->error;
	}
}