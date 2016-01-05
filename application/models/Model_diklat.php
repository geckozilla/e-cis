<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_diklat extends CI_Model {

    function listing() {
        $get = $this->db->get('view_diklat_listing');
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
        $get = $this->db->get('view_diklat_personal');
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
        $this->db->where('id_diklat', $id);
        $get = $this->db->get('pegawai_diklat');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('id_diklat', $id);
        $query = $this->db->delete('pegawai_diklat');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus diklat', 'id_diklat=' . $id);
            return 1;
        } else {
            return 0;
        }
    }

    function simpan($newdata, $mode) {
        $data = $newdata;
        if ($mode == 'tambah') {
            $query = $this->db->insert('pegawai_diklat', $data);
            $id = $this->db->insert_id();
            //echo $this->db->last_query();
            if ($query) {
                log_event('input diklat', 'id_diklat=' . $id);
                return $id;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $id = $data['id_diklat'];
            unset($data['id_diklat']);
            $this->db->where('id_diklat', $id);
            $query = $this->db->update('pegawai_diklat', $data);
            //echo $this->db->last_query();
            if ($query) {
                log_event('edit diklat', 'id_diklat=' . $id);

                return $id;
            } else {
                return 0;
            }
        }
    }

}
