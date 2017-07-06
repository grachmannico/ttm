<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna_model extends CI_Model
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

    public function get_pengguna($where = "")
    {
        $data = $this->db->query('select p.email, p.nama, p.pass, tp.tipe_pengguna
                                from pengguna p
                                join tipe_pengguna tp
                                on p.id_tipe_pengguna = tp.id_tipe_pengguna ' . $where);
        return $data->result_array();
    }

    public function get_kegiatan($where = "")
    {
        $data = $this->db->query('select id_kegiatan, nama_kegiatan, pesan_ajakan, minimal_relawan, minimal_donasi, banner
                                from kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_detail_kegiatan($where = "")
    {
        $data = $this->db->query('select * from kegiatan k ' . $where);
        return $data->result_array();
    }

    public function get_jumlah_relawan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, count(r.id_relawan) as jumlah_relawan
                                from relawan r
                                right join kegiatan k
                                on r.id_kegiatan = k.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    public function get_jumlah_donasi($where)
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

    public function get_relawan($where)
    {
        $data = $this->db->query('select * from relawan ' . $where);
        return $data->result_array();
    }

    public function get_list_konfirmasi_donasi($where)
    {
        $data = $this->db->query('select d.id_donasi, k.nama_kegiatan, d.nominal_donasi, d.tanggal_donasi
                                from donasi d
                                join kegiatan k
                                on d.id_kegiatan=k.id_kegiatan
                                where d.id_status_donasi = 1 ' . $where);
        return $data->result_array();
    }

    public function get_subscribe_relawan($where)
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, k.banner, r.email
                                from kegiatan k
                                join relawan r
                                on k.id_kegiatan=r.id_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_subscribe_donatur($where)
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, k.banner, d.email
                                from kegiatan k
                                join donasi d
                                on k.id_kegiatan=d.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
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
        $data = $this->db->query('select kb.id_keranjang_belanja, b.id_barang_garage_sale, b.id_barang_garage_sale, b.nama_barang, b.harga, kb.qty
                                from keranjang_belanja kb
                                join barang_garage_sale b
                                on kb.id_barang_garage_sale=b.id_barang_garage_sale ' . $where);
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
        $data = $this->db->query('select * from pembelian ' . $where);
        return $data->result_array();
    }
}
