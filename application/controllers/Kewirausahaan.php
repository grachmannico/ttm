<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kewirausahaan extends CI_Controller
{
    private $status_donatur;
    private $persentase_transfer_valid;
    private $persentase_transfer_per_kegiatan;
    private $rata_rata_donasi;
    private $persentase_hasil;
    private $hasil;
    private $jumlah_transfer_valid;
    private $jumlah_transfer;
    private $jumlah_kegiatan;
    private $rank;
    private $rank_result;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Kewirausahaan") {
            $this->exp_donasi();
            $this->exp_pembelian();
            $this->ranking_donatur();
            $this->load->view('header');
            $this->load->view('kewirausahaan/sidebar-kewirausahaan');
        } else {
            redirect("Auth");
        }
    }

    public function index()
    {
        $jumlah_donatur         = $this->Kewirausahaan_model->get_jml_donatur("where d.email != 'admin@ttm.com'");
        $jumlah_donasi_masuk    = $this->Kewirausahaan_model->get_jml_konfirmasi_donasi("and dn.id_status_donasi = 2");
        $jumlah_pembayaran      = $this->Kewirausahaan_model->get_jml_konfirmasi_pembayaran("where p.id_status_pembelian = 2");
        $transaksi_donasi_masuk = $this->Kewirausahaan_model->get_transaksi_donasi("where id_status_donasi = 2 order by tanggal_donasi asc"); //where id_status_donasi = 2
        $this->load->view("kewirausahaan/dashboard_kewirausahaan", array('jumlah_donatur' => $jumlah_donatur, 'jumlah_donasi_masuk' => $jumlah_donasi_masuk, 'jumlah_pembayaran' => $jumlah_pembayaran, 'transaksi_donasi_masuk' => $transaksi_donasi_masuk));
        $this->load->view('footer');
    }

    public function mengelola_donatur()
    {
        $this->ranking_donatur();
        if ($this->session->flashdata('success_msg')) {
            $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
        }
        $donatur = $this->Kewirausahaan_model->get_donatur("and dn.id_status_donasi = 3 where not dr.email = 'admin@ttm.com'");
        $this->load->view("kewirausahaan/v_mengelola_donatur", array('donatur' => $donatur, 'rank' => $this->rank));
        $this->load->view('footer');
    }

    public function edit_donatur()
    {
        $edit          = $this->input->post("edit");
        $email         = $this->input->post("email");
        $nama          = $this->input->post("nama");
        $pass          = $this->input->post("pass");
        $tgl_lahir     = $this->input->post("tgl_lahir");
        $no_hp         = str_replace(str_split('-.'), "", $this->input->post("no_hp"));
        $alamat        = $this->input->post("alamat");
        $jenis_kelamin = $this->input->post("jenis_kelamin");
        if ($edit != "") {
            $data_donatur = $this->Kewirausahaan_model->get_data_donatur("where email = '$edit'");
            $this->load->view("kewirausahaan/v_form_edit_donatur", array('data_donatur' => $data_donatur));
            $this->load->view('footer');
        } elseif ($email != "" && $nama != "" && $pass != "" && $tgl_lahir != "" && $no_hp != "" && $alamat != "" && $jenis_kelamin != "") {
            $update_data_donatur = array(
                'nama'             => $nama,
                'pass'             => $pass,
                'tgl_lahir'        => $tgl_lahir,
                'no_hp'            => $no_hp,
                'alamat'           => $alamat,
                'id_jenis_kelamin' => $jenis_kelamin,
            );
            $where   = array('email' => $email);
            $execute = $this->Kewirausahaan_model->update_data('donatur', $update_data_donatur, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Meng-edit Data Donatur";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/mengelola_donatur");
            } else {
                $pesan      = "Gagal Meng-edit Data Donatur. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/edit_kegiatan";
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
            $url_target = "Kewirausahaan/mengelola_donatur";
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

    public function detail_donatur()
    {
        $id_status_donasi = $this->input->post("id_status_donasi");
        $donatur          = $this->input->post("donatur");
        if ($id_status_donasi == "" && $donatur != "") {
            $profil_donatur                     = $this->Kewirausahaan_model->get_data_donatur("where email = '$donatur'");
            $data_donatur                       = $this->Kewirausahaan_model->get_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
            $data_donasi_donatur                = $this->Kewirausahaan_model->get_data_donasi_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
            $data_jumlah_nominal_donasi_donatur = $this->Kewirausahaan_model->get_jumlah_nominal_donasi_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
            if (empty($data_donatur[0]['total_donasi'])) {
                $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur));
            } elseif (!empty($data_donatur[0]['total_donasi'])) {
                $this->hasil_analisis_donatur($donatur);
                $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur, 'status_donatur' => $this->status_donatur, 'persentase_hasil' => $this->persentase_hasil, 'hasil' => $this->hasil, 'persentase_transfer_valid' => $this->persentase_transfer_valid, 'jumlah_transfer_valid' => $this->jumlah_transfer_valid, 'jumlah_transfer' => $this->jumlah_transfer, 'persentase_transfer_per_kegiatan' => $this->persentase_transfer_per_kegiatan, 'jumlah_kegiatan' => $this->jumlah_kegiatan, 'rata_rata_donasi' => $this->rata_rata_donasi));
            }
            $this->load->view('footer');
        } else if ($id_status_donasi != "" && $donatur != "") {
            if ($id_status_donasi == 0) {
                $profil_donatur                     = $this->Kewirausahaan_model->get_data_donatur("where email = '$donatur'");
                $data_donatur                       = $this->Kewirausahaan_model->get_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
                $data_donasi_donatur                = $this->Kewirausahaan_model->get_data_donasi_donatur("where dr.email = '$donatur'");
                $data_jumlah_nominal_donasi_donatur = $this->Kewirausahaan_model->get_jumlah_nominal_donasi_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
                // $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur));
                if (empty($data_donatur[0]['total_donasi'])) {
                    $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur));
                } elseif (!empty($data_donatur[0]['total_donasi'])) {
                    $this->hasil_analisis_donatur($donatur);
                    $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur, 'status_donatur' => $this->status_donatur, 'persentase_hasil' => $this->persentase_hasil, 'hasil' => $this->hasil, 'persentase_transfer_valid' => $this->persentase_transfer_valid, 'jumlah_transfer_valid' => $this->jumlah_transfer_valid, 'jumlah_transfer' => $this->jumlah_transfer, 'persentase_transfer_per_kegiatan' => $this->persentase_transfer_per_kegiatan, 'jumlah_kegiatan' => $this->jumlah_kegiatan, 'rata_rata_donasi' => $this->rata_rata_donasi));
                }
                $this->load->view('footer');
            } elseif ($id_status_donasi > 0) {
                $profil_donatur                     = $this->Kewirausahaan_model->get_data_donatur("where email = '$donatur'");
                $data_donatur                       = $this->Kewirausahaan_model->get_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
                $data_donasi_donatur                = $this->Kewirausahaan_model->get_data_donasi_donatur("where dr.email = '$donatur' and dn.id_status_donasi = $id_status_donasi");
                $data_jumlah_nominal_donasi_donatur = $this->Kewirausahaan_model->get_jumlah_nominal_donasi_donatur("where dr.email = '$donatur' and dn.id_status_donasi = 3");
                // $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur));
                if (empty($data_donatur[0]['total_donasi'])) {
                    $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur));
                } elseif (!empty($data_donatur[0]['total_donasi'])) {
                    $this->hasil_analisis_donatur($donatur);
                    $this->load->view("kewirausahaan/v_detail_donatur", array('profil_donatur' => $profil_donatur, 'data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur, 'data_jumlah_nominal_donasi_donatur' => $data_jumlah_nominal_donasi_donatur, 'status_donatur' => $this->status_donatur, 'persentase_hasil' => $this->persentase_hasil, 'hasil' => $this->hasil, 'persentase_transfer_valid' => $this->persentase_transfer_valid, 'jumlah_transfer_valid' => $this->jumlah_transfer_valid, 'jumlah_transfer' => $this->jumlah_transfer, 'persentase_transfer_per_kegiatan' => $this->persentase_transfer_per_kegiatan, 'jumlah_kegiatan' => $this->jumlah_kegiatan, 'rata_rata_donasi' => $this->rata_rata_donasi));
                }
                $this->load->view('footer');
            }
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/";
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

    public function mengelola_donasi()
    {
        if ($this->session->flashdata('success_msg')) {
            $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
        }
        $transaksi_donasi_akan_masuk = $this->Kewirausahaan_model->get_transaksi_donasi("where id_status_donasi = 1");
        $transaksi_donasi_masuk      = $this->Kewirausahaan_model->get_transaksi_donasi("where id_status_donasi = 2");
        $this->load->view("kewirausahaan/v_mengelola_donasi", array('transaksi_donasi_akan_masuk' => $transaksi_donasi_akan_masuk, 'transaksi_donasi_masuk' => $transaksi_donasi_masuk));
        $this->load->view('footer');
    }

    public function validasi_donasi()
    {
        $id_donasi    = $this->input->post("id_donasi");
        $status_valid = $this->input->post("status");
        if ($id_donasi != "" && $status_valid == "valid") {
            $validasi_donasi = array(
                'id_status_donasi' => 3,
            );
            $where   = array('id_donasi' => $id_donasi);
            $execute = $this->Kewirausahaan_model->update_data('donasi', $validasi_donasi, $where);
            if ($execute >= 1) {
                //Start FCM Code
                $title        = "Donasi Anda Tervalidasi";
                $body         = "Terima Kasih Telah Melakukan Donasi. Kami Akan Melaporkan Segala Jenis Pengeluaran Dana Dalam Kegiatan.";
                $message      = "null";
                $message_type = "konfirmasi donasi";
                $intent       = "NotificationFragment";
                $id_target    = "null";
                $date_rcv     = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                $data = $this->Kewirausahaan_model->get_transaksi_donasi("where id_donasi = '$id_donasi'");
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
                echo "<hr>";
                print_r($result);
                //End FCM Code

                $pesan  = "Sukses Melakukan Validasi Donasi";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/mengelola_donasi");
            } else {
                $pesan      = "Gagal Melakukan Validasi Donasi. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/mengelola_donasi";
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
        } elseif ($id_donasi != "" && $status_valid == "tidak valid") {
            $validasi_donasi = array(
                'id_status_donasi' => 5,
            );
            $where   = array('id_donasi' => $id_donasi);
            $execute = $this->Kewirausahaan_model->update_data('donasi', $validasi_donasi, $where);
            if ($execute >= 1) {
                //Start FCM Code
                $title        = "Donasi Anda Dibatalkan";
                $body         = "Donasi Dibatalkan Karena Struk Transfer Tidak Valid.";
                $message      = "null";
                $message_type = "konfirmasi donasi";
                $intent       = "NotificationFragment";
                $id_target    = "null";
                $date_rcv     = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                $data = $this->Kewirausahaan_model->get_transaksi_donasi("where id_donasi = '$id_donasi'");
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
                echo "<hr>";
                print_r($result);
                //End FCM Code

                $pesan  = "Sukses Membatalkan Donasi Karena Struk Transfer Tidak Valid";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/mengelola_donasi");
            } else {
                $pesan      = "Gagal Melakukan Validasi Donasi. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/mengelola_donasi";
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
            $url_target = "Kewirausahaan/";
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

    public function mengelola_garage_sale()
    {
        if ($this->session->flashdata('success_msg')) {
            $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
        }
        $barang = $this->Kewirausahaan_model->get_barang("where id_status_barang = 1");
        $this->load->view("kewirausahaan/v_mengelola_garage_sale", array('barang' => $barang));
        $this->load->view('footer');
    }

    public function tambah_barang_garage_sale()
    {
        $nama_barang    = $this->input->post("nama_barang");
        $deskripsi      = $this->input->post("deskripsi");
        $harga          = str_replace(str_split('_.'), "", $this->input->post("harga"));
        $stok_available = $this->input->post("stok_available");
        if ($nama_barang == "" && $deskripsi == "" && $harga == "" && $stok_available == "") {
            $this->load->view("kewirausahaan/v_form_tambah_barang_garage_sale");
            $this->load->view('footer');
        } elseif ($nama_barang != "" && $deskripsi != "" && $harga != "" && $stok_available != "") {
            $config['upload_path']   = './uploads/barang_garage_sale/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar_barang')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $tambah_barang = array(
                    'nama_barang'      => $nama_barang,
                    'deskripsi'        => $deskripsi,
                    'harga'            => $harga,
                    'stok_available'   => $stok_available,
                    'stok_terpesan'    => $stok_available,
                    'id_status_barang' => 1,
                );
                $execute = $this->Kewirausahaan_model->insert_data('barang_garage_sale', $tambah_barang);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menambah Data Barang Garage Sale";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Menambah Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/tambah_barang_garage_sale";
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
                $data          = array('upload_data' => $this->upload->data());
                $tambah_barang = array(
                    'nama_barang'      => $nama_barang,
                    'deskripsi'        => $deskripsi,
                    'harga'            => $harga,
                    'stok_available'   => $stok_available,
                    'stok_terpesan'    => $stok_available,
                    'gambar_barang'    => $this->upload->data('file_name'),
                    'id_status_barang' => 1,
                );
                $execute = $this->Kewirausahaan_model->insert_data('barang_garage_sale', $tambah_barang);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menambah Data Barang Garage Sale";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Menambah Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/tambah_barang_garage_sale";
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
            $pesan      = "Gagal Menambah Data Barang Garage Sale. Isi Seluruh Form Yang Tersedia.";
            $url_target = "Kewirausahaan/tambah_barang_garage_sale";
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

    public function edit_barang_garage_sale()
    {
        $edit                  = $this->input->post("edit");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        $nama_barang           = $this->input->post("nama_barang");
        $deskripsi             = $this->input->post("deskripsi");
        $harga                 = str_replace(str_split('_.'), "", $this->input->post("harga"));
        $stok_available        = $this->input->post("stok_available");
        if ($edit != "") {
            $barang = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $edit");
            $this->load->view("kewirausahaan/v_form_edit_barang_garage_sale", array('barang' => $barang));
            $this->load->view('footer');
        } elseif ($id_barang_garage_sale != "" && $nama_barang != "" && $deskripsi != "" && $harga != "" && $stok_available != "") {
            $config['upload_path']   = './uploads/barang_garage_sale/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar_barang')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $stok_lama = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                if ($stok_available == $stok_lama[0]['stok_available']) {
                    $stok_terpesan = $stok_lama[0]['stok_terpesan'];
                } elseif ($stok_available > $stok_lama[0]['stok_available']) {
                    $stok_terpesan = ($stok_available - $stok_lama[0]['stok_available']) + $stok_lama[0]['stok_terpesan'];
                } elseif ($stok_available < $stok_lama[0]['stok_available']) {
                    $stok_terpesan = $stok_lama[0]['stok_terpesan'];
                }
                $update_barang = array(
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                    'stok_terpesan'  => $stok_terpesan,
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_barang, $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Meng-edit Data Barang Garage Sale";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Meng-edit Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/edit_barang_garage_sale";
                    $name       = "edit";
                    $value      = $id_barang_garage_sale;
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
                $data      = array('upload_data' => $this->upload->data());
                $stok_lama = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                if ($stok_available == $stok_lama[0]['stok_available']) {
                    $stok_terpesan = $stok_lama[0]['stok_terpesan'];
                } elseif ($stok_available > $stok_lama[0]['stok_available']) {
                    $stok_terpesan = ($stok_available - $stok_lama[0]['stok_available']) + $stok_lama[0]['stok_terpesan'];
                } elseif ($stok_available < $stok_lama[0]['stok_available']) {
                    $stok_terpesan = $stok_lama[0]['stok_terpesan'];
                }
                $update_barang = array(
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                    'stok_terpesan'  => $stok_terpesan,
                    'gambar_barang'  => $this->upload->data('file_name'),
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_barang, $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Meng-edit Data Barang Garage Sale $nama_barang";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Meng-edit Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/edit_barang_garage_sale";
                    $name       = "edit";
                    $value      = $id_barang_garage_sale;
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
            $url_target = "Kewirausahaan/mengelola_garage_sale";
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

    public function hapus_barang_garage_sale()
    {
        $hapus = $this->input->post("hapus");
        if ($hapus != "") {
            $cek_data_barang = $this->Kewirausahaan_model->get_data_pembelian_barang("where b.id_barang_garage_sale = $hapus");
            if (empty($cek_data_barang)) {
                $where   = array('id_barang_garage_sale' => $hapus);
                $execute = $this->Kewirausahaan_model->delete_data('barang_garage_sale', $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menghapus Data Barang Garage Sale";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Menghapus Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/mengelola_garage_sale";
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
            } elseif (!empty($cek_data_barang)) {
                $update_barang = array(
                    'id_status_barang' => 2,
                );
                $where   = array('id_barang_garage_sale' => $hapus);
                $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_barang, $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menghapus Data Barang Garage Sale";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    $pesan      = "Gagal Menghapus Data Barang Garage Sale. Silahkan Cek Kembali.";
                    $url_target = "Kewirausahaan/mengelola_garage_sale";
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
            $url_target = "Kewirausahaan/mengelola_garage_sale";
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

    public function detail_barang_garage_sale()
    {
        $barang = $this->input->post("barang");
        if ($barang != "") {
            $detail_barang  = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $barang");
            $data_pembelian = $this->Kewirausahaan_model->get_data_pembelian_barang("where b.id_barang_garage_sale = $barang and p.id_status_pembelian = 3");
            $this->load->view("kewirausahaan/v_detail_barang_garage_sale", array('detail_barang' => $detail_barang, 'data_pembelian' => $data_pembelian));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/mengelola_garage_sale";
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

    public function validasi_pembelian()
    {
        $validasi     = $this->input->post("validasi");
        $status_valid = $this->input->post("status");
        if ($validasi == "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $invoice = $this->Kewirausahaan_model->get_invoice("where id_status_pembelian = 2");
            $this->load->view("kewirausahaan/v_validasi_pembelian", array('invoice' => $invoice));
            $this->load->view('footer');
        } elseif ($validasi != "" && $status_valid == "valid") {
            $validasi_pembelian = array(
                'id_status_pembelian' => 3,
            );
            $where   = array('id_invoice' => $validasi);
            $execute = $this->Kewirausahaan_model->update_data('pembelian', $validasi_pembelian, $where);
            if ($execute >= 1) {
                $pembelian = $this->Kewirausahaan_model->get_data_pembelian_barang("where p.id_invoice = '$validasi'");
                foreach ($pembelian as $p) {
                    $barang                = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $p[id_barang_garage_sale]");
                    $qty_sebelum           = $barang[0]['stok_available'];
                    $update_stok_available = array(
                        'stok_available' => $qty_sebelum - $p['qty'],
                    );
                    $where   = array('id_barang_garage_sale' => $p['id_barang_garage_sale']);
                    $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_stok_available, $where);
                }

                //Start FCM Code
                $title        = "Pembelian Barang Garage Tervalidasi";
                $body         = "Pembelian Dengan Invoice '$validasi' Tervalidasi. Barang Akan Segera Dikirim.";
                $message      = "null";
                $message_type = "konfirmasi pembayaran";
                $intent       = "NotificationFragment";
                $id_target    = "null";
                $date_rcv     = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                $data = $this->Kewirausahaan_model->get_invoice("where id_invoice = '$validasi'");
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
                echo "<hr>";
                print_r($result);
                //End FCM Code

                $pesan  = "Sukses Memvalidasi Pembelian Barang Garage Sale";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/validasi_pembelian");
            } else {
                $pesan      = "Gagal Memvalidasi Transaksi Pembelian. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/validasi_pembelian";
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
        } elseif ($validasi != "" && $status_valid == "tidak valid") {
            $validasi_pembelian = array(
                'id_status_pembelian' => 6,
            );
            $where   = array('id_invoice' => $validasi);
            $execute = $this->Kewirausahaan_model->update_data('pembelian', $validasi_pembelian, $where);
            if ($execute >= 1) {
                $pembelian = $this->Kewirausahaan_model->get_data_pembelian_barang("where p.id_invoice = '$validasi'");
                foreach ($pembelian as $p) {
                    $barang               = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $p[id_barang_garage_sale]");
                    $qty_sebelum          = $barang[0]['stok_terpesan'];
                    $update_stok_terpesan = array(
                        'stok_terpesan' => $qty_sebelum + $p['qty'],
                    );
                    $where   = array('id_barang_garage_sale' => $p['id_barang_garage_sale']);
                    $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                }

                //Start FCM Code
                $title        = "Pembelian Barang Garage Dibatalkan";
                $body         = "Pembelian Dengan Invoice '$validasi' Dibatalkan Karena Struk Transfer Tidak Valid.";
                $message      = "null";
                $message_type = "konfirmasi pembayaran";
                $intent       = "NotificationFragment";
                $id_target    = "null";
                $date_rcv     = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                $data = $this->Kewirausahaan_model->get_invoice("where id_invoice = '$validasi'");
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
                echo "<hr>";
                print_r($result);
                //End FCM Code

                $pesan  = "Sukses Membatalkan Pembelian Barang Garage Sale Karena Struk Transfer Tidak Valid";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/validasi_pembelian");
            } else {
                $pesan      = "Gagal Memvalidasi Transaksi Pembelian. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/validasi_pembelian";
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

    public function detail_pembelian()
    {
        $detail = $this->input->post("detail");
        if ($detail != "") {
            $invoice   = $this->Kewirausahaan_model->get_invoice("where id_status_pembelian = 2 and p.id_invoice = '$detail'");
            $pembelian = $this->Kewirausahaan_model->get_data_pembelian_barang("where p.id_invoice = '$detail'");
            $tagihan   = $this->Kewirausahaan_model->get_total_tagihan("where kb.id_invoice = '$detail'");
            $this->load->view("kewirausahaan/v_detail_pembelian", array('invoice' => $invoice, 'pembelian' => $pembelian, 'tagihan' => $tagihan));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/mengelola_garage_sale";
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

    public function mengelola_lpj()
    {
        $data_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_status_kegiatan != 0");
        $this->load->view("kewirausahaan/v_mengelola_lpj", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function kelola_laporan()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($id_kegiatan != "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $nama_kegiatan   = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $dana_masuk      = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
            $total_dana      = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
            $dana_keluar     = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
            $jml_dana_keluar = $this->Kewirausahaan_model->get_jml_dana_keluar("where k.id_kegiatan = $id_kegiatan");
            $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'jml_dana_keluar' => $jml_dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
            $this->load->view('footer');
        } elseif ($this->session->flashdata('id_kegiatan')) {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $id_kegiatan     = $this->session->flashdata('id_kegiatan');
            $nama_kegiatan   = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $dana_masuk      = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
            $total_dana      = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
            $dana_keluar     = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
            $jml_dana_keluar = $this->Kewirausahaan_model->get_jml_dana_keluar("where k.id_kegiatan = $id_kegiatan");
            $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'jml_dana_keluar' => $jml_dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/mengelola_lpj";
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

    public function tambah_data_pengeluaran()
    {
        $id_kegiatan         = $this->input->post("id_kegiatan");
        $nama_dana_keluar    = $this->input->post("nama_dana_keluar");
        $tanggal             = $this->input->post("tanggal");
        $nominal_dana_keluar = str_replace(str_split('_.'), "", $this->input->post("nominal_dana_keluar"));
        $keterangan          = $this->input->post("keterangan");
        // echo $id_kegiatan."<br>";
        // echo $nama_dana_keluar."<br>";
        // echo $tanggal."<br>";
        // echo $nominal_dana_keluar."<br>";
        // echo $keterangan."<br>";
        if ($id_kegiatan != "" && $nama_dana_keluar != "" && $tanggal != "" && $nominal_dana_keluar != "" && $keterangan != "") {
            $tambah_data = array(
                'id_kegiatan'         => $id_kegiatan,
                'nama_dana_keluar'    => $nama_dana_keluar,
                'tanggal'             => $tanggal,
                'nominal_dana_keluar' => $nominal_dana_keluar,
                'keterangan'          => $keterangan,
            );
            $execute = $this->PPG_model->insert_data('monitor_dana_kegiatan', $tambah_data);
            if ($execute >= 1) {
                //Start FCM Code
                $get_id_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where id_kegiatan = '$id_kegiatan'");
                $title           = "Pengeluaran Dana " . $nama_dana_keluar;
                $body            = "Pengeluaran Dana Pada Kegiatan $get_kegiatan[0][nama_kegiatan]";
                $message         = "null";
                $message_type    = "monitor dana";
                // $intent          = "DetailKegiatanDiikutiActivity";
                $intent    = "MonitorDanaActivity";
                $id_target = $get_id_kegiatan[0]['id_kegiatan'];
                $date_rcv  = date("Y-m-d");

                $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                $data        = $this->Kewirausahaan_model->get_subs_donatur("k.id_kegiatan = $id_kegiatan");
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

                $pesan            = "Sukses Menambah Data Pengeluaran Dana";
                $sukses           = array('pesan' => $pesan);
                $pass_id_kegiatan = $id_kegiatan;
                $this->session->set_flashdata('success_msg', $sukses);
                $this->session->set_flashdata('id_kegiatan', $pass_id_kegiatan);
                redirect("Kewirausahaan/kelola_laporan");
                // $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
                // $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
                // $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
                // $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
                // $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
                // $this->load->view('footer');
            } else {
                $pesan      = "Gagal Menambah Data Pengeluaran. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/kelola_laporan";
                $name       = "id_kegiatan";
                $value      = $id_kegiatan;
                $alert      = array(
                    'pesan'      => $pesan,
                    'url_target' => $url_target,
                    'name'       => $name,
                    'value'      => $value,
                );
                $this->load->view("alert", array('alert' => $alert));
                $this->load->view("footer");
            }
        } elseif ($id_kegiatan != "" && $nama_dana_keluar == "" && $tanggal == "" && $nominal_dana_keluar == "" && $keterangan == "") {
            $pesan      = "Gagal Menambah Data Pengeluaran. Isi Seluruh Form Yang Tersedia.";
            $url_target = "Kewirausahaan/kelola_laporan";
            $name       = "id_kegiatan";
            $value      = $id_kegiatan;
            $alert      = array(
                'pesan'      => $pesan,
                'url_target' => $url_target,
                'name'       => $name,
                'value'      => $value,
            );
            $this->load->view("alert", array('alert' => $alert));
            $this->load->view("footer");
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/mengelola_lpj";
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

    public function edit_data_pengeluaran()
    {
        $edit                     = $this->input->post("edit");
        $id_kegiatan              = $this->input->post("id_kegiatan");
        $nama_dana_keluar         = $this->input->post("nama_dana_keluar");
        $tanggal                  = $this->input->post("tanggal");
        $nominal_dana_keluar      = str_replace(str_split('_.'), "", $this->input->post("nominal_dana_keluar"));
        $keterangan               = $this->input->post("keterangan");
        $id_monitor_dana_kegiatan = $this->input->post("id_monitor_dana_kegiatan");
        if ($edit != "") {
            $data_dana_keluar = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_monitor_dana_kegiatan = $edit");
            $this->load->view("kewirausahaan/v_form_edit_data_pengeluaran", array('data_dana_keluar' => $data_dana_keluar, 'id_kegiatan' => $id_kegiatan));
            $this->load->view('footer');
        } elseif ($id_kegiatan != "" && $nama_dana_keluar != "" && $tanggal != "" && $nominal_dana_keluar != "" && $keterangan != "" && $id_monitor_dana_kegiatan != "") {
            $update_data = array(
                'nama_dana_keluar'    => $nama_dana_keluar,
                'tanggal'             => $tanggal,
                'nominal_dana_keluar' => $nominal_dana_keluar,
                'keterangan'          => $keterangan,
            );
            $where   = array('id_monitor_dana_kegiatan' => $id_monitor_dana_kegiatan);
            $execute = $this->Kewirausahaan_model->update_data('monitor_dana_kegiatan', $update_data, $where);
            if ($execute >= 1) {
                $pesan            = "Sukses Meng-edit Data Pengeluaran Dana";
                $sukses           = array('pesan' => $pesan);
                $pass_id_kegiatan = $id_kegiatan;
                $this->session->set_flashdata('success_msg', $sukses);
                $this->session->set_flashdata('id_kegiatan', $pass_id_kegiatan);
                redirect("Kewirausahaan/kelola_laporan");
                // $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
                // $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
                // $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
                // $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
                // $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
                // $this->load->view('footer');
            } else {
                $pesan      = "Gagal Meng-edit Data Pengeluaran. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/kelola_laporan";
                $name       = "edit";
                $value      = $id_monitor_dana_kegiatan;
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
            $url_target = "Kewirausahaan/mengelola_lpj";
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

    public function hapus_data_pengeluaran()
    {
        $hapus = $this->input->post("hapus");
        if ($hapus != "") {
            $id_kegiatan = $this->input->post("id_kegiatan");
            $where       = array('id_monitor_dana_kegiatan' => $hapus);
            $execute     = $this->PPG_model->delete_data('monitor_dana_kegiatan', $where);
            if ($execute >= 1) {
                $pesan            = "Sukses Menghapus Data Pengeluaran Dana";
                $sukses           = array('pesan' => $pesan);
                $pass_id_kegiatan = $id_kegiatan;
                $this->session->set_flashdata('success_msg', $sukses);
                $this->session->set_flashdata('id_kegiatan', $pass_id_kegiatan);
                redirect("Kewirausahaan/kelola_laporan");
                // $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
                // $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
                // $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
                // $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
                // $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
                // $this->load->view('footer');
            } else {
                $pesan      = "Gagal Menghapus Data Pengeluaran. Silahkan Cek Kembali.";
                $url_target = "Kewirausahaan/kelola_laporan";
                $name       = "id_kegiatan";
                $value      = $id_kegiatan;
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
            $url_target = "Kewirausahaan/mengelola_lpj";
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

    public function exp_donasi()
    {
        $today      = date('Y-m-d');
        $donasi_exp = $this->Kewirausahaan_model->get_transaksi_donasi("where d.id_status_donasi = 1");
        foreach ($donasi_exp as $d) {
            $payday   = date('Y-m-d', strtotime($d['tanggal_donasi']));
            $exp_date = date('Y-m-d', strtotime($payday . ' + 2 days'));
            if (($today >= $payday) && ($today <= $exp_date)) {
                // echo $d['tanggal_donasi'] . " OKE<br>";
            } else {
                // echo $d['tanggal_donasi']." EXP<br>";
                $update_status_donasi = array(
                    'id_status_donasi' => 4,
                );
                $where   = array('id_donasi' => $d['id_donasi']);
                $execute = $this->Kewirausahaan_model->update_data('donasi', $update_status_donasi, $where);
                if ($execute >= 1) {
                    // ok, fcm start here
                    //Start FCM Code
                    $title        = "Donasi Anda Dibatalkan";
                    $body         = "Donasi Pada Kegiatan $d[nama_kegiatan] Telah Melewati Batas Waktu";
                    $message      = "null";
                    $message_type = "konfirmasi donasi";
                    $intent       = "NotificationFragment";
                    $id_target    = "null";
                    $date_rcv     = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                    $ids    = array();
                    $ids[0] = $d['fcm_token'];

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
                } else {
                    // database error
                }
            }
        }
    }

    public function exp_pembelian()
    {
        $today         = date('Y-m-d');
        $pembelian_exp = $this->Kewirausahaan_model->get_invoice("where p.id_status_pembelian = 1");
        foreach ($pembelian_exp as $d) {
            $payday   = date('Y-m-d', strtotime($d['tanggal_pembelian']));
            $exp_date = date('Y-m-d', strtotime($payday . ' + 2 days'));
            if (($today >= $payday) && ($today <= $exp_date)) {
                // OK
            } else {
                // T E R C Y D U Q
                $update_status_pembelian = array(
                    'id_status_pembelian' => 4,
                );
                $where   = array('id_invoice' => $d['id_invoice']);
                $execute = $this->Kewirausahaan_model->update_data('pembelian', $update_status_pembelian, $where);
                if ($execute >= 1) {
                    // ok, fcm start here
                    //Start FCM Code
                    $title        = "Pembelian Barang Garage Sale Anda Dibatalkan";
                    $body         = "Konfirmasi Pembelian Telah Melewati Batas Waktu. Invoice: $d[id_invoice]";
                    $message      = "null";
                    $message_type = "konfirmasi pembayaran";
                    $intent       = "NotificationFragment";
                    $id_target    = "null";
                    $date_rcv     = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

                    $ids    = array();
                    $ids[0] = $d['fcm_token'];

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
                } else {
                    // database error
                }
            }
        }
    }

    // ARSIP
    public function mengelola_arsip_garage_sale()
    {
        $barang = $this->Kewirausahaan_model->get_barang("where id_status_barang = 2");
        $this->load->view("kewirausahaan/v_mengelola_arsip_garage_sale", array('barang' => $barang));
        $this->load->view('footer');
    }

    public function restore_barang_garage_sale()
    {
        $arsip = $this->input->post("arsip");
        if ($arsip != "") {
            $update_data = array(
                'id_status_barang' => 1,
            );
            $where   = array('id_barang_garage_sale' => $arsip);
            $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_data, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Mengembalikan Data Barang Garage Sale";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("Kewirausahaan/mengelola_garage_sale");
            } else {
                $pesan      = "Gagal Mengembalikan Data Barang Garage Sale. Silahkan Coba Kembali.";
                $url_target = "Kewirausahaan/edit_kegiatan";
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
            $url_target = "Kewirausahaan/mengelola_arsip_garage_sale";
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

    public function mengelola_arsip_lpj()
    {
        $data_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_status_kegiatan = 0");
        $this->load->view("kewirausahaan/v_mengelola_arsip_lpj", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function lihat_arsip_lpj()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($id_kegiatan != "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $nama_kegiatan   = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $dana_masuk      = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
            $total_dana      = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
            $dana_keluar     = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
            $jml_dana_keluar = $this->Kewirausahaan_model->get_jml_dana_keluar("where k.id_kegiatan = $id_kegiatan");
            $this->load->view("kewirausahaan/v_detail_arsip_lpj", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'jml_dana_keluar' => $jml_dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "Kewirausahaan/mengelola_lpj";
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
    public function hasil_analisis_donatur($email = "")
    {
        $point = 0;

        $jml_nominal_donasi              = $this->Kewirausahaan_model->get_jumlah_nominal_donasi_donatur("where dr.email = '$email' and dn.id_status_donasi = 3");
        $jml_transaksi_donasi            = $this->Kewirausahaan_model->get_donatur("where dr.email = '$email' and dn.id_status_donasi > 2");
        $jml_transaksi_donasi_valid      = $this->Kewirausahaan_model->get_donatur("where dr.email = '$email' and dn.id_status_donasi = 3");
        $jml_kegiatan                    = $this->Kewirausahaan_model->get_jml_kegiatan();
        $this->persentase_transfer_valid = ($jml_transaksi_donasi_valid[0]['total_donasi'] / $jml_transaksi_donasi[0]['total_donasi']) * 100;
        if ($this->persentase_transfer_valid >= 80) {
            $point = $point + 3;
        } elseif ($this->persentase_transfer_valid >= 50 && $this->persentase_transfer_valid < 80) {
            $point = $point + 2;
        } elseif ($this->persentase_transfer_valid < 50) {
            $point = $point + 1;
        }

        $this->persentase_transfer_per_kegiatan = ($jml_transaksi_donasi_valid[0]['total_donasi'] / $jml_kegiatan[0]['jml_kegiatan']) * 100;
        if ($this->persentase_transfer_per_kegiatan >= 50) {
            $point = $point + 3;
        } elseif ($this->persentase_transfer_per_kegiatan >= 20 && $this->persentase_transfer_per_kegiatan < 50) {
            $point = $point + 2;
        } elseif ($this->persentase_transfer_per_kegiatan < 20) {
            $point = $point + 1;
        }

        $this->hasil = $point / 2;
        if ($this->hasil > 2.5) {
            $this->status_donatur = "Donatur Aktif";
        } elseif ($this->hasil > 2.0 && $this->hasil <= 2.5) {
            $this->status_donatur = "Donatur Potensial";
        } elseif ($this->hasil <= 2.0) {
            $this->status_donatur = "Donatur";
        }

        $this->persentase_hasil = ($this->hasil / 3) * 100;

        $this->rata_rata_donasi = $jml_nominal_donasi[0]['jumlah_nominal_donasi'] / $jml_transaksi_donasi_valid[0]['total_donasi'];

        $this->jumlah_transfer_valid = $jml_transaksi_donasi_valid[0]['total_donasi'];
        $this->jumlah_transfer       = $jml_transaksi_donasi[0]['total_donasi'];
        $this->jumlah_kegiatan       = $jml_kegiatan[0]['jml_kegiatan'];

        // echo "jml_nominal_donasi: " . $jml_nominal_donasi[0]['jumlah_nominal_donasi'] . "<br>";
        // echo "jml_transaksi_donasi: " . $jml_transaksi_donasi[0]['total_donasi'] . "<br>";
        // echo "jml_transaksi_donasi_valid: " . $jml_transaksi_donasi_valid[0]['total_donasi'] . "<br>";
        // echo "jml_kegiatan: " . $jml_kegiatan[0]['jml_kegiatan'];
        // echo "<hr>";
        // echo "jml_nominal_donasi: " . $jml_nominal_donasi[0]['jumlah_nominal_donasi'] . "<br>";
        // echo "persentase_transfer_valid: " . $this->persentase_transfer_valid . "<br>";
        // echo "persentase_transfer_per_kegiatan: " . $this->persentase_transfer_per_kegiatan . "<br>";
        // echo "rata_rata_donasi: " . $this->rata_rata_donasi . "<br>";
        // echo "status_donatur: " . $this->status_donatur . "<br>";
        // echo "hasil: " . $hasil;
    }

    public function ranking_donatur()
    {
        $i          = 0;
        $this->rank = array();
        $send_msg   = array();
        $donatur    = $this->Kewirausahaan_model->get_donatur("and dn.id_status_donasi = 3 where not dr.email = 'admin@ttm.com'");

        foreach ($donatur as $d) {
            $jml_nominal_donasi         = $this->Kewirausahaan_model->get_jumlah_nominal_donasi_donatur("where dr.email = '$d[email]' and dn.id_status_donasi = 3");
            $jml_transaksi_donasi       = $this->Kewirausahaan_model->get_donatur("where dr.email = '$d[email]' and dn.id_status_donasi > 2");
            $jml_transaksi_donasi_valid = $this->Kewirausahaan_model->get_donatur("where dr.email = '$d[email]' and dn.id_status_donasi = 3");
            $jml_kegiatan               = $this->Kewirausahaan_model->get_jml_kegiatan();
            $cek_status_donatur         = $this->Kewirausahaan_model->get_data_donatur("where email = '$d[email]'");

            // $nilai = ($this->persentase_transfer_valid + $this->persentase_transfer_per_kegiatan) / 2;

            if (!empty($jml_nominal_donasi) && !empty($jml_transaksi_donasi) && !empty($jml_transaksi_donasi_valid) && !empty($jml_kegiatan)) {
                // $this->rank[$i]['persentase_hasil'] = $this->persentase_hasil;
                $this->hasil_analisis_donatur($d['email']);
                $this->rank[$i]['email']            = $d['email'];
                $this->rank[$i]['nama']             = $d['nama'];
                $this->rank[$i]['persentase_hasil'] = ($this->persentase_transfer_valid + $this->persentase_transfer_per_kegiatan) / 2;
                if ($this->status_donatur == "Donatur Potensial" && $cek_status_donatur[0]['id_status_donatur'] > 1 && $cek_status_donatur[0]['id_status_donatur'] != 2) {
                    $send_msg[$i]['fcm_token'] = $d['fcm_token'];
                    $update_data               = array(
                        'id_status_donatur' => 2,
                    );
                    $where   = array('email' => $d['email']);
                    $execute = $this->Kewirausahaan_model->update_data('donatur', $update_data, $where);
                    if ($execute >= 1) {
                        // OK, Go FCM
                    } else {
                        // Database Error
                    }
                } elseif ($this->status_donatur == "Donatur Aktif" && $cek_status_donatur[0]['id_status_donatur'] > 1 && $cek_status_donatur[0]['id_status_donatur'] != 3) {
                    $send_msg[$i]['fcm_token'] = $d['fcm_token'];
                    $update_data               = array(
                        'id_status_donatur' => 2,
                    );
                    $where   = array('email' => $d['email']);
                    $execute = $this->Kewirausahaan_model->update_data('donatur', $update_data, $where);
                    if ($execute >= 1) {
                        // OK, Go FCM
                    } else {
                        // Database Error
                    }
                }
                $i++;
            } else {
                $this->rank[$i]['email']            = $d['email'];
                $this->rank[$i]['nama']             = $d['nama'];
                $this->rank[$i]['persentase_hasil'] = 0;
                $i++;
            }
        }

        //Start FCM Code
        $title        = "Terima Kasih";
        $body         = "Anda Kami Nobatkan Sebagai Donatur Tetap Kami. Terima Kasih Telah Berdonasi Pada Komunitas Kami.";
        $message      = "null";
        $message_type = "konfirmasi donasi";
        $intent       = "NotificationFragment";
        $id_target    = "null";
        $date_rcv     = date("Y-m-d");

        $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
        $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";

        $ids = array();
        $i   = 0;
        foreach ($send_msg as $d) {
            $ids[$i] = $d['fcm_token'];
            $i++;
        }
        if (!empty($ids)) {
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
        }
        // print_r($ids);
        // echo "<hr>";
        // print_r($result);
        //End FCM Code

        $this->rank_result = array();
        foreach ($this->rank as $r) {
            $this->rank_result[] = $r['persentase_hasil'];
        }
        array_multisort($this->rank_result, SORT_DESC, $this->rank);
        // print_r($this->rank);
    }
}
