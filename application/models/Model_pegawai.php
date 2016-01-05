<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_pegawai extends CI_Model {

    function view() {
        $get = $this->db->get('view_pegawai');
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

    function select($nip) {
        $this->db->where('nip', $nip);
        $get = $this->db->get('view_pegawai');
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
        $data['tkt_pendidikan'] = detect_pendidikan($data['pendidikan']);
        $data['nama_jab'] = strtoupper($data['nama_jab']);
        $data['nama'] = strtoupper($data['nama']);
        $data['alamat'] = strtoupper($data['alamat']);
        $data['tpt_lahir'] = strtoupper($data['tpt_lahir']);
        if ($mode == 'tambah') {
            if ($this->is_nip_exist($data['nip'])) {
                $this->hapus($nip);
            }
            $query = $this->db->insert('pegawai_pegawai', $data);

            //echo $this->db->last_query() . '<br/>';
            if ($query) {
                log_event('tambah pegawai', 'nip=' . $data['nip']);
                return 1;
            } else {
                return 0;
            }
        } else if ($mode == 'edit') {
            $nip = $data['nip'];
            unset($data['nip']);
            $this->db->where('nip', $nip);
            $query = $this->db->update('pegawai_pegawai', $data);
            //echo $this->db->last_query() . '<br/>';
            if ($query) {
                log_event('edit pegawai', 'nip=' . $nip);
                return 1;
            } else {
                return 0;
            }
        }
    }

    function delete($nip) {
        //ambil data
        $this->db->where('nip', $nip);
        $data = $this->db->get('pegawai_pegawai');

        //duplikat ke pegawai_ deleted_pegawai
        $query = $this->db->insert('deleted_pegawai', $data->row());
        $this->db->where('nip', $nip);

        //hapus data dari pegawai_pegawai
        $query = $this->db->delete('pegawai_pegawai');
        //echo $this->db->last_query();
        if ($query) {
            log_event('hapus pegawai', 'nip=' . $nip);
            return 1;
        } else {
            return 0;
        }
    }

    function is_nip_exist($nip) {
        $this->db->where('nip', $nip);
        $get = $this->db->get('pegawai_pegawai');
        if ($get->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function next_kgb($nip) {
        $this->db->where('nip', $nip);
        $get = $this->db->get('view_kgb_listing');
        if ($get->num_rows() > 0) {
            $data = $get->row();
            return $data;
        } else {
            return 0;
        }
    }

}
