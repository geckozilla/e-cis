<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_agama extends CI_Model {

    function view() {
        $get = $this->db->get('pegawai_agama');
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

}
