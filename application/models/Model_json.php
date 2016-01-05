<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_json extends CI_Model {

    function pendidikan($like) {
        $this->db->select('*, CHAR_LENGTH(nama_dik) AS panjang');
        $this->db->like('nama_dik', $like);
        $this->db->not_like('nama_dik', 'delete');
        $this->db->order_by('panjang', 'asc');
        $this->db->order_by('kode_dik', 'asc');
        $this->db->limit(5);
        $get = $this->db->get('pegawai_pendidikan');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $coma = '';
            foreach ($get->result() as $result) {
                $return[] = $result;
            }
            $json = json_encode($return);
            print_r($json);
        } else {
            return false;
        }
    }

    function nip_nama($like) {
        $this->db->select('nip');
        $this->db->select('nama');
        $this->db->like('nip', $like);
        $this->db->or_like('nama', $like);
        $this->db->order_by('nama');
        //$this->db->limit(10);
        $get = $this->db->get('pegawai_pegawai');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $coma = '';
            //echo'[';
            foreach ($get->result() as $result) {
                $return[] = $result;
                //echo $coma . '{"nip":"' . $result->nip . '","name":"' . $result->nama . '"}';
                //$coma = ', ';
            }
            //echo"]}";
            $json = json_encode($return);
            print_r($json);
        } else {
            return false;
        }
    }

}
