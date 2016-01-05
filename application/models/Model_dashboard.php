<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_dashboard extends CI_Model {

    function pegawai_aktif() {
        $get = $this->db->get('pegawai_pegawai');
        return $get->num_rows();
    }

    function log_timeline($limit = 20) {
        $this->db->limit($limit);
        $get = $this->db->get('view_dashboard_log');
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

    function persebaran_golongan() {
        $get = $this->db->get('view_dashboard_persebaran_golongan');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                if ($result->id_golongan > 20 and $result->id_golongan < 45) {
                    $data[] = $result;
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function persebaran_pendidikan() {
        $get = $this->db->get('view_dashboard_persebaran_pendidikan');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                if ($result->kode_tkt_pendidikan != 10 and $result->kode_tkt_pendidikan != 35 and $result->kode_tkt_pendidikan != 05 and $result->kode_tkt_pendidikan != 12 and $result->kode_tkt_pendidikan != 17 and $result->kode_tkt_pendidikan != 18) {
                    $data[] = $result;
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function persebaran_bagian() {
        $get = $this->db->get('view_dashboard_persebaran_bagian');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $result) {
                if ($result->kode_bagian != 00) {
                    $data[] = $result;
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function alert_kgb() {
        $this->db->where('sisa_bln_kgb <=', 2);
        $get = $this->db->get('view_kgb_listing');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $result[] = $data;
            }
            return $result;
        } else {
            return false;
        }
    }

    function pegawai_pria() {
        $this->db->select('count(*) as jumlah');
        $this->db->where('sex', 1);
        $get = $this->db->get('pegawai_pegawai');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $result = $get->row();
            return $result->jumlah;
        } else {
            return false;
        }
    }

    function pegawai_wanita() {
        $this->db->select('count(*) as jumlah');
        $this->db->where('sex', 2);
        $get = $this->db->get('pegawai_pegawai');
        //echo $this->db->last_query();
        if ($get->num_rows() > 0) {
            $result = $get->row();
            return $result->jumlah;
        } else {
            return false;
        }
    }

}
