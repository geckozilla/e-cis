<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red('user/login');
        }
    }

    public function index() {
        $data['header'] = 'Dashboard';
        $data['tema'] = 'default';
        $this->load->model('model_dashboard');
        $data['alert_kgb'] = $this->model_dashboard->alert_kgb();
        $data['log_timeline'] = $this->model_dashboard->log_timeline(10);
        $data['pegawai_aktif'] = $this->model_dashboard->pegawai_aktif();
        $data['persebaran_golongan'] = $this->model_dashboard->persebaran_golongan();
        $data['persebaran_pendidikan'] = $this->model_dashboard->persebaran_pendidikan();
        $data['persebaran_bagian'] = $this->model_dashboard->persebaran_bagian();
        $data['pegawai_pria'] = $this->model_dashboard->pegawai_pria();
        $data['pegawai_wanita'] = $this->model_dashboard->pegawai_wanita();
        $this->load->view('page/v-dashboard', $data);
    }

}
