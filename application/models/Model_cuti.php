<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_cuti extends CI_Model {

    function listing() {
        $get = $this->db->get('view_cuti_listing');
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

    function listing_last_year() {
        $get = $this->db->get('view_cuti_listing_last_year');
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
        $get = $this->db->get('view_cuti_personal');
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

    function select($id_cuti) {
        $this->db->where('id_cuti', $id_cuti);
        $get = $this->db->get('pegawai_cuti');
        echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function cek_periode() {
        $this->db->where('nama_pengaturan', 'cuti_periode');
        $get = $this->db->get('pegawai_pengaturan');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data->value_pengaturan == date('Y') ? 1 : 2; //1 jika periode sesuai; 2 jika tidak sesuai
        } else {
            return false;
        }
    }

    function simpan($newdata, $mode) {
        $data = $newdata;
        if ($data['jenis'] == 4 or $data['jenis'] == 5) {
            $data['kuantitas'] = abs($data['kuantitas']) * (-1);
        }
        $data['creator'] = get_user_id();
        if ($mode == 'tambah') {
            $data['tahun'] = date('Y');
            $query = $this->db->insert('pegawai_cuti', $data);
            $id_cuti = $this->db->insert_id();
            //echo $this->db->last_query();
            if ($query) {
                log_event('input cuti', 'nip=' . $data['nip'] . ' id_cuti=' . $id_cuti . ' kuantitas=' . $data['kuantitas'] . ' jenis=' . $data['jenis']);
                return $id_cuti;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $id_cuti = $data['id_cuti'];
            unset($data['id_cuti']);
            $this->db->where('id_cuti', $id_cuti);
            $query = $this->db->update('pegawai_cuti', $data);
            echo $this->db->last_query();
            if ($query) {
                log_event('edit cuti', 'nip=' . $data['nip'] . ' id_cuti=' . $id_cuti . ' kuantitas=' . $data['kuantitas'] . ' jenis=' . $data['jenis']);
                return $id_cuti;
            } else {
                return 0;
            }
        }
    }

    function delete($id) {
        $this->db->where('id_cuti', $id);
        $query = $this->db->delete('pegawai_cuti');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus cuti', 'id_cuti=' . $id);
            return 1;
        } else {
            return 0;
        }
    }

    function generate_new_periode($kuantitas) {

        $this->db->trans_start();
        $data = $this->generate_data_sisa_lalu();
        $query = $this->db->insert_batch('pegawai_cuti', $data);
        $data2 = $this->generate_data_hak_awal($kuantitas);
        $query2 = $this->db->insert_batch('pegawai_cuti', $data2);
        $this->db->where('nama_pengaturan', 'cuti_periode');
        $this->db->set('value_pengaturan', date('Y'));
        $query3 = $this->db->update('pegawai_pengaturan');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            $this->db->trans_complete();
            return 1;
            log_event('generate periode cuti');
        }
        //echo $this->db->last_query();
    }

    function generate_data_sisa_lalu() {
        $this->db->select('*,' . get_user_id() . ' as creator');
        $get = $this->db->get('view_cuti_generate_sisa_lalu');
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

    function generate_data_hak_awal($kuantitas) {
        $this->db->select('*,' . get_user_id() . ' as creator, ' . $kuantitas . ' as kuantitas');
        $get = $this->db->get('view_cuti_generate_hak_awal');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                $data[] = json_decode(json_encode($result), true);
            }
            return($data);
        } else {
            return false;
        }
    }

}
