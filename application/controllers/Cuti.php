<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class cuti extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('cuti')) {
            red(base_url('user/login'));
            die();
        }
        if (empty($this->input->post('new_q'))) {
            $this->cek_periode();
        } else {
            $this->generate_new_periode();
        }
    }

    public function listing_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            //panggil library datatables
            $this->load->library('datatables_ssp');

            //atur nama tablenya disini
            $table = 'view_cuti_listing';

            // Table's primary key
            $primaryKey = 'nip';

            $columns = array(
                array('db' => 'nip', 'dt' => 'nip'),
                array('db' => 'nama', 'dt' => 'nama'),
                array(
                    'db' => 'gol_akhir',
                    'dt' => 'gol',
                    'formatter' => function($d) {
                return convert_golongan($d);
            }),
                array('db' => 'sisa', 'dt' => 'sisa'),
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

    public function cek_periode() {
        $this->load->model('model_cuti');
        $data = $this->input->post();
        if ($this->model_cuti->cek_periode() == 2) {
            $data['header'] = 'Cuti';
            $data['tema'] = 'primary';
            $data['data'] = 'awal_tahun';
            $this->load->view('page/v-cuti_awal_tahun', $data);
            die();
        }
    }

    public function generate_new_periode() {
        $kuantitas = $this->input->post('new_q');
        $this->load->model('model_cuti');
        $data = $this->model_cuti->generate_new_periode($kuantitas);
        echo $data;
        die();
    }

    public function index() {
        $this->listing();
    }

    public function listing() {
        //$this->load->model('model_cuti');
        $data['header'] = 'Cuti';
        $data['tema'] = 'primary';
        //$data['data_cuti'] = $this->model_cuti->listing();
        $this->load->view('page/v-cuti', $data);
    }

    public function simpan() {
        $data = $this->input->post();
        $mode = $this->input->post('mode');
        unset($data['mode']);
        $this->load->model('model_cuti');
        if ($mode == 'edit') {
            $simpan = $this->model_cuti->simpan($data, $mode);
            echo $simpan;
        }
        if ($mode == 'tambah') {
            $simpan = $this->model_cuti->simpan($data, $mode);
            echo $simpan;
        }
    }

    public function view() {
        $this->load->model('model_cuti');
        $data['header'] = 'Cuti';
        $data['tahun'] = date("Y");
        $data['tema'] = 'primary';
        $data['data_cuti'] = $this->model_cuti->view($this->uri->segment(3));
        $this->load->view('page/v-cuti_view', $data);
    }

    public function select() {
        $this->load->model('model_cuti');
        $id_cuti = $this->uri->segment(4);
        $data['header'] = 'Tambah Data Cuti';
        $data['tema'] = 'primary';
        if ($id_cuti > 0) {
            $data['data'] = $this->model_cuti->select($id_cuti);
            $data['mode'] = 'edit';
        } else {
            $data['mode'] = 'tambah';
        }
        $this->load->view('page/v-cuti_select', $data);
    }

    public function delete() {
        $this->load->model('model_cuti');
        $this->model_cuti->delete($this->input->post('id_cuti'));
    }

}
