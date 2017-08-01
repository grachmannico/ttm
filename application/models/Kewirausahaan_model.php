<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kewirausahaan_model extends CI_Model
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

    public function get_donatur($where = "")
    {
        $data = $this->db->query('select dr.email, dr.nama, count(dn.email) as total_donasi
            from donatur dr
            left join donasi dn
            on dr.email=dn.email '
            . $where .
            ' group by dr.email');
        return $data->result_array();
    }

    public function get_data_donatur($where = "")
    {
        $data = $this->db->query('select * from donatur ' . $where);
        return $data->result_array();
    }

    public function get_data_donasi_donatur($where = "")
    {
        $data = $this->db->query('select dr.email, dr.nama, k.nama_kegiatan, s.status_donasi, dn.nominal_donasi, dn.struk_donasi, dn.tanggal_donasi
            from donatur dr
            join donasi dn
            on dr.email=dn.email
            join kegiatan k
            on dn.id_kegiatan=k.id_kegiatan
            join status_donasi s
            on dn.id_status_donasi=s.id_status_donasi ' . $where);
        return $data->result_array();
    }

    public function get_jumlah_nominal_donasi_donatur($where = "")
    {
        $data = $this->db->query('select dr.email, sum(dn.nominal_donasi) as jumlah_nominal_donasi
            from donatur dr
            join donasi dn
            on dr.email=dn.email '
            . $where .
            ' group by dr.email');
        return $data->result_array();
    }

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

    public function get_barang($where = "")
    {
        $data = $this->db->query('select * from barang_garage_sale ' . $where);
        return $data->result_array();
    }

    public function get_data_pembelian_barang($where = "")
    {
        $data = $this->db->query('select b.id_barang_garage_sale, b.nama_barang, d.nama, k.qty, b.harga, s.status_pembelian, p.tanggal_pembelian
            from barang_garage_sale b
            join keranjang_belanja k
            on b.id_barang_garage_sale=k.id_barang_garage_sale
            join pembelian p
            on k.id_invoice=p.id_invoice
            join status_pembelian s
            on p.id_status_pembelian=s.id_status_pembelian
            join donatur d
            on p.email=d.email ' . $where);
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

    public function get_total_tagihan($where = "")
    {
        $data = $this->db->query('select sum(b.harga * kb.qty) as total_tagihan
            from keranjang_belanja kb
            join barang_garage_sale b
            on kb.id_barang_garage_sale=b.id_barang_garage_sale ' . $where);
        return $data->result_array();
    }

    public function get_kegiatan($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, k.nama_kegiatan, s.status_kegiatan, k.tanggal_kegiatan, k.alamat
            from kegiatan k
            join status_kegiatan s
            on k.id_status_kegiatan=s.id_status_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_laporan_pengeluaran($where = "")
    {
        $data = $this->db->query('select * from monitor_dana_kegiatan ' . $where);
        return $data->result_array();
    }

    public function get_total_donasi($where = "")
    {
        $data = $this->db->query('select coalesce(sum(nominal_donasi), 0) as total_dana
            from donasi ' . $where);
        return $data->result_array();
    }

    public function get_jml_dana_keluar($where = "")
    {
        $data = $this->db->query('select k.id_kegiatan, coalesce(sum(m.nominal_dana_keluar), 0) as jml_dana_keluar
            from monitor_dana_kegiatan m
            right join kegiatan k
            on m.id_kegiatan=k.id_kegiatan '
            . $where .
            ' group by k.id_kegiatan');
        return $data->result_array();
    }

    //FCM FUNCTION

    public function get_subs_all_user($where = "")
    {
        $data = $this->db->query("select r.email, r.fcm_token, k.id_kegiatan
            from relawan r
            join gabung_kegiatan g
            on r.email=g.email
            join kegiatan k
            on g.id_kegiatan=k.id_kegiatan
            where fcm_token != '' and " . $where . " 
            union all
            select d.email, d.fcm_token, k.id_kegiatan
            from donatur d
            join donasi dn
            on d.email=dn.email
            join kegiatan k
            on dn.id_kegiatan=k.id_kegiatan
            where fcm_token != '' and " . $where . " 
            group by k.id_kegiatan");
        return $data->result_array();
    }

    // public function get_exp_donation_user($where = "")
    // {
    //     $data = $this->db->query("select d.id_donasi, dn.email, dn.fcm_token
    //         from donasi d
    //         join kegiatan k
    //         on d.id_kegiatan=k.id_kegiatan
    //         join donatur dn
    //         on d.email=dn.email " . $where);
    //     return $data->result_array();
    // }
}
