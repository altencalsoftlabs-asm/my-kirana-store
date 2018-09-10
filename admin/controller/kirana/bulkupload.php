<?php
class ControllerKiranaBulkupload extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('kirana/bulkupload');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('kirana/bulkupload');

        $this->getList();
    }

    public function processupload()
    {
        $this->load->language('kirana/bulkupload');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('kirana/bulkupload');
        $data = array();
        $data['text_form'] = $this->language->get('text_form_process');
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

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['cancel'] = $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $bulkupload_id = $this->request->get['bulkupload_id'];
        $res = $this->model_kirana_bulkupload->validatefile($bulkupload_id);
        if ($res['errortype'] == true) {
            $msg = $res['msg'];
            $this->session->data['warning'] = $this->language->get($msg);

        } elseif ($res['errortype'] == false) {
            $this->model_kirana_bulkupload->parsefile($bulkupload_id);
            $this->session->data['success'] = $this->language->get('text_success');

        }
        $this->response->redirect($this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true));
        /*$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        */
        $this->response->setOutput($this->load->view('kirana/bulkupload_list', $data));
        $this->getList();
    }

    public function add()
    {
        $this->load->language('kirana/bulkupload');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('kirana/bulkupload');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_kirana_bulkupload->addBulkupload($this->request->post);

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

            $this->response->redirect($this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('kirana/bulkupload');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('kirana/bulkupload');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_kirana_bulkupload->editBulkupload($this->request->get['bulkupload_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('kirana/bulkupload');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('kirana/bulkupload');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $bulkupload_id) {
                //unlink file
                $row = $this->model_kirana_bulkupload->getBulkupload($bulkupload_id);
                $filepath = DIR_UPLOAD . $row['filename'];
                @unlink($filepath);
                $this->model_kirana_bulkupload->deleteBulkupload($bulkupload_id);
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

            $this->response->redirect($this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'd.filename';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
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
            'href' => $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['add'] = $this->url->link('kirana/bulkupload/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('kirana/bulkupload/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['bulkuploads'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $bulkupload_total = $this->model_kirana_bulkupload->getTotalBulkuploads();

        $results = $this->model_kirana_bulkupload->getBulkuploads($filter_data);

        foreach ($results as $result) {
            $data['bulkuploads'][] = array(
                'bulkupload_id' => $result['bulkupload_id'],
                'filename' => $result['filename'],
                'fld_message' => $result['fld_message'],
                'status' => $this->language->get($this->model_kirana_bulkupload->getTextstatus($result['status'])),
                'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
                'date_modified' => date($this->language->get('datetime_format'), strtotime($result['date_modified'])),
                'process' => $this->url->link('kirana/bulkupload/processupload', 'user_token=' . $this->session->data['user_token'] . '&bulkupload_id=' . $result['bulkupload_id'] . $url, true)
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['warning'])) {
            $data['warning'] = $this->session->data['warning'];

            unset($this->session->data['warning']);
        } else {
            $data['warning'] = '';
        }
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . '&sort=d.filename' . $url, true);
        $data['sort_date_added'] = $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . '&sort=d.date_added' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $bulkupload_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($bulkupload_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bulkupload_total - $this->config->get('config_limit_admin'))) ? $bulkupload_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bulkupload_total, ceil($bulkupload_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('kirana/bulkupload_list', $data));
    }

    protected function getForm()
    {
        $data['text_form'] = !isset($this->request->get['bulkupload_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['filename'])) {
            $data['error_filename'] = $this->error['filename'];
        } else {
            $data['error_filename'] = '';
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
            'href' => $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (!isset($this->request->get['bulkupload_id'])) {
            $data['action'] = $this->url->link('kirana/bulkupload/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('kirana/bulkupload/edit', 'user_token=' . $this->session->data['user_token'] . '&bulkupload_id=' . $this->request->get['bulkupload_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('kirana/bulkupload', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->get['bulkupload_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $bulkupload_info = $this->model_kirana_bulkupload->getBulkupload($this->request->get['bulkupload_id']);
        }

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->get['bulkupload_id'])) {
            $data['bulkupload_id'] = $this->request->get['bulkupload_id'];
        } else {
            $data['bulkupload_id'] = 0;
        }


        if (isset($this->request->post['filename'])) {
            $data['filename'] = $this->request->post['filename'];
        } elseif (!empty($bulkupload_info)) {
            $data['filename'] = $bulkupload_info['filename'];
        } else {
            $data['filename'] = '';
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('kirana/bulkupload_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'kirana/bulkupload')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
            $this->error['filename'] = $this->language->get('error_filename');
        }

        if (!is_file(DIR_UPLOAD . $this->request->post['filename'])) {
            $this->error['filename'] = $this->language->get('error_exists');
        }


        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'kirana/bulkupload')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function upload()
    {
        $this->load->language('kirana/bulkupload');

        $json = array();

        // Check user has permission
        if (!$this->user->hasPermission('modify', 'kirana/bulkupload')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (!$json) {
            if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
                // Sanitize the filename
                $filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

                // Validate the filename length
                if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
                    $json['error'] = $this->language->get('error_filename');
                }

                // Allowed file extension types
                $alwext = array('application/excel', 'application/vnd.ms-excel', 'application/msexcel', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                $file_type = $this->request->files['file']['type'];
                if (!in_array($file_type, $alwext)) {
                    $json['error'] = $this->language->get('error_filetype');
                }

                // Return any upload error
                if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
                }
            } else {
                $json['error'] = $this->language->get('error_upload');
            }
        }

        if (!$json) {
            $file = time() . '_' . $filename;
            move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

            $json['filename'] = $file;
            $json['success'] = $this->language->get('text_upload');
            //save in db
            $this->load->model('kirana/bulkupload');
            $datasave = array();
            $datasave['filename'] = $file;
            $this->model_kirana_bulkupload->addBulkupload($datasave);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


}