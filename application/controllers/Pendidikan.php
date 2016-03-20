<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pendidikan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('pendidikan')) {
            red(base_url('user/login'));
            die();
        }
    }

    public function index() {
        $this->select();
    }

    public function select() {
        $this->load->model('model_profil');
        $data['header'] = 'Maintenance';
        $data['tema'] = 'primary';
        $this->load->view('page/v-maintenance', $data);
    }

}
