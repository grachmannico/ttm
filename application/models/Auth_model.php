<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    // public function insert_data($tableName, $data)
    // {
    //     $res = $this->db->insert($tableName, $data);
    //     return $res;
    // }

    // public function update_data($tableName, $data, $where)
    // {
    //     $res = $this->db->update($tableName, $data, $where);
    //     return $res;
    // }

    // public function delete_data($tableName, $where)
    // {
    //     $res = $this->db->delete($tableName, $where);
    //     return $res;
    // }

    public function get_relawan($where = "")
    {
        $data = $this->db->query('select r.email, r.nama, r.pass, dp.pangkat_divisi, d.divisi, r.foto_profil
            from relawan r
            join divisi d
            on r.id_divisi=d.id_divisi
            join pangkat_divisi dp
            on r.id_pangkat_divisi=dp.id_pangkat_divisi ' . $where);
        return $data->result_array();
    }
}
