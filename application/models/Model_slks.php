<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_slks extends CI_Model {

    function listing() {
        $get = $this->db->get('view_slks_listing');
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
        $get = $this->db->get('pegawai_slks');
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

    function select($id) {
        $this->db->where('id_slks', $id);
        $get = $this->db->get('pegawai_slks');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('id_slks', $id);
        $query = $this->db->delete('pegawai_slks');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus slks', 'id_slks=' . $id);
            return 1;
        } else {
            return 0;
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
            return true;
        } else {
            return false;
        }
    }

    function simpan($newdata, $mode) {
        $data = $newdata;
        if ($mode == 'tambah') {
            $query = $this->db->insert('pegawai_slks', $data);
            $id = $this->db->insert_id();
            //echo $this->db->last_query();
            if ($query) {
                log_event('input slks', 'nip=' . $data['nip'] . ' id_slks=' . $id);
                return $id;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $id = $data['id_slks'];
            unset($data['id_slks']);
            $this->db->where('id_slks', $id);
            $query = $this->db->update('pegawai_slks', $data);
            //echo $this->db->last_query();
            if ($query) {
                log_event('edit slks', 'nip=' . $data['nip'] . ' id_slks=' . $id);

                return $id;
            } else {
                return 0;
            }
        }
    }

}
