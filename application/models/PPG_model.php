<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PPG_model extends CI_Model
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
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, s.status_kegiatan, k.id_status_kegiatan, k.tanggal_kegiatan, k.alamat
            from kegiatan k
            join status_kegiatan s
            on k.id_status_kegiatan=s.id_status_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_detail_kegiatan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.id_status_kegiatan, k.nama_kegiatan, k.pesan_ajakan, k.deskripsi_kegiatan, k.minimal_relawan, k.minimal_donasi, k.tanggal_kegiatan, k.batas_akhir_pendaftaran, k.alamat, k.lat, k.lng, k.banner, s.status_kegiatan
            from kegiatan k
            join status_kegiatan s
            on k.id_status_kegiatan=s.id_status_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_jumlah_relawan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, count(gk.id_gabung_kegiatan) as jumlah_relawan
            from gabung_kegiatan gk
            right join kegiatan k
            on gk.id_kegiatan=k.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_jumlah_donasi($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, coalesce(sum(d.nominal_donasi), 0) as jumlah_donasi
            from kegiatan k
            left join donasi d
            on k.id_kegiatan = d.id_kegiatan
            where d.id_status_donasi = 3 '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_dokumentasi_kegiatan($where = "")
    {
        $data = $this->db->query('select * from dokumentasi ' . $where);
        return $data->result_array();
    }

    public function get_data_feedback_kegiatan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, k.tanggal_kegiatan, coalesce(avg(r.rating), 0) as rating_relawan, coalesce(avg(d.rating), 0) as rating_donatur
            from kegiatan k
            left join feedback_kegiatan_relawan r
            on k.id_kegiatan=r.id_kegiatan
            left join feedback_kegiatan_donatur d
            on k.id_kegiatan=d.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_feedback_kegiatan_relawan($where = "")
    {
        $data = $this->db->query('select f.id_feedback_kegiatan, k.nama_kegiatan, r.email, r.nama, f.komentar, f.rating, f.tanggal
            from kegiatan k
            join feedback_kegiatan_relawan f
            on k.id_kegiatan=f.id_kegiatan
            join relawan r
            on f.email=r.email ' . $where);
        return $data->result_array();
    }

    public function get_feedback_kegiatan_donatur($where = "")
    {
        $data = $this->db->query('select f.id_feedback_kegiatan, k.nama_kegiatan, d.email, d.nama, f.komentar, f.rating, f.tanggal
            from kegiatan k
            join feedback_kegiatan_donatur f
            on k.id_kegiatan=f.id_kegiatan
            join donatur d
            on f.email=d.email ' . $where);
        return $data->result_array();
    }

    public function get_balasan_feedback_kegiatan_relawan($where = "")
    {
        $data = $this->db->query('select b.id_balas_feedback, b.email, r.nama, b.komentar, b.tanggal
            from balas_feedback_relawan b
            join relawan r
            on b.email=r.email '
            . $where .
            ' order by b.id_balas_feedback');
        return $data->result_array();
    }

    public function get_balasan_feedback_kegiatan_donatur($where = "")
    {
        $data = $this->db->query('select b.id_balas_feedback, b.email, d.nama, b.komentar, b.tanggal
            from balas_feedback_donatur b
            join donatur d
            on b.email=d.email '
            . $where .
            ' order by b.id_balas_feedback');
        return $data->result_array();
    }

    // public function get_all_user($where = "")
    // {
    //     $data = $this->db->query('select email, fcm_token
    //         from relawan
    //         union all
    //         select email, fcm_token
    //         from donatur ' . $where);
    //     return $data->result_array();
    // }

    //FCM FUNCTION

    public function get_all_user($where = "")
    {
        $data = $this->db->query("select email, fcm_token
            from relawan
            where fcm_token != ''
            union all
            select email, fcm_token
            from donatur d
            where fcm_token != ''");
        return $data->result_array();
    }

    public function get_subs_all_user($where = "")
    {
        $data = $this->db->query("select r.email, r.fcm_token, k.id_kegiatan
            from relawan r
            join gabung_kegiatan g
            on r.email=g.email
            join kegiatan k
            on g.id_kegiatan=k.id_kegiatan
            where fcm_token != '' and " . $where .
            " union all
            select d.email, d.fcm_token, k.id_kegiatan
            from donatur d
            join donasi dn
            on d.email=dn.email
            join kegiatan k
            on dn.id_kegiatan=k.id_kegiatan
            where fcm_token != '' and " . $where .
            " group by k.id_kegiatan");
        return $data->result_array();
    }

    //ON DELETE KEGIATAN & ARSIP
    public function get_cek_gabung_relawan($where = "")
    {
        $data = $this->db->query('select * from gabung_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_cek_donasi($where = "")
    {
        $data = $this->db->query('select * from donasi ' . $where);
        return $data->result_array();
    }

    public function get_cek_dokumentasi($where = "")
    {
        $data = $this->db->query('select * from dokumentasi ' . $where);
        return $data->result_array();
    }

    public function get_cek_feeback_relawan($where = "")
    {
        $data = $this->db->query('select * from feedback_kegiatan_relawan ' . $where);
        return $data->result_array();
    }

    public function get_cek_feeback_donatur($where = "")
    {
        $data = $this->db->query('select * from feedback_kegiatan_donatur ' . $where);
        return $data->result_array();
    }
}
