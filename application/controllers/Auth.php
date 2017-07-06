<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function index()
    {
        if ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Relawan") {
            redirect("Relawan/");
        } elseif ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Penelitian Pengembangan dan Gerakan") {
            redirect("PPG/");
        } elseif ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Kewirausahaan") {
            redirect("Kewirausahaan/");
        } else {
            $this->load->view("v_login");
        }
    }

    public function login()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        if ($email != "" && $password != "") {
            $data_login = $this->Auth_model->get_relawan("where email = '$email'");
            if (empty($data_login)) {
                $pesan = "Login Gagal, Coba Lagi.";
                $this->load->view("v_login", array('pesan' => $pesan));
            } elseif (!empty($data_login)) {
                if ($password == $data_login[0]['pass']) {
                    if ($data_login[0]['pangkat_divisi'] == "Ketua Divisi" && $data_login[0]['divisi'] == "Relawan") {
                        $usersess = array(
                            'email'          => $data_login[0]['email'],
                            'nama'           => $data_login[0]['nama'],
                            'pangkat_divisi' => $data_login[0]['pangkat_divisi'],
                            'divisi'         => $data_login[0]['divisi'],
                        );
                        $this->session->set_userdata($usersess);
                        // $this->load->view("v_logout", array('pangkat_divisi' => $this->session->userdata('pangkat_divisi'), 'divisi' => $this->session->userdata('divisi')));
                        redirect("Relawan/");
                    } elseif ($data_login[0]['pangkat_divisi'] == "Ketua Divisi" && $data_login[0]['divisi'] == "Penelitian Pengembangan dan Gerakan") {
                        // echo "Penelitian Pengembangan dan Gerakan";
                        $usersess = array(
                            'email'          => $data_login[0]['email'],
                            'nama'           => $data_login[0]['nama'],
                            'pangkat_divisi' => $data_login[0]['pangkat_divisi'],
                            'divisi'         => $data_login[0]['divisi'],
                        );
                        $this->session->set_userdata($usersess);
                        // echo $this->session->userdata('pangkat_divisi');
                        // $this->load->view("v_logout", array('pangkat_divisi' => $this->session->userdata('pangkat_divisi'), 'divisi' => $this->session->userdata('divisi')));
                        redirect("PPG/");
                    } elseif ($data_login[0]['pangkat_divisi'] == "Ketua Divisi" && $data_login[0]['divisi'] == "Kewirausahaan") {
                        // echo "Kewirausahaan";
                        $usersess = array(
                            'email'          => $data_login[0]['email'],
                            'nama'           => $data_login[0]['nama'],
                            'pangkat_divisi' => $data_login[0]['pangkat_divisi'],
                            'divisi'         => $data_login[0]['divisi'],
                        );
                        $this->session->set_userdata($usersess);
                        // echo $this->session->userdata('pangkat_divisi');
                        // $this->load->view("v_logout", array('pangkat_divisi' => $this->session->userdata('pangkat_divisi'), 'divisi' => $this->session->userdata('divisi')));
                        redirect("Kewirausahaan/");
                    } else {
                        $pesan = "Login Gagal, Coba Lagi.";
                        $this->load->view("v_login", array('pesan' => $pesan));
                    }
                } else {
                    $pesan = "Login Gagal, Coba Lagi.";
                    $this->load->view("v_login", array('pesan' => $pesan));
                }
            }
        } else {
            $pesan = "Login Gagal, Coba Lagi.";
            $this->load->view("v_login", array('pesan' => $pesan));
        }
    }

    public function logout()
    {
        // $usersess = array(
        //     'email'          => '',
        //     'nama'           => '',
        //     'pangkat_divisi' => '',
        //     'divisi'         => '',
        // );
        // $this->session->unset_userdata($usersess);
        $this->session->sess_destroy();
        redirect("Auth/");
    }
}
