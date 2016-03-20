<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_profil extends CI_Model {

    function simpan($newdata) {
        $data = $newdata;
        $user_id = $data['user_id'];
        unset($data['user_id']);
        if ($data['user_pass'] == '') {
            unset($data['user_pass']);
        } else {
            $data['user_pass'] = password_hash($data['user_pass'], PASSWORD_BCRYPT);
        }

        $this->db->where('user_id', $user_id);
        $query = $this->db->update('pegawai_admin', $data);
        //echo $this->db->last_query() . '<br/>';
        if ($query) {
            log_event('update profil', '');
            return 1;
        } else {
            return 0;
        }
    }

    function select($user_id) {
        $this->db->where('user_id', $user_id);
        $get = $this->db->get('pegawai_admin');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return false;
        }
    }

}
