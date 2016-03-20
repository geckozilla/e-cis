<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Legal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red(base_url('user/login'));
            die();
        }
    }

    public function index() {
        $data['header'] = 'Dasar Hukum';
        $data['tema'] = 'primary';
        $this->load->view('page/v-legal', $data);
    }

    public function cuti() {
        $data['header'] = 'PERATURAN PEMERINTAH REPUBLIK INDONESIA NOMOR 24 TAHUN 1976';
        $data['tema'] = 'primary';
        $this->load->view('page/v-legal_cuti', $data);
    }
}
