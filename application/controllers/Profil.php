<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red(base_url('user/login'));
            die();
        }
    }

    public function index() {
        $this->select();
    }

    public function select() {
        $this->load->model('model_profil');
        $data['header'] = 'Ubah Profil';
        $data['tema'] = 'primary';
        $data['data_user'] = $this->model_profil->select(get_user_id());
        $this->load->view('page/v-profil_select', $data);
    }

    public function simpan() {
        $data = $this->input->post();
        $this->load->model('model_profil');
        $simpan = $this->model_profil->simpan($data);
        if ($simpan == 1) {
            $this->session->set_userdata(identity('user_profile'), $this->input->post('user_profile'));
            echo 'Profil berhasil diubah';
        }
    }

}
