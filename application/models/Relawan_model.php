<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relawan_model extends CI_Model
{

    public function insert_data($tableName, $data)
    {
        $res = $this->db->insert($tableName, $data);
        return $res;
    }

    public function update_data($tableName, $data, $where)
    {
        $res = $this->db->update($tableName, $data, $where);
        return $res;
    }

    public function delete_data($tableName, $where)
    {
        $res = $this->db->delete($tableName, $where);
        return $res;
    }

    public function get_kegiatan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, count(gk.id_gabung_kegiatan) as jumlah_relawan
            from kegiatan k
            left join gabung_kegiatan gk
            on k.id_kegiatan=gk.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_list_relawan($where = "")
    {
        $data = $this->db->query('select gk.id_gabung_kegiatan, r.nama, d.divisi, s.status_absensi_relawan, k.nama_kegiatan
            from gabung_kegiatan gk
            join relawan r
            on gk.email=r.email
            join divisi d
            on r.id_divisi=d.id_divisi
            join status_absensi_relawan s
            on gk.id_status_absensi_relawan=s.id_status_absensi_relawan
            join kegiatan k
            on gk.id_kegiatan=k.id_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_data_relawan($where = "")
    {
        $data = $this->db->query('select r.email, r.nama, p.pangkat_divisi, d.divisi, r.pass, r.id_divisi, r.id_pangkat_divisi, r.foto_profil, r.no_hp, r.alamat, r.id_jenis_kelamin, r.tgl_lahir
            from relawan r
            join divisi d
            on r.id_divisi=d.id_divisi
            join pangkat_divisi p
            on r.id_pangkat_divisi=p.id_pangkat_divisi ' . $where);
        return $data->result_array();
    }

    public function get_total_gabung_kegiatan($where = "")
    {
        $data = $this->db->query('select count(gk.id_gabung_kegiatan) as jumlah_gabung_kegiatan
            from relawan r
            right join gabung_kegiatan gk
            on r.email=gk.email
            join kegiatan k
            on gk.id_kegiatan=k.id_kegiatan ' . $where );
        return $data->result_array();
    }

    public function get_detail_data_relawan($where = "")
    {
        $data = $this->db->query('select k.nama_kegiatan, sk.status_kegiatan, s.status_absensi_relawan
            from relawan r
            join gabung_kegiatan gk
            on r.email=gk.email
            join kegiatan k
            on gk.id_kegiatan=k.id_kegiatan
            join status_absensi_relawan s
            on gk.id_status_absensi_relawan=s.id_status_absensi_relawan
            join status_kegiatan sk
            on k.id_status_kegiatan=sk.id_status_kegiatan ' . $where);
        return $data->result_array();
    }

    //FCM FUNCTION
    public function get_user_attendance($where = "")
    {
        $data = $this->db->query('select gk.id_gabung_kegiatan, r.email, r.fcm_token, k.id_kegiatan
            from gabung_kegiatan gk
            join relawan r
            on gk.email=r.email
            join divisi d
            on r.id_divisi=d.id_divisi
            join status_absensi_relawan s
            on gk.id_status_absensi_relawan=s.id_status_absensi_relawan
            join kegiatan k
            on gk.id_kegiatan=k.id_kegiatan ' . $where);
        return $data->result_array();
    }

    //ON DELETE RELEAWAN
    public function get_cek_gabung_kegiatan($where = "")
    {
        $data = $this->db->query('select * from gabung_kegiatan ' . $where);
        return $data->result_array();
    }
}
