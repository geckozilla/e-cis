<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kgb extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in()) {
            red('user/login');
        }
    }

    public function index() {
        $this->listing();
    }

    public function listing_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            //panggil library datatables
            $this->load->library('datatables_ssp');

            //atur nama tablenya disini
            $table = 'view_kgb_listing';

            // Table's primary key
            $primaryKey = 'nip';

            $columns = array(
                array('db' => 'nip', 'dt' => 'nip'),
                array('db' => 'nama', 'dt' => 'nama'),
                array(
                    'db' => 'gol_akhir',
                    'dt' => 'gol',
                    'formatter' => function( $d ) {
                return convert_golongan($d);
            }),
                array('db' => 'next_date_kgb', 'dt' => 'kgb'),
                array('db' => 'next_mkg_kgb', 'dt' => 'mkg'),
                array('db' => 'last_date_kgb', 'dt' => 'last'),
            );

            // MySQL connection information
            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            echo json_encode(
                    Datatables_ssp::simple($_GET, $sql_details, $table, $primaryKey, $columns)
            );
        }
    }

    public function listing() {
        //$this->load->model('model_kgb');
        $data['header'] = 'Kenaikan Gaji Berkala';
        $data['tema'] = 'primary';
        //$data['data_pegawai'] = $this->model_kgb->listing();
        $this->load->view('page/v-kgb', $data);
    }

    public function view() {
        $this->load->model('model_kgb');
        $data['header'] = 'Kenaikan Gaji Berkala';
        $data['tema'] = 'primary';
        $data['data_pegawai'] = $this->model_kgb->view($this->uri->segment(3));
        $this->load->view('page/v-kgb_view', $data);
    }

    public function simpan() {
        $data = $this->input->post();
        $mode = $this->input->post('mode');
        unset($data['mode']);
        $this->load->model('model_kgb');
        if ($mode == 'edit') {
            $data['mkg_sk_lama'] = str_replace(' ', '', $this->input->post('mkg_sk_lama'));
            $data['mkg_sk_baru'] = str_replace(' ', '', $this->input->post('mkg_sk_baru'));
            $simpan = $this->model_kgb->simpan($data, $mode);
            echo $simpan;
        }
        if ($mode == 'tambah') {
            $data['no_sk_baru'] = $this->model_kgb->create_no_sk_kgb($this->input->post('tgl_sk_baru')); //buat nomer sk otomatis
            $data['mkg_sk_lama'] = str_replace(' ', '', $this->input->post('mkg_sk_lama'));
            $data['mkg_sk_baru'] = str_replace(' ', '', $this->input->post('mkg_sk_baru'));
            $simpan = $this->model_kgb->simpan($data, $mode);
            echo $simpan;
        }
    }

    public function select() {
        $this->load->model('model_kgb');
        $id_kgb = $this->uri->segment(4);
        $data['header'] = 'Kenaikan Gaji Berkala';
        $data['tema'] = 'primary';
        if ($id_kgb > 0) {
            $data['data'] = $this->model_kgb->select($id_kgb);
            $data['mode'] = 'edit';
        } else {
            $data['data'] = $this->model_kgb->data_awal($this->uri->segment(3));
            $data['mode'] = 'tambah';
        }
        $this->load->view('page/v-kgb_select', $data);
    }

    public function delete() {
        $this->load->model('model_kgb');
        $this->model_kgb->delete($this->input->post('id_kgb'));
    }

    public function cetak() {
        $this->load->model('model_kgb');
        $id_kgb = safe_decode($this->uri->segment(3));
        $this->data['data_kgb'] = $this->model_kgb->select_kgb($id_kgb);
        $this->load->view('cetak/fpdf-kgb', $this->data);
    }

    public function setting_simpan() {
        $data = $this->input->post();
        $this->load->model('model_kgb');
        $this->model_kgb->setting_simpan($data);
    }

    public function setting() {
        $this->load->model('model_kgb');
        $data['header'] = 'Pengaturan KGB';
        $data['tema'] = 'red';
        $data['data_kgb'] = $this->model_kgb->view_setting();
        $this->load->view('page/v-kgb_setting', $data);
    }

}
