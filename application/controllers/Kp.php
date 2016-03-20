<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kp extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('kp')) {
            red(base_url('user/login'));
            die();
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
            $table = 'view_kp_listing';

            // Table's primary key
            $primaryKey = 'nip';

            $columns = array(
                array('db' => 'nip', 'dt' => 'nip'),
                array('db' => 'nama', 'dt' => 'nama'),
                array(
                    'db' => 'gol',
                    'dt' => 'gol',
                    'formatter' => function($d) {
                return ($d == '-' ? '' : convert_golongan($d));
            }),
                array('db' => 'tmt_gol', 'dt' => 'tmt_gol'),
                array('db' => 'nama_kp', 'dt' => 'nama_kp'),
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
        $data['header'] = 'Kenaikan Pangkat';
        $data['tema'] = 'primary';
        //$data['data_pegawai'] = $this->model_kgb->listing();
        $this->load->view('page/v-kp', $data);
    }

    public function view() {
        $this->load->model('model_kp');
        $data['header'] = 'Kenaikan Pangkat';
        $data['tema'] = 'primary';
        $data['data_pegawai'] = $this->model_kp->view($this->uri->segment(3));
        $this->load->view('page/v-kp_view', $data);
    }

    public function select() {
        $this->load->model('model_kp');
        $id_kp = $this->uri->segment(4);
        $data['data_golongan'] = $this->model_kp->select_gol();
        $data['data_kp_jenis'] = $this->model_kp->select_kp_jenis();
        $data['header'] = 'Kenaikan Pangkat';
        $data['tema'] = 'primary';
        if ($id_kp > 0) {
            $data['data'] = $this->model_kp->select($id_kp);
            $data['mode'] = 'edit';
        } else {
            $data['mode'] = 'tambah';
        }
        $this->load->view('page/v-kp_select', $data);
    }

    public function delete() {
        $this->load->model('model_kp');
        $this->model_kp->delete($this->input->post('id_kp'));
    }

    public function simpan() {
        $data = $this->input->post();
        $mode = $this->input->post('mode');
        unset($data['mode']);
        $this->load->model('model_kp');
        if ($mode == 'edit') {
            $simpan = $this->model_kp->simpan($data, $mode);
            //echo $simpan;
        }
        if ($mode == 'tambah') {
            $simpan = $this->model_kp->simpan($data, $mode);
            //echo $simpan;
        }
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
