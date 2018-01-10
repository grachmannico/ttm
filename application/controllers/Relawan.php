<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Relawan extends CI_Controller
{
    private $status_relawan;
    private $kontribusi;
    private $status_kontribusi;
    private $jml_gabung;
    private $jml_absen_sukses;
    private $jml_semua_absen;
    private $jml_kegiatan;
    private $jml_blm_absen;
    private $persentase_gabung_kegiatan;
    private $sertifikat;
    private $rank;
    private $rank_result;

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
        $jml_relawan   = $this->Relawan_model->get_jml_relawan("where r.id_pangkat_divisi != 8 and r.id_pangkat_divisi != 6");
        $jml_absen     = $this->Relawan_model->get_jml_kegiatan("where k.id_status_kegiatan = 2");
        $jml_volunteer = $this->Relawan_model->get_jml_relawan("where r.id_pangkat_divisi != 8 and r.id_pangkat_divisi = 6");
        $this->load->view('relawan/dashboard_relawan', array('jml_relawan' => $jml_relawan, 'jml_absen' => $jml_absen, 'jml_volunteer' => $jml_volunteer));
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
        } elseif ($this->session->flashdata('id_kegiatan')) {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $id_kegiatan              = $this->session->flashdata('id_kegiatan');
            $nama_kegiatan            = $this->Relawan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan[id_kegiatan]");
            $list_relawan             = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan[id_kegiatan] and s.id_status_absensi_relawan = 1");
            $list_relawan_hadir       = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan[id_kegiatan] and s.id_status_absensi_relawan = 2");
            $list_relawan_tidak_hadir = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan[id_kegiatan] and s.id_status_absensi_relawan = 3");
            $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'list_relawan_hadir' => $list_relawan_hadir, 'list_relawan_tidak_hadir' => $list_relawan_tidak_hadir, 'id_kegiatan' => $id_kegiatan['id_kegiatan'], 'nama_kegiatan' => $nama_kegiatan));
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
                // $list_relawan = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan");
                // $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'id_kegiatan' => $id_kegiatan));
                // $this->load->view('footer');

                //Start FCM Code
                $get_id_kegiatan = $this->Relawan_model->get_kegiatan("where k.id_kegiatan = '$id_kegiatan'");
                $title           = "Absensi Kegiatan " . $get_id_kegiatan[0]['nama_kegiatan'];
                $body            = "Anda Dinyatakan Hadir Pada Kegiatan " . $get_id_kegiatan[0]['nama_kegiatan'];
                $message         = "null";
                $message_type    = "absensi";
                $intent          = "NotificationFragment";
                $id_target       = "null";
                $date_rcv        = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                $data        = $this->Relawan_model->get_user_attendance("where id_gabung_kegiatan = $hadir");
                print_r($data);

                $ids = array();
                $i   = 0;
                foreach ($data as $d) {
                    $ids[$i] = $d['fcm_token'];
                    $i++;
                }

                $headers = array('Authorization:key=' . $server_key, 'Content-Type:application/json');
                $fields  = array(
                    'registration_ids' => $ids,
                    'data'             => array(
                        'title'       => $title,
                        'body'        => $body,
                        'message'     => $message,
                        'messagetype' => $message_type,
                        'intent'      => $intent,
                        'idtarget'    => $id_target,
                        'datercv'     => $date_rcv,
                    ),
                );

                $payload      = json_encode($fields);
                $curl_session = curl_init();
                curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
                curl_setopt($curl_session, CURLOPT_POST, true);
                curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

                $result = curl_exec($curl_session);
                curl_close($curl_session);
                // echo "<hr>";
                // print_r($result);
                //End FCM Code

                $pesan  = "Sukses Melakukan Absensi dengan Status Hadir.";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                $id_kegiatan_flash = array('id_kegiatan' => $id_kegiatan);
                $this->session->set_flashdata('id_kegiatan', $id_kegiatan_flash);
                redirect("Relawan/list_relawan");
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
                // $list_relawan = $this->Relawan_model->get_list_relawan("where k.id_kegiatan = $id_kegiatan");
                // $this->load->view("relawan/v_list_relawan", array('list_relawan' => $list_relawan, 'id_kegiatan' => $id_kegiatan));
                // $this->load->view('footer');

                //Start FCM Code
                $get_id_kegiatan = $this->Relawan_model->get_kegiatan("where k.id_kegiatan = '$id_kegiatan'");
                $title           = "Absensi Kegiatan " . $get_id_kegiatan[0]['nama_kegiatan'];
                $body            = "Anda Dinyatakan Tidak Hadir Pada Kegiatan " . $get_id_kegiatan[0]['nama_kegiatan'];
                $message         = "null";
                $message_type    = "absensi";
                $intent          = "NotificationFragment";
                $id_target       = "null";
                $date_rcv        = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                $data        = $this->Relawan_model->get_user_attendance("where id_gabung_kegiatan = $tidak_hadir");
                print_r($data);

                $ids = array();
                $i   = 0;
                foreach ($data as $d) {
                    $ids[$i] = $d['fcm_token'];
                    $i++;
                }

                $headers = array('Authorization:key=' . $server_key, 'Content-Type:application/json');
                $fields  = array(
                    'registration_ids' => $ids,
                    'data'             => array(
                        'title'       => $title,
                        'body'        => $body,
                        'message'     => $message,
                        'messagetype' => $message_type,
                        'intent'      => $intent,
                        'idtarget'    => $id_target,
                        'datercv'     => $date_rcv,
                    ),
                );

                $payload      = json_encode($fields);
                $curl_session = curl_init();
                curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
                curl_setopt($curl_session, CURLOPT_POST, true);
                curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

                $result = curl_exec($curl_session);
                curl_close($curl_session);
                // echo "<hr>";
                // print_r($result);
                //End FCM Code

                $pesan  = "Sukses Melakukan Absensi dengan Status Tidak Hadir.";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                $id_kegiatan_flash = array('id_kegiatan' => $id_kegiatan);
                $this->session->set_flashdata('id_kegiatan', $id_kegiatan_flash);
                redirect("Relawan/list_relawan");
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
        $this->ranking_relawan();
        if ($divisi != "") {
            $data_relawan = $this->Relawan_model->get_data_relawan("where r.id_divisi = $divisi and r.id_pangkat_divisi != 8");
            $this->load->view("relawan/v_mengelola_data_relawan", array('data_relawan' => $data_relawan, 'rank' => $this->rank));
            $this->load->view('footer');
        } elseif ($divisi == "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $data_relawan = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi != 8");
            $this->load->view("relawan/v_mengelola_data_relawan", array('data_relawan' => $data_relawan, 'rank' => $this->rank));
            $this->load->view('footer');
        }
    }

    public function tambah_relawan()
    {
        $email             = $this->input->post("email");
        $nama              = $this->input->post("nama");
        $pass              = $this->input->post("pass");
        $tgl_lahir         = $this->input->post("tgl_lahir");
        $id_divisi         = $this->input->post("id_divisi");
        $id_pangkat_divisi = $this->input->post("id_pangkat_divisi");
        $no_hp             = str_replace(str_split('-.'), "", $this->input->post("no_hp"));
        $alamat            = $this->input->post("alamat");
        $jenis_kelamin     = $this->input->post("jenis_kelamin");
        if ($email == "" && $nama == "" && $pass == "" && $id_divisi == "" && $id_pangkat_divisi == "") {
            $this->load->view("relawan/v_form_tambah_relawan");
            $this->load->view('footer');
        } else if ($email != "" && $nama != "" && $pass != "" && $tgl_lahir != "" && $id_divisi != "" && $id_pangkat_divisi != "" && $no_hp != "" && $alamat != "" && $jenis_kelamin != "") {
            $relawan_baru = array(
                'email'             => $email,
                'nama'              => $nama,
                'pass'              => $pass,
                'tgl_lahir'         => $tgl_lahir,
                'id_divisi'         => $id_divisi,
                'id_pangkat_divisi' => $id_pangkat_divisi,
                'no_hp'             => $no_hp,
                'alamat'            => $alamat,
                'id_jenis_kelamin'  => $jenis_kelamin,
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
        $tgl_lahir         = $this->input->post("tgl_lahir");
        $id_divisi         = $this->input->post("id_divisi");
        $id_pangkat_divisi = $this->input->post("id_pangkat_divisi");
        $no_hp             = str_replace(str_split('-.'), "", $this->input->post("no_hp"));
        $alamat            = $this->input->post("alamat");
        $jenis_kelamin     = $this->input->post("jenis_kelamin");
        if ($edit != "") {
            $data_relawan = $this->Relawan_model->get_data_relawan("where email = '$edit'");
            $this->load->view("relawan/v_form_edit_relawan", array('data_relawan' => $data_relawan));
            $this->load->view('footer');
        } elseif ($edit == "" && $email != "" && $nama != "" && $pass != "" && $tgl_lahir != "" && $id_divisi != "" && $id_pangkat_divisi != "" && $no_hp != "" && $alamat != "" && $jenis_kelamin != "") {
            // echo $edit . "<br>";
            // echo $email . "<br>";
            // echo $nama . "<br>";
            // echo $pass . "<br>";
            // echo $id_divisi . "<br>";
            // echo $id_pangkat_divisi . "<br>";

            $update_data_relawan = array(
                'nama'              => $nama,
                'pass'              => $pass,
                'tgl_lahir'         => $tgl_lahir,
                'id_divisi'         => $id_divisi,
                'id_pangkat_divisi' => $id_pangkat_divisi,
                'no_hp'             => $no_hp,
                'alamat'            => $alamat,
                'id_jenis_kelamin'  => $jenis_kelamin,
            );
            $where   = array('email' => $email);
            $execute = $this->Relawan_model->update_data('relawan', $update_data_relawan, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Meng-edit Data Relawan";
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
            $cek_gabung_kegiatan = $this->Relawan_model->get_cek_gabung_kegiatan("where email = '$hapus'");
            if (empty($cek_gabung_kegiatan)) {
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
            } elseif (!empty($cek_gabung_kegiatan)) {
                $update_data_relawan = array(
                    'id_pangkat_divisi' => 8,
                );
                $where   = array('email' => $hapus);
                $execute = $this->Relawan_model->update_data('relawan', $update_data_relawan, $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menghapus Data Relawan (Data Relawan Dialihkan Ke Menu Arsip)";
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
            $data_relawan   = $this->Relawan_model->get_data_relawan("where email = '$relawan'");
            $total_gabung   = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$relawan' and gk.id_status_absensi_relawan = 2");
            $detail_data    = $this->Relawan_model->get_detail_data_relawan("where r.email = '$relawan'");
            $cek_sertifikat = $this->Relawan_model->get_sertifikat_relawan("where email = '$relawan' and tahun =" . date("Y"));
            $this->hasil_analisis_relawan($relawan);
            if ($this->jml_gabung > 0 && $this->jml_absen_sukses > 0 && $this->jml_semua_absen > 0) {
                $this->load->view("relawan/v_detail_relawan", array('data_relawan' => $data_relawan, 'total_gabung' => $total_gabung, 'detail_data' => $detail_data, 'status_relawan' => $this->status_relawan, 'kontribusi' => $this->kontribusi, 'status_kontribusi' => $this->status_kontribusi, 'jml_gabung' => $this->jml_gabung, 'jml_absen_sukses' => $this->jml_absen_sukses, 'jml_semua_absen' => $this->jml_semua_absen, 'persentase_gabung_kegiatan' => $this->persentase_gabung_kegiatan, 'jml_kegiatan' => $this->jml_kegiatan, 'jml_blm_absen' => $this->jml_blm_absen, 'sertifikat' => $this->sertifikat, 'cek_sertifikat' => $cek_sertifikat));
            } else {
                $this->load->view("relawan/v_detail_relawan", array('data_relawan' => $data_relawan, 'total_gabung' => $total_gabung, 'detail_data' => $detail_data));
            }
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

    // ARSIP
    public function mengelola_arsip_data_relawan()
    {
        $data_relawan = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi = 8");
        $this->load->view("relawan/v_mengelola_arsip_data_relawan", array('data_relawan' => $data_relawan));
        $this->load->view('footer');
    }

    public function restore_relawan()
    {
        $arsip            = $this->input->post("arsip");
        $cek_data_relawan = $this->Relawan_model->get_data_relawan("where r.email = '$email'");
        if ($arsip != "") {
            if ($cek_data_relawan[0]['id_divisi'] == 1) {
                $update_data_relawan = array(
                    'id_pangkat_divisi' => 6,
                );
            } else if ($cek_data_relawan[0]['id_divisi'] != 1) {
                $update_data_relawan = array(
                    'id_pangkat_divisi' => 7,
                );
            }
            $where   = array('email' => $arsip);
            $execute = $this->Relawan_model->update_data('relawan', $update_data_relawan, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Mengembalikan Data Relawan";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Relawan/mengelola_data_relawan");
            } else {
                $pesan      = "Gagal Mengembalikan Data Relawan. Silahkan Coba Kembali.";
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
            $url_target = "Relawan/mengelola_arsip_data_relawan";
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

    // Hitung-hitung
    public function hasil_analisis_relawan($email = "")
    {
        $periode = date("Y");

        $jumlah_gabung   = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$email'");
        $absen_sukses    = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$email' and id_status_absensi_relawan = 2");
        $semua_absen     = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$email' and id_status_absensi_relawan > 1");
        $jumlah_kegiatan = $this->Relawan_model->get_jml_kegiatan("where year(k.tanggal_kegiatan_mulai) = $periode and k.id_status_kegiatan != 0");
        $belum_absen     = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$email' and id_status_absensi_relawan = 1");

        $this->persentase_gabung_kegiatan = ($absen_sukses[0]['jumlah_gabung_kegiatan'] / $jumlah_kegiatan[0]['jml_kegiatan']) * 100;
        if ($this->persentase_gabung_kegiatan >= 50) {
            $this->status_relawan = "Relawan Tergolong Aktif.";
        } elseif ($this->persentase_gabung_kegiatan >= 30 && $this->persentase_gabung_kegiatan < 50) {
            $this->status_relawan = "Relawan Tergolong Cukup Aktif.";
        } elseif ($this->persentase_gabung_kegiatan < 30) {
            $this->status_relawan = "Relawan Tergolong Kurang Aktif.";
        }

        if ($semua_absen[0]['jumlah_gabung_kegiatan'] != 0) {
            if ($jumlah_gabung[0]['jumlah_gabung_kegiatan'] >= 3) {
                if ($absen_sukses[0]['jumlah_gabung_kegiatan'] >= 3) {
                    $this->sertifikat = "y";
                    $this->kontribusi = ($absen_sukses[0]['jumlah_gabung_kegiatan'] / $semua_absen[0]['jumlah_gabung_kegiatan']) * 100;
                    if ($this->kontribusi > 70) {
                        $this->status_kontribusi = "Tinggi";
                    } elseif ($this->kontribusi >= 50 && $this->kontribusi <= 70) {
                        $this->status_kontribusi = "Cukup Tinggi";
                    } elseif ($this->kontribusi < 50) {
                        $this->status_kontribusi = "Rendah";
                    }
                } else {
                    $this->sertifikat = "n";
                    $this->kontribusi = ($absen_sukses[0]['jumlah_gabung_kegiatan'] / $semua_absen[0]['jumlah_gabung_kegiatan']) * 100;
                    if ($this->kontribusi >= 50) {
                        $this->status_kontribusi = "Cukup Tinggi";
                    } elseif ($this->kontribusi < 50) {
                        $this->status_kontribusi = "Rendah";
                    }
                }
            } elseif ($jumlah_gabung[0]['jumlah_gabung_kegiatan'] > 0 && $jumlah_gabung[0]['jumlah_gabung_kegiatan'] < 3) {
                $this->sertifikat = "n";
                $this->kontribusi = ($absen_sukses[0]['jumlah_gabung_kegiatan'] / $semua_absen[0]['jumlah_gabung_kegiatan']) * 100;
                if ($this->kontribusi >= 50) {
                    $this->status_kontribusi = "Tinggi";
                } elseif ($this->kontribusi < 50) {
                    $this->status_kontribusi = "Cukup Tinggi";
                }
            } elseif ($jumlah_gabung[0]['jumlah_gabung_kegiatan'] == 0) {
                $this->sertifikat        = "n";
                $this->status_kontribusi = "Belum Teridentifikasi";
            }
        }

        $this->jml_gabung       = $jumlah_gabung[0]['jumlah_gabung_kegiatan'];
        $this->jml_absen_sukses = $absen_sukses[0]['jumlah_gabung_kegiatan'];
        $this->jml_semua_absen  = $semua_absen[0]['jumlah_gabung_kegiatan'];
        $this->jml_kegiatan     = $jumlah_kegiatan[0]['jml_kegiatan'];
        $this->jml_blm_absen    = $belum_absen[0]['jumlah_gabung_kegiatan'];

        // echo $this->status_relawan . "<br>";
        // echo $this->status_kontribusi . "<br>";
        // echo $this->kontribusi . "<br>";
        // echo $absen_sukses[0]['jumlah_gabung_kegiatan'] . "/" . $semua_absen[0]['jumlah_gabung_kegiatan'];
    }

    public function ranking_relawan()
    {
        $i          = 0;
        $this->rank = array();
        $relawan    = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi != 8 and r.id_pangkat_divisi != 6");
        foreach ($relawan as $r) {
            // $cek_gabung = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$r[email]' and id_status_absensi_relawan = 2");
            // $cek_absen  = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$r[email]' and id_status_absensi_relawan > 1");
            $cek_absen = $this->Relawan_model->get_total_gabung_kegiatan("where r.email = '$r[email]' and id_status_absensi_relawan = 2");
            // if ($cek_gabung[0]['jumlah_gabung_kegiatan'] >= 3 && $cek_absen[0]['jumlah_gabung_kegiatan'] >= 3) {
            $this->hasil_analisis_relawan($r['email']);
            $this->rank[$i]['email']                      = $r['email'];
            $this->rank[$i]['nama']                       = $r['nama'];
            $this->rank[$i]['jml_hadir']                  = $cek_absen[0]['jumlah_gabung_kegiatan'];
            $this->rank[$i]['persentase_gabung_kegiatan'] = $this->persentase_gabung_kegiatan;
            $this->rank[$i]['kontribusi']                 = $this->kontribusi;
            if ($cek_absen >= 3) {
                $this->rank[$i]['hasil'] = ($this->persentase_gabung_kegiatan + $this->kontribusi) / 2;
            } else {
                $this->rank[$i]['hasil'] = 0;
            }
            // }
            $i++;
        }
        $this->rank_result = array();
        foreach ($this->rank as $r) {
            $this->rank_result[] = $r['hasil'];
        }
        foreach ($this->rank as $r) {
            $rank_attendance[] = $r['jml_hadir'];
        }
        // array_multisort($rank_attendance, SORT_DESC, $this->rank_result, SORT_DESC, $this->rank);
        // array_multisort($this->rank_result, SORT_DESC, $this->rank);
        array_multisort($rank_attendance, SORT_DESC, $this->rank);
        // print_r($this->rank);
    }

    public function sertifikat_aktif_relawan()
    {
        $sertifikat = $this->input->post("sertifikat");
        if ($sertifikat != "") {
            $sertifikat_aktif_relawan = array(
                'email' => $sertifikat,
                'tahun' => date("Y"),
            );
            $execute = $this->Relawan_model->insert_data('sertifikat_relawan', $sertifikat_aktif_relawan);
            if ($execute >= 1) {
                $pesan  = "Sukses Menerbitkan Sertifikat Keaktifan Relawan Pada Periode " . date("Y");
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Relawan/mengelola_data_relawan");
            } else {
                $pesan      = "Gagal Menerbitkan Sertifikat Keaktifan Relawan. Silahkan Cek Kembali.";
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
            $url_target = "Relawan/mengelola_arsip_data_relawan";
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
