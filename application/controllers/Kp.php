<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kp extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red('user/login');
        }
    }

    public function index() {
        $this->view();
    }

    public function view() {
        $this->load->model('model_kp');
        $data['header'] = 'Kenaikan Pangkat';
        $data['tema'] = 'primary';
        $data['data_kp'] = $this->model_kp->view();
        $this->load->view('page/v-kp', $data);
    }

}
