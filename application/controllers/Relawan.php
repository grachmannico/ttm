<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Relawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Relawan") {
            $this->load->view('header');
            $this->load->view('relawan/sidebar-relawan');
        } else {
            redirect("Auth");
        }
    }

    public function index()
    {
        $this->load->view('relawan/dashboard_relawan');
        $this->load->view('footer');
    }

    public function mengelola_absensi()
    {
        $data_kegiatan = $this->Relawan_model->get_kegiatan("where id_status_kegiatan = 2");
        $this->load->view("relawan/v_mengelola_absensi", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function list_relawan()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($id_kegiatan != "") {
            $nama_kegiatan            = $this->Relawan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $list_relawan             = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan and s.id_status_absensi_relawan = 1");
            $list_relawan_hadir       = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan and s.id_status_absensi_relawan = 2");
            $list_relawan_tidak_hadir = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan and s.id_status_absensi_relawan = 3");
            $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'list_relawan_hadir' => $list_relawan_hadir, 'list_relawan_tidak_hadir' => $list_relawan_tidak_hadir, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Relawan/mengelola_absensi";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }

    public function absensi()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        $hadir       = $this->input->post("hadir");
        $tidak_hadir = $this->input->post("tidak_hadir");
        if ($hadir != "") {
            $update_status_kehadiran = array(
                'id_status_absensi_relawan' => 2,
            );
            $where   = array('id_gabung_kegiatan' => $hadir);
            $execute = $this->Relawan_model->update_data('gabung_kegiatan', $update_status_kehadiran, $where);
            if ($execute >= 1) {
                $list_relawan = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan");
                $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'id_kegiatan' => $id_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Gagal Melakukan Absensi. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_absensi";
                $name       = "";
                $value      = "";
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } elseif ($tidak_hadir != "") {
            $update_status_kehadiran = array(
                'id_status_absensi_relawan' => 3,
            );
            $where   = array('id_gabung_kegiatan' => $tidak_hadir);
            $execute = $this->Relawan_model->update_data('gabung_kegiatan', $update_status_kehadiran, $where);
            if ($execute >= 1) {
                $list_relawan = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan");
                $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'id_kegiatan' => $id_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Gagal Melakukan Absensi. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_absensi";
                $name       = "";
                $value      = "";
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Relawan/mengelola_absensi";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }

    public function mengelola_data_relawan()
    {
        $divisi = $this->input->post("divisi");
        if ($divisi != "") {
            $data_relawan = $this->Relawan_model->get_data_relawan("where r.id_divisi = $divisi");
            $this->load->view("relawan/v_mengelola_data_relawan", array('data_relawan' => $data_relawan));
            $this->load->view('footer');
        } elseif ($divisi == "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $data_relawan = $this->Relawan_model->get_data_relawan();
            $this->load->view("relawan/v_mengelola_data_relawan", array('data_relawan' => $data_relawan));
            $this->load->view('footer');
        }
    }

    public function tambah_relawan()
    {
        $email             = $this->input->post("email");
        $nama              = $this->input->post("nama");
        $pass              = $this->input->post("pass");
        $id_divisi         = $this->input->post("id_divisi");
        $id_pangkat_divisi = $this->input->post("id_pangkat_divisi");
        if ($email == "" && $nama == "" && $pass == "" && $id_divisi == "" && $id_pangkat_divisi == "") {
            $this->load->view("relawan/v_form_tambah_relawan");
            $this->load->view('footer');
        } else if ($email != "" && $nama != "" && $pass != "" && $id_divisi != "" && $id_pangkat_divisi != "") {
            $relawan_baru = array(
                'email'             => $email,
                'nama'              => $nama,
                'pass'              => $pass,
                'id_divisi'         => $id_divisi,
                'id_pangkat_divisi' => $id_pangkat_divisi,
            );
            $execute = $this->Relawan_model->insert_data('relawan', $relawan_baru);
            if ($execute >= 1) {
                $pesan  = "Sukses Menambah Relawan";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Relawan/mengelola_data_relawan");
            } else {
                $pesan      = "Gagal Menambah Data Relawan. Silahkan Cek Kembali.";
                $url_target = "PPG/tambah_relawan";
                $name       = "";
                $value      = "";
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } else {
            $pesan      = "Gagal Menambah Data Relawan. Isi Seluruh Form Yang Tersedia.";
            $url_target = "Relawan/tambah_relawan";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }

    public function edit_relawan()
    {
        $edit              = $this->input->post("edit");
        $email             = $this->input->post("email");
        $nama              = $this->input->post("nama");
        $pass              = $this->input->post("pass");
        $id_divisi         = $this->input->post("id_divisi");
        $id_pangkat_divisi = $this->input->post("id_pangkat_divisi");
        if ($edit != "") {
            $data_relawan = $this->Relawan_model->get_data_relawan("where email = '$edit'");
            $this->load->view("relawan/v_form_edit_relawan", array('data_relawan' => $data_relawan));
            $this->load->view('footer');
        } elseif ($edit == "" && $email != "" && $nama != "" && $pass != "" && $id_divisi != "" && $id_pangkat_divisi != "") {
            // echo $edit . "<br>";
            // echo $email . "<br>";
            // echo $nama . "<br>";
            // echo $pass . "<br>";
            // echo $id_divisi . "<br>";
            // echo $id_pangkat_divisi . "<br>";

            $update_data_relawan = array(
                'nama'              => $nama,
                'pass'              => $pass,
                'id_divisi'         => $id_divisi,
                'id_pangkat_divisi' => $id_pangkat_divisi,
            );
            $where   = array('email' => $email);
            $execute = $this->Relawan_model->update_data('relawan', $update_data_relawan, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Meng-edit Data Relawan $nama";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Relawan/mengelola_data_relawan");
            } else {
                $pesan      = "Gagal Meng-edit Data Relawan. Silahkan Cek Kembali.";
                $url_target = "PPG/edit_relawan";
                $name       = "edit";
                $value      = $email;
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Relawan/mengelola_data_relawan";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }

    public function hapus_relawan()
    {
        $hapus = $this->input->post("hapus");
        if ($hapus != "") {
            $where   = array('email' => $hapus);
            $execute = $this->Relawan_model->delete_data('relawan', $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Menghapus Data Relawan";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Relawan/mengelola_data_relawan");
            } else {
                $pesan      = "Gagal Hapus Relawan. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_data_relawan";
                $name       = "";
                $value      = "";
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Relawan/mengelola_data_relawan";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }

    public function detail_relawan()
    {
        $relawan = $this->input->post("relawan");
        if ($relawan != "") {
            $data_relawan = $this->Relawan_model->get_data_relawan("where email = '$relawan'");
            $total_gabung = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$relawan'");
            $detail_data  = $this->Relawan_model->get_detail_data_relawan("where r.email = '$relawan'");
            $this->load->view("relawan/v_detail_relawan", array('data_relawan' => $data_relawan, 'total_gabung' => $total_gabung, 'detail_data' => $detail_data));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Relawan/mengelola_data_relawan";
            $name       = "";
            $value      = "";
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        }
    }
}
