<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red('user/login');
        }
    }

    public function index() {
        
    }

    public function kgb() {
        $this->load->model('model_kgb');
        $id_kgb = safe_decode($this->uri->segment(3));
        $this->data['data_kgb'] = $this->model_kgb->select_kgb($id_kgb);
        if (!empty($this->data['data_kgb'])) {
            $this->load->view('cetak/fpdf-kgb', $this->data);
        } else {
            show_404();
        }
    }

    public function pegawai() {
        $this->load->model('model_pegawai');
        $datapeg = $this->model_pegawai->select(safe_decode($this->uri->segment(3)));
        //////////////////////////////////KEPERLUAN LOAD FOTO - MULAI
        @$file = $datapeg->nip . '_' . replace_filename($datapeg->nama) . '.jpg';
        $path = 'downloads/foto';
        $filepath = base_url($path) . '/' . $file;
        $is_file_exist = read_file($filepath);

        $data['header'] = 'Pegawai';
        $data['tema'] = 'primary';
        $data['is_file_exist'] = $is_file_exist;

        $data['file'] = $file;
        $data['path'] = $path;
        $data['filepath'] = $filepath;
        //////////////////////////////////KEPERLUAN LOAD FOTO - SELESAI

        $data['data_pegawai'] = $datapeg;

        $this->load->model('model_bagian');
        $data['data_bagian'] = $this->model_bagian->view();

        $this->load->model('model_agama');
        $data['data_agama'] = $this->model_agama->view();

        $this->load->model('model_golongan');
        $data['data_golongan'] = $this->model_golongan->view();
        $this->load->view('cetak/fpdf-pegawai-biodata', $data);
    }

}
