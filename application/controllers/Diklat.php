<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Diklat extends CI_Controller {

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
            $table = 'view_diklat_listing';

            // Table's primary key
            $primaryKey = 'nip';


            $columns = array(
                array('db' => 'nip', 'dt' => 'nip'),
                array('db' => 'nama', 'dt' => 'nama'),
                array(
                    'db' => 'gol_akhir',
                    'dt' => 'gol_akhir',
                    'formatter' => function( $d ) {
                return convert_golongan($d);
            }
                ),
                array('db' => 'last_diklat', 'dt' => 'last_diklat'),
                array('db' => 'nama_jenis', 'dt' => 'nama_jenis'),
                array('db' => 'nama_diklat', 'dt' => 'nama_diklat'),
            );

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
        $data['header'] = 'Diklat';
        $data['tema'] = 'primary';
        $this->load->view('page/v-diklat', $data);
    }

    public function view() {
        $this->load->model('model_diklat');
        $data['header'] = 'SLKS';
        $data['tema'] = 'primary';
        $data['data_diklat'] = $this->model_diklat->view($this->uri->segment(3));
        $this->load->view('page/v-diklat_view', $data);
    }

    public function simpan() {
        $data = $this->input->post();
        $mode = $this->input->post('mode');
        unset($data['mode']);
        $this->load->model('model_diklat');
        if ($mode == 'edit') {
            $simpan = $this->model_diklat->simpan($data, $mode);
            echo $simpan;
        }
        if ($mode == 'tambah') {
            $simpan = $this->model_diklat->simpan($data, $mode);
            echo $simpan;
        }
    }

    public function select() {
        $this->load->model('model_diklat');
        $id = $this->uri->segment(4);
        $data['header'] = 'Tambah Data SLKS';
        $data['tema'] = 'primary';
        if ($id > 0) {
            $data['data'] = $this->model_diklat->select($id);
            $data['mode'] = 'edit';
        } else {
            $data['mode'] = 'tambah';
        }
        //print_r($data);
        $this->load->view('page/v-diklat_select', $data);
    }

    public function delete() {
        $this->load->model('model_diklat');
        $this->model_diklat->delete($this->input->post('id'));
    }

}
