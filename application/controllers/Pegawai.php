<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class pegawai extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->load->helper(array('string', 'file'));
        if (!$this->ion_auth->logged_in()) {
            red('user/login');
        }
    }

    public function index() {
        $this->view();
    }

    public function view_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            //panggil library datatables
            $this->load->library('datatables_ssp');

            //atur nama tablenya disini
            $table = 'view_pegawai';

            // Table's primary key
            $primaryKey = 'nip';

            $bagian = array(
                '0' => '-',
                '1' => 'Tata Usaha',
                '2' => 'Inka',
                '3' => 'Bimtek',
                '4' => 'Pensiun',
                '5' => 'Mutasi',
            );

            $columns = array(
                array('db' => 'nip', 'dt' => 'nip'),
                array('db' => 'nama', 'dt' => 'nama'),
                array(
                    'db' => 'gol_akhir',
                    'dt' => 'gol',
                    'formatter' => function( $d ) {
                return convert_golongan($d);
            }),
                array('db' => 'alias_bag', 'dt' => 'bag'),
                array(
                    'db' => 'tkt_pendidikan',
                    'dt' => 'pddk',
                    'formatter' => function( $d ) {
                return convert_pendidikan($d);
            }),
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

    public function view() {
        $data['header'] = 'Pegawai';
        $data['tema'] = 'primary';
        $this->load->view('page/v-pegawai', $data);
    }

    public function hapus_foto() {
        $file = ('./downloads/foto/' . $this->input->post('file'));
        if (unlink($file)) {
            echo 'deleted successfully';
            log_event('hapus foto', 'lokasi=' . $file);
        } else {
            echo 'errors occured';
        }
    }

    public function upload_foto() {
        $nip = $this->uri->segment(3);
        $this->load->model('model_pegawai');
        $datapeg = $this->model_pegawai->select($nip);


        $path = 'downloads/foto';
        $file = $datapeg->nip . '_' . replace_filename($datapeg->nama) . '.jpg';
        $filepath = base_url($path) . '/' . $file;

        $is_file_exist = read_file($filepath);
        if (empty($this->input->post())) {
            $data['is_file_exist'] = $is_file_exist;
            $data['filepath'] = $filepath;
            $data['file'] = $file;
            $data['path'] = $path;
            $data['header'] = 'Pegawai';
            $data['tema'] = 'primary';
            $this->load->view('page/v-pegawai_upload', $data);
        } else {
            $config['upload_path'] = $path;
            $config['file_name'] = $file;
            $config['allowed_types'] = 'jpg';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';

            $this->load->library('upload', $config);
            $this->upload->overwrite = true;

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                echo $this->upload->display_errors();
                $this->load->view('upload_form', $error);
            } else {
                $data = array('upload_data' => $this->upload->data());
                echo ' {
                "id":"' . $nip . '"
            }';

                log_event('upload foto', 'nip=' . $nip);
            }
        }
    }

    public function select() {
        $this->load->model('model_pegawai');
        $datapeg = $this->model_pegawai->select($this->uri->segment(3));
        //////////////////////////////////KEPERLUAN LOAD FOTO - MULAI
        @$file = $datapeg->nip . '_' . replace_filename($datapeg->nama) . '.jpg';
        $path = 'downloads/foto';
        $filepath = base_url($path) . '/' . $file;
        $is_file_exist = read_file($filepath);

        $data['header'] = 'Pegawai';
        $data['tema'] = 'primary';
        $data['data_pegawai'] = $datapeg;
        $data['is_file_exist'] = $is_file_exist;

        $data['file'] = $file;
        $data['path'] = $path;
        $data['filepath'] = $filepath;
        //////////////////////////////////KEPERLUAN LOAD FOTO - SELESAI

        $data['data_kgb'] = $this->model_pegawai->next_kgb($this->uri->segment(3));

        $this->load->model('model_bagian');
        $data['data_bagian'] = $this->model_bagian->view();

        $this->load->model('model_agama');
        $data['data_agama'] = $this->model_agama->view();

        $this->load->model('model_golongan');
        $data['data_golongan'] = $this->model_golongan->view();
        $this->load->view('page/v-pegawai_select', $data);
    }

    public function delete() {
        $this->load->model('model_pegawai');
        $this->model_pegawai->delete($this->input->post('nip'));
    }

    public function simpan() {
        $data = $this->input->post();
        $mode = $this->input->post('mode');
        unset($data['mode']);
        $this->load->model('model_pegawai');

        $simpan = $this->model_pegawai->simpan($data, $mode);
        if ($simpan == 1) {
            echo $mode == 'tambah' ? 'Berhasil menambah pegawai' : 'Data pegawai berhasil diubah';
        }
    }

    public function is_nip_exist() {
        $nip = $this->input->post('nip');
        $this->load->model('model_pegawai');
        $check = $this->model_pegawai->is_nip_exist($this->input->post('nip'));
        echo $check;
    }

}
