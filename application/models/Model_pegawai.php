<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_pegawai extends CI_Model {

    function view($order = 'gol_akhir', $sort = 'desc') {
        $this->db->order_by($order, $sort);
        $this->db->order_by('nip', 'asc');
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
                return 2; //nip digunakan;
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

    function match_gol($nip) {
        $this->db->trans_begin();
        $this->db->select('max(b.gol) as maxi, min(b.gol) as mini, max(b.tmt_gol) as maxt, min(b.tmt_gol) as mint');
        $get = $this->db->get("(select * from pegawai_kp where nip='" . $nip . "') as b");
        //echo $this->db->last_query();

        if ($get->num_rows() > 0) {
            $result = $get->row();
            if ($result->mini == NULL || $result->mint == NULL) {
                $data['gol_awal'] = 11;
                $data['tmt_awal'] = date('Y-m-d');
            } else {
                $data['gol_awal'] = $result->mini;
                $data['tmt_awal'] = $result->mint;
            }

            if ($result->maxi == NULL || $result->maxt == NULL) {

                $data['gol_akhir'] = 11;
                $data['tmt_kp'] = date('Y-m-d');
            } else {

                $data['gol_akhir'] = $result->maxi;
                $data['tmt_kp'] = $result->maxt;
            }
            $this->db->where('nip', $nip);
            $query = $this->db->update('pegawai_pegawai', $data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            return 0;
        }
    }

}
