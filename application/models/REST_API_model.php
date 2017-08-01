<?php
defined('BASEPATH') or exit('No direct script access allowed');

class REST_API_model extends CI_Model
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

    public function get_relawan($where = "")
    {
        $data = $this->db->query('select r.email, r.nama, r.pass, dp.pangkat_divisi, d.divisi, r.fcm_token, r.foto_profil
            from relawan r
            join divisi d
            on r.id_divisi=d.id_divisi
            join pangkat_divisi dp
            on r.id_pangkat_divisi=dp.id_pangkat_divisi ' . $where);
        return $data->result_array();
    }

    public function get_donatur($where = "")
    {
        $data = $this->db->query('select * from donatur ' . $where);
        return $data->result_array();
    }

    public function get_kegiatan($where = "")
    {
        $data = $this->db->query('select id_kegiatan, nama_kegiatan, pesan_ajakan, lat, lng, banner
                                from kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_detail_kegiatan($where = "")
    {
        $data = $this->db->query('select k.*, s.status_kegiatan
            from kegiatan k
            join status_kegiatan s
            on k.id_status_kegiatan = s.id_status_kegiatan ' . $where);
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

    public function get_relawan_bergabung($where = "")
    {
        $data = $this->db->query('select * from gabung_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_list_konfirmasi_donasi($where = "")
    {
        $data = $this->db->query('select d.id_donasi, k.nama_kegiatan, d.nominal_donasi, d.tanggal_donasi
            from donasi d
            join kegiatan k
            on d.id_kegiatan=k.id_kegiatan
            where d.id_status_donasi = 1 ' . $where);
        return $data->result_array();
    }

    public function get_subscribe_relawan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, k.banner, gk.email, s.status_kegiatan
            from kegiatan k
            join gabung_kegiatan gk
            on k.id_kegiatan=gk.id_kegiatan
            join status_kegiatan s
            on k.id_status_kegiatan=s.id_status_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_subscribe_donatur($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, k.banner, d.email, s.status_kegiatan
            from kegiatan k
            join donasi d
            on k.id_kegiatan=d.id_kegiatan
            join status_kegiatan s
            on k.id_status_kegiatan=s.id_status_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_feedback_kegiatan_relawan($where = "")
    {
        $data = $this->db->query('select fk.id_feedback_kegiatan, r.nama, fk.komentar, fk.rating, count(b.id_feedback_kegiatan) as jml_balasan
            from feedback_kegiatan_relawan fk
            left join balas_feedback_relawan b
            on fk.id_feedback_kegiatan=b.id_feedback_kegiatan
            join relawan r
            on fk.email=r.email '
            . $where .
            ' group by fk.id_feedback_kegiatan');
        return $data->result_array();
    }

    public function get_feedback_kegiatan_donatur($where = "")
    {
        $data = $this->db->query('select fk.id_feedback_kegiatan, r.nama, fk.komentar, fk.rating, count(b.id_feedback_kegiatan) as jml_balasan
            from feedback_kegiatan_donatur fk
            left join balas_feedback_donatur b
            on fk.id_feedback_kegiatan=b.id_feedback_kegiatan
            join donatur r
            on fk.email=r.email '
            . $where .
            ' group by fk.id_feedback_kegiatan');
        return $data->result_array();
    }

    public function get_balasan_feedback_relawan($where = "")
    {
        $data = $this->db->query('select b.id_balas_feedback, b.email, b.id_feedback_kegiatan, b.komentar, r.nama
            from balas_feedback_relawan b
            join relawan r
            on b.email=r.email ' . $where);
        return $data->result_array();
    }

    public function get_balasan_feedback_donatur($where = "")
    {
        $data = $this->db->query('select b.id_balas_feedback, b.email, b.id_feedback_kegiatan, b.komentar, r.nama
            from balas_feedback_donatur b
            join donatur r
            on b.email=r.email ' . $where);
        return $data->result_array();
    }

    public function get_barang($where = "")
    {
        $data = $this->db->query('select id_barang_garage_sale, nama_barang, deskripsi, harga, stok_terpesan, gambar_barang
            from barang_garage_sale ' . $where);
        return $data->result_array();
    }

    public function get_keranjang_barang($where = "")
    {
        $data = $this->db->query('select kb.id_keranjang_belanja, b.id_barang_garage_sale, b.nama_barang, b.harga, b.gambar_barang, kb.qty, p.id_status_pembelian
            from keranjang_belanja kb
            join barang_garage_sale b
            on kb.id_barang_garage_sale=b.id_barang_garage_sale
            join pembelian p
            on kb.id_invoice=p.id_invoice ' . $where);
        return $data->result_array();
    }

    public function get_total_tagihan($where = "")
    {
        $data = $this->db->query('select sum(b.harga * kb.qty) as total_tagihan
            from keranjang_belanja kb
            join barang_garage_sale b
            on kb.id_barang_garage_sale=b.id_barang_garage_sale ' . $where);
        return $data->result_array();
    }

    public function get_list_pembelian($where = "")
    {
        $data = $this->db->query('select p.id_invoice, p.tanggal_pembelian, sum(b.harga * kb.qty) as total_tagihan
            from pembelian p
            join keranjang_belanja kb
            on p.id_invoice=kb.id_invoice
            join barang_garage_sale b
            on kb.id_barang_garage_sale=b.id_barang_garage_sale '
            . $where .
            ' group by p.id_invoice');
        return $data->result_array();
    }

    public function get_laporan_pengeluaran($where = "")
    {
        $data = $this->db->query('select m.*, k.nama_kegiatan
            from monitor_dana_kegiatan m
            join kegiatan k
            on m.id_kegiatan=k.id_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_dokumentasi($where = "")
    {
        $data = $this->db->query('select d.id_dokumentasi, d.id_kegiatan, d.nama_dokumentasi, d.gambar_dokumentasi, d.deskripsi, d.tanggal, k.nama_kegiatan
            from dokumentasi d
            join kegiatan k
            on d.id_kegiatan = k.id_kegiatan ' . $where);
        return $data->result_array();
    }

    //FCM FUNCTION

    public function get_transaksi_donasi($where = "")
    {
        $data = $this->db->query('select d.id_donasi, dn.nama, k.nama_kegiatan, d.nominal_donasi, d.tanggal_donasi, d.struk_donasi, dn.fcm_token
            from donasi d
            join kegiatan k
            on d.id_kegiatan=k.id_kegiatan
            join donatur dn
            on d.email=dn.email ' . $where);
        return $data->result_array();
    }

    public function get_invoice($where = "")
    {
        $data = $this->db->query('select p.id_invoice, d.nama, d.email, p.tanggal_pembelian, p.struk_pembelian, d.fcm_token
            from pembelian p
            join donatur d
            on p.email=d.email ' . $where);
        return $data->result_array();
    }
}
