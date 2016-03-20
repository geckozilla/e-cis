<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_kp extends CI_Model {

    function view($nip) {
        $this->db->where('nip', $nip);
        $get = $this->db->get('view_kp_personal');
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

    function select($id_kp) {
        $this->db->where('id_kp', $id_kp);
        $get = $this->db->get('pegawai_kp');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('id_kp', $id);
        $query = $this->db->delete('pegawai_kp');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus kp', 'nip=' . $nip . ' id_kp=' . $id);
            return 1;
        } else {
            return 0;
        }
    }

    function select_gol() {
        $get = $this->db->get('pegawai_golongan');
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

    function select_kp_jenis() {
        $get = $this->db->get('pegawai_kp_jenis');
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

    function simpan($newdata, $mode) {
        $data = $newdata;
        if ($mode == 'tambah') {
            $query = $this->db->insert('pegawai_kp', $data);
            $id_kp = $this->db->insert_id();
            //echo $this->db->last_query();
            if ($query) {
                log_event('input kp', 'nip=' . $data['nip'] . ' id_kp=' . $id_kp);
                return $id_kp;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $id_kp = $data['id_kp'];
            unset($data['id_kp']);
            $this->db->where('id_kp', $id_kp);
            $query = $this->db->update('pegawai_kp', $data);
            //echo $this->db->last_query();
            if ($query) {
                log_event('edit kp', 'nip=' . $data['nip'] . ' id_kp=' . $id_kp);
                return $id_kp;
            } else {
                return 0;
            }
        }
    }

}
