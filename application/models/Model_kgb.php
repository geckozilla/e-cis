<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_kgb extends CI_Model {

    function listing() {
        $get = $this->db->get('view_kgb_listing');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                $data[] = $result;
            }
            return $data;
        } else {
            return false;
        }
    }

    function view($nip) {
        $this->db->where('nip', $nip);
        $get = $this->db->get('pegawai_kgb');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                $data[] = $result;
            }
            return $data;
        } else {
            return false;
        }
    }

    function select($id_kgb) {
        $this->db->where('id_kgb', $id_kgb);
        $get = $this->db->get('pegawai_kgb');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('id_kgb', $id);
        $query = $this->db->delete('pegawai_kgb');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus kgb', 'nip=' . $nip . ' id_kgb=' . $id);
            return 1;
        } else {
            return 0;
        }
    }

    function view_setting() {
        $get = $this->db->get('view_kgb_pengaturan');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function setting_simpan($newdata) {
        $data = array();
        $n = 0;
        foreach ($newdata as $key => $val) {
            $data[$n]['nama_pengaturan'] = $key;
            $data[$n]['value_pengaturan'] = $val;
            $n++;
        }
        $query = $this->db->update_batch('pegawai_pengaturan', $data, 'nama_pengaturan');
        if ($query) {
            log_event('ubah pengaturan kgb');
            return true;
        } else {
            return false;
        }
        //echo $this->db->last_query();
        //print_r($data);
        //$this->db->update_batch('mytable', $data, 'title');
    }

    function select_kgb($id_kgb) {
        $this->db->where('id_kgb', $id_kgb);
        $get = $this->db->get('pegawai_kgb');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                $data[] = $result;
            }
            return $data;
        } else {
            return false;
        }
    }

    function data_awal($nip) { //digunakan untuk penarikan data-data awal default untuk pembuatan kgb
        $this->db->where('nip', $nip);
        $get = $this->db->get('view_kgb_new_data');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function simpan($newdata, $mode) {
        $data = $newdata;
        if ($mode == 'tambah') {
            $query = $this->db->insert('pegawai_kgb', $data);
            $id_kgb = $this->db->insert_id();
            //echo $this->db->last_query();
            if ($query) {
                log_event('input kgb', 'nip=' . $data['nip'] . ' id_kgb=' . $id_kgb);
                return $id_kgb;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $id_kgb = $data['id_kgb'];
            unset($data['id_kgb']);
            $this->db->where('id_kgb', $id_kgb);
            $query = $this->db->update('pegawai_kgb', $data);
            //echo $this->db->last_query();
            if ($query) {
                log_event('edit kgb', 'nip=' . $data['nip'] . ' id_kgb=' . $id_kgb);
                return $id_kgb;
            } else {
                return 0;
            }
        }
    }

    function create_no_sk_kgb($tgl_sk) {
        $this->db->like('nama_pengaturan', 'kgb_counter');
        $get = $this->db->get('pegawai_pengaturan');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                if ($data->nama_pengaturan == 'kgb_counter_for_year') {
                    if ($data->value_pengaturan != date('Y')) {//jika tahun ini tidak sama dengan for_year
                        $this->db->where('nama_pengaturan', 'kgb_counter');
                        $this->db->update('pegawai_pengaturan', array('value_pengaturan' => 0)); //reset count ke 0

                        $this->db->where('nama_pengaturan', 'kgb_counter_for_year');
                        $this->db->update('pegawai_pengaturan', array('value_pengaturan' => date('Y'))); //ubah for_year sama dengan tahun ini

                        $new_counter = true;
                    } else {
                        $new_counter = false;
                    }
                } elseif ($data->nama_pengaturan == 'kgb_counter') {
                    $counter = $data->value_pengaturan;
                }
            }
            $counter = $new_counter ? 0 : $counter; //cek apakah ada pengulangan counter karena tahun baru?
            $counter++;

            $this->db->where('nama_pengaturan', 'kgb_counter');
            $this->db->update('pegawai_pengaturan', array('value_pengaturan' => $counter)); //update counter


            $no_sk = str_pad($counter, 3, '0', STR_PAD_LEFT);
            //MENGHASILKAN BULAN ROMAWI
            $bulan = @romawi(sprintf('%02d', date('m', strtotime($tgl_sk))));


            //MENGHASILKAN TAHUN
            $tahun = date('Y', strtotime($tgl_sk));

            $result = $no_sk . "/PEG/KGB/KR.VIII/" . $bulan . "/" . $tahun;
            return $result;
        }
    }

}
