<?php
defined('BASEPATH') or exit('No direct script access allowed');
class REST_API extends CI_Controller
{
    private $json_data;

    public function index()
    {
        echo "This is Web Service<br>";
    }

    public function auth()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        $token    = $this->input->post("token");
        if ($email != "" && $password != "" && $token != "") {
            $relawan = $this->REST_API_model->get_relawan("where email = '$email'");
            if (empty($relawan)) {
                $donatur = $this->REST_API_model->get_donatur("where email = '$email'");
                if (empty($donatur)) {
                    $json_data['status'] = "gagal";
                } else {
                    if ($email == $donatur[0]['email'] && $password == $donatur[0]['pass']) {
                        // fcm token config here
                        $update_token = array(
                            'fcm_token' => $token,
                        );
                        $where   = array('email' => $email);
                        $execute = $this->REST_API_model->update_data('donatur', $update_token, $where);
                        if ($execute >= 1) {
                            $json_data['status']        = "sukses";
                            $json_data['tipe_pengguna'] = "donatur";
                            $json_data['email']         = $donatur[0]['email'];
                            $json_data['nama']          = $donatur[0]['nama'];
                            $json_data['foto_profil']   = $donatur[0]['foto_profil'];
                            echo json_encode($json_data);
                        } else {
                            $json_data['status'] = "gagal";
                            echo json_encode($json_data);
                        }
                    } else {
                        $json_data['status'] = "gagal";
                        echo json_encode($json_data);
                    }
                }
            } else {
                if ($email == $relawan[0]['email'] && $password == $relawan[0]['pass']) {
                    // fcm token config here
                    $update_token = array(
                        'fcm_token' => $token,
                    );
                    $where   = array('email' => $email);
                    $execute = $this->REST_API_model->update_data('relawan', $update_token, $where);
                    if ($execute >= 1) {
                        $json_data['status']         = "sukses";
                        $json_data['tipe_pengguna']  = "relawan";
                        $json_data['email']          = $relawan[0]['email'];
                        $json_data['nama']           = $relawan[0]['nama'];
                        $json_data['pangkat_divisi'] = $relawan[0]['pangkat_divisi'];
                        $json_data['divisi']         = $relawan[0]['divisi'];
                        $json_data['foto_profil']    = $relawan[0]['foto_profil'];
                        echo json_encode($json_data);
                    } else {
                        $json_data['status'] = "gagal";
                        echo json_encode($json_data);
                    }
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            }
        } else {
            $json_data['status'] = "gagal";
            echo json_encode($json_data);
        }
    }

    public function register()
    {
        $nama     = $this->input->post("nama");
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        if ($nama != "" && $email != "" && $password != "") {
            $cek_donatur = $this->REST_API_model->get_donatur("where email = '$email'");
            if (!empty($cek_donatur)) {
                $json_data['status'] = "exist";
                echo json_encode($json_data);
            } else {
                $donatur_baru = array(
                    'nama'      => $nama,
                    'email'     => $email,
                    'pass'      => $password,
                    'fcm_token' => "",
                );
                $execute = $this->REST_API_model->insert_data('donatur', $donatur_baru);
                if ($execute >= 1) {
                    $json_data['status'] = "sukses";
                    echo json_encode($json_data);
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            }
        } else {
            $json_data['status'] = "gagal";
            echo json_encode($json_data);
        }
    }

    public function tampil_kegiatan()
    {
        $id_status_kegiatan = $this->input->post("id_status_kegiatan");
        if ($id_status_kegiatan == "") {
            $data_kegiatan = $this->REST_API_model->get_kegiatan();
            // $this->load->view("rest_api/v_rest_api", array('data_kegiatan' => $data_kegiatan));
            echo json_encode($data_kegiatan);
        } elseif ($id_status_kegiatan == 1) {
            $data_kegiatan = $this->REST_API_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
            // $this->load->view("rest_api/v_rest_api", array('data_kegiatan' => $data_kegiatan));
            echo json_encode($data_kegiatan);
        } elseif ($id_status_kegiatan == 2) {
            $data_kegiatan = $this->REST_API_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
            // $this->load->view("rest_api/v_rest_api", array('data_kegiatan' => $data_kegiatan));
            echo json_encode($data_kegiatan);
        } elseif ($id_status_kegiatan == 3) {
            $data_kegiatan = $this->REST_API_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
            // $this->load->view("rest_api/v_rest_api", array('data_kegiatan' => $data_kegiatan));
            echo json_encode($data_kegiatan);
        }
    }

    public function detail_kegiatan()
    {
        $data_detail_kegiatan  = array();
        $id_kegiatan           = $this->input->post("id_kegiatan");
        $email                 = $this->input->post("email");
        $data_kegiatan         = $this->REST_API_model->get_detail_kegiatan("where id_kegiatan = $id_kegiatan");
        $jumlah_relawan        = $this->REST_API_model->get_jumlah_relawan("where k.id_kegiatan = $id_kegiatan");
        $jumlah_donasi         = $this->REST_API_model->get_jumlah_donasi("and k.id_kegiatan = $id_kegiatan");
        $cek_relawan_bergabung = $this->REST_API_model->get_relawan_bergabung("where email = '$email' and id_kegiatan = $id_kegiatan");
        if (empty($jumlah_donasi)) {
            $donasi_terkumpul = 0;
        } else {
            $donasi_terkumpul = $jumlah_donasi[0]['jumlah_donasi'];
        }
        if (!empty($cek_relawan_bergabung)) {
            $status_bergabung = "yes";
        } else {
            $status_bergabung = "no";
        }
        $data_detail_kegiatan['id_kegiatan']             = $data_kegiatan[0]['id_kegiatan'];
        $data_detail_kegiatan['nama_kegiatan']           = $data_kegiatan[0]['nama_kegiatan'];
        $data_detail_kegiatan['pesan_ajakan']            = $data_kegiatan[0]['pesan_ajakan'];
        $data_detail_kegiatan['deskripsi_kegiatan']      = $data_kegiatan[0]['deskripsi_kegiatan'];
        $data_detail_kegiatan['jumlah_relawan']          = $jumlah_relawan[0]['jumlah_relawan'];
        $data_detail_kegiatan['minimal_relawan']         = $data_kegiatan[0]['minimal_relawan'];
        $data_detail_kegiatan['jumlah_donasi']           = $donasi_terkumpul;
        $data_detail_kegiatan['minimal_donasi']          = $data_kegiatan[0]['minimal_donasi'];
        $data_detail_kegiatan['tanggal_kegiatan']        = $data_kegiatan[0]['tanggal_kegiatan'];
        $data_detail_kegiatan['batas_akhir_pendaftaran'] = $data_kegiatan[0]['batas_akhir_pendaftaran'];
        $data_detail_kegiatan['alamat']                  = $data_kegiatan[0]['alamat'];
        $data_detail_kegiatan['lat']                     = $data_kegiatan[0]['lat'];
        $data_detail_kegiatan['lng']                     = $data_kegiatan[0]['lng'];
        $data_detail_kegiatan['banner']                  = $data_kegiatan[0]['banner'];
        $data_detail_kegiatan['status_kegiatan']         = $data_kegiatan[0]['status_kegiatan'];
        $data_detail_kegiatan['status_bergabung']        = $status_bergabung;
        // $this->load->view("rest_api/v_detail_kegiatan", array('data_detail_kegiatan' => $data_detail_kegiatan));
        echo json_encode($data_detail_kegiatan);
    }

    public function gabung_kegiatan()
    {
        $id_kegiatan           = $this->input->post("gabung");
        $email                 = $this->input->post("email");
        $cek_relawan_bergabung = $this->REST_API_model->get_relawan_bergabung("where email = '$email' and id_kegiatan = $id_kegiatan");
        if (!empty($cek_relawan_bergabung)) {
            $json_data['status'] = "exist";
            echo json_encode($json_data);
        } else {
            $kegiatan     = $this->REST_API_model->get_detail_kegiatan("where id_kegiatan = $id_kegiatan");
            $today        = date('Y-m-d');
            $exp_kegiatan = date('Y-m-d', strtotime($kegiatan[0]['batas_akhir_pendaftaran']));
            if ($today > $exp_kegiatan) {
                $json_data['status'] = "exp";
                echo json_encode($json_data);
            } else {
                $gabung_kegiatan = array(
                    'id_status_absensi_relawan' => 1,
                    'id_kegiatan'               => $id_kegiatan,
                    'email'                     => $email,
                );
                $execute = $this->REST_API_model->insert_data('gabung_kegiatan', $gabung_kegiatan);
                if ($execute >= 1) {
                    $json_data['status'] = "sukses";
                    echo json_encode($json_data);
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            }
        }
    }

    public function donasi()
    {
        $id_kegiatan    = $this->input->post("donasi");
        $email          = $this->input->post("email");
        $nominal_donasi = $this->input->post("nominal_donasi");
        if ($nominal_donasi == 0) {
            $json_data['status'] = "0";
            echo json_encode($json_data);
        } else {
            $donasi_kegiatan = array(
                'id_kegiatan'      => $id_kegiatan,
                'email'            => $email,
                'id_status_donasi' => 1,
                'nominal_donasi'   => $nominal_donasi,
                'tanggal_donasi'   => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('donasi', $donasi_kegiatan);
            if ($execute >= 1) {
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        }
    }

    public function list_konfirmasi_donasi()
    {
        $email = $this->input->post("email");
        $this->exp_donasi($email);
        $list_konfirmasi_donasi = $this->REST_API_model->get_list_konfirmasi_donasi("and email = '$email'");
        echo json_encode($list_konfirmasi_donasi);
        // $this->load->view("rest_api/v_list_konfirmasi_donasi", array('list_konfirmasi_donasi' => $list_konfirmasi_donasi));
    }

    // public function form_konfirmasi_donasi()
    // {
    //     $id_donasi         = $this->input->post("id_donasi");
    //     $konfirmasi_donasi = $this->REST_API_model->get_list_konfirmasi_donasi("and id_donasi = $id_donasi");
    //     // $this->load->view("rest_api/v_konfirmasi_donasi", array('konfirmasi_donasi' => $konfirmasi_donasi));
    //     echo json_encode($konfirmasi_donasi);
    // }

    public function konfirmasi_donasi()
    {
        $id_donasi               = $this->input->post("id_donasi");
        $config['upload_path']   = './uploads/konfirmasi_donasi/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('struk')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            $json_data['status'] = "error";
            echo json_encode($json_data);
        } else {
            $data = array('upload_data' => $this->upload->data());
            // echo "<img src='" . base_url() . "uploads/" . $this->upload->data('file_name') . "'>";
            $update_status_donasi = array(
                'id_status_donasi' => 2,
                'struk_donasi'     => $this->upload->data('file_name'),
            );
            $where   = array('id_donasi' => $id_donasi);
            $execute = $this->REST_API_model->update_data('donasi', $update_status_donasi, $where);
            if ($execute >= 1) {
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        }
    }

    public function list_kegiatan_diikuti()
    {
        $email   = $this->input->post("email");
        $relawan = $this->REST_API_model->get_relawan("where email = '$email'");
        $donatur = $this->REST_API_model->get_donatur("where email = '$email'");
        if (!empty($relawan)) {
            // $subscribe = $this->REST_API_model->get_subscribe_relawan("where email = '$email' and id_status_kegiatan >= 2");
            $subscribe = $this->REST_API_model->get_subscribe_relawan("where email = '$email'");
            echo json_encode($subscribe);
        } else if (!empty($donatur)) {
            // $subscribe = $this->REST_API_model->get_subscribe_donatur("where email = '$email' and id_status_kegiatan >= 2");
            $subscribe = $this->REST_API_model->get_subscribe_donatur("where email = '$email' and id_status_donasi = 3");
            echo json_encode($subscribe);
        } else {
            $subscribe = array();
            echo json_encode($subscribe);
        }
        // $this->load->view("rest_api/v_list_kegiatan_diikuti", array('subscribe' => $subscribe));
    }

    // public function form_feedback()
    // {
    //     $id_kegiatan = $this->input->post("id_kegiatan");
    //     $email       = $this->input->post("email");
    //     // $this->load->view("rest_api/v_form_feedback", array('id_kegiatan' => $id_kegiatan, 'email' => $email));
    // }

    public function kirim_feedback()
    {
        $email         = $this->input->post("email");
        $id_kegiatan   = $this->input->post("id_kegiatan");
        $komentar      = $this->input->post("komentar");
        $rating        = $this->input->post("rating");
        $tipe_pengguna = $this->input->post("tipe_pengguna");
        if ($tipe_pengguna == "relawan") {
            $feedback_kegiatan = array(
                'email'       => $email,
                'id_kegiatan' => $id_kegiatan,
                'rating'      => $rating,
                'komentar'    => $komentar,
                'tanggal'     => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('feedback_kegiatan_relawan', $feedback_kegiatan);
            if ($execute >= 1) {
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        } elseif ($tipe_pengguna == "donatur") {
            $feedback_kegiatan = array(
                'email'       => $email,
                'id_kegiatan' => $id_kegiatan,
                'rating'      => $rating,
                'komentar'    => $komentar,
                'tanggal'     => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('feedback_kegiatan_donatur', $feedback_kegiatan);
            if ($execute >= 1) {
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        }
    }

    public function lihat_feedback()
    {
        $id_kegiatan   = $this->input->post("id_kegiatan");
        $tipe_pengguna = $this->input->post("tipe_pengguna");
        if ($tipe_pengguna == "relawan") {
            $feedback = $this->REST_API_model->get_feedback_kegiatan_relawan("where id_kegiatan = $id_kegiatan");
        } elseif ($tipe_pengguna == "donatur") {
            $feedback = $this->REST_API_model->get_feedback_kegiatan_donatur("where id_kegiatan = $id_kegiatan");
        }
        // $feedback      = $this->REST_API_model->get_feedback_kegiatan("where id_kegiatan = $id_kegiatan");
        // $this->load->view("rest_api/v_lihat_feedback", array('feedback' => $feedback));
        echo json_encode($feedback);
    }

    public function lihat_balasan_feedback()
    {
        $id_feedback_kegiatan = $this->input->post("id_feedback_kegiatan");
        $tipe_pengguna        = $this->input->post("tipe_pengguna");
        if ($tipe_pengguna == "relawan") {
            $balasan = $this->REST_API_model->get_balasan_feedback_relawan("where id_feedback_kegiatan = $id_feedback_kegiatan");
        } elseif ($tipe_pengguna == "donatur") {
            $balasan = $this->REST_API_model->get_balasan_feedback_donatur("where id_feedback_kegiatan = $id_feedback_kegiatan");
        }
        // $balasan              = $this->REST_API_model->get_balasan_feedback_relawan("where id_feedback_kegiatan = $id_feedback_kegiatan");
        // if (empty($balasan)) {

        // } else {
        // $this->load->view("rest_api/v_list_balasan_feedback", array('balasan' => $balasan));
        echo json_encode($balasan);
        // }
    }

    public function kirim_balasan_feedback()
    {
        $id_feedback_kegiatan = $this->input->post("id_feedback_kegiatan");
        $email                = $this->input->post("email");
        $komentar             = $this->input->post("komentar");
        $tipe_pengguna        = $this->input->post("tipe_pengguna");
        if ($tipe_pengguna == "relawan") {
            $balasan_feedback = array(
                'id_feedback_kegiatan' => $id_feedback_kegiatan,
                'email'                => $email,
                'komentar'             => $komentar,
                'tanggal'              => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('balas_feedback_relawan', $balasan_feedback);
            if ($execute >= 1) {
                $balasan = $this->REST_API_model->get_balasan_feedback_relawan("where id_feedback_kegiatan = $id_feedback_kegiatan");
                // $this->load->view("rest_api/v_list_balasan_feedback", array('balasan' => $balasan));
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        } elseif ($tipe_pengguna == "donatur") {
            $balasan_feedback = array(
                'id_feedback_kegiatan' => $id_feedback_kegiatan,
                'email'                => $email,
                'komentar'             => $komentar,
                'tanggal'              => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('balas_feedback_donatur', $balasan_feedback);
            if ($execute >= 1) {
                $balasan = $this->REST_API_model->get_balasan_feedback_donatur("where id_feedback_kegiatan = $id_feedback_kegiatan");
                // $this->load->view("rest_api/v_list_balasan_feedback", array('balasan' => $balasan));
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        }
    }

    public function lihat_garage_sale()
    {
        $email   = $this->input->post("email");
        $invoice = $this->input->post("invoice");
        $barang  = $this->REST_API_model->get_barang();
        if ($invoice == "") {
            // $this->load->view("rest_api/v_garage_sale", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
            echo json_encode($barang);
        } else if ($invoice != "") {
            // $this->load->view("rest_api/v_garage_sale", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
            echo json_encode($barang);
        }
    }

    public function detail_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        $barang                = $this->REST_API_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
        if ($invoice == "") {
            $invoice = "";
            // $this->load->view("rest_api/v_detail_barang", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
            echo json_encode($barang);
        } else {
            // $this->load->view("rest_api/v_detail_barang", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
            echo json_encode($barang);
        }
    }

    public function beli_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        $qty                   = $this->input->post("qty");
        if ($invoice == "" && $email != "") {
            $date         = (string) date("Y-m-d");
            $invoice      = $email . $date;
            $invoice_baru = array(
                'id_invoice'          => $invoice,
                'id_status_pembelian' => 5,
                'email'               => $email,
                'tanggal_pembelian'   => date("Y-m-d"),
            );
            $execute = $this->REST_API_model->insert_data('pembelian', $invoice_baru);
            if ($execute >= 1) {
                $tambah_barang = array(
                    'id_barang_garage_sale' => $id_barang_garage_sale,
                    'id_invoice'            => $invoice,
                    'qty'                   => $qty,
                );
                $execute = $this->REST_API_model->insert_data('keranjang_belanja', $tambah_barang);
                if ($execute >= 1) {
                    $barang               = $this->REST_API_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                    $qty_sebelum          = $barang[0]['stok_terpesan'];
                    $update_stok_terpesan = array(
                        'stok_terpesan' => $qty_sebelum - $qty,
                    );
                    $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                    $execute = $this->REST_API_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                    if ($execute >= 1) {
                        // $keranjang_belanja = $this->REST_API_model->get_keranjang_barang("where id_invoice = '$invoice'");
                        // $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
                        $json_data['status']  = "sukses";
                        $json_data['invoice'] = $invoice;
                        echo json_encode($json_data);
                    } else {
                        $json_data['status'] = "gagal";
                        echo json_encode($json_data);
                    }
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        } elseif ($invoice != "" && $email != "") {
            $tambah_barang = array(
                'id_barang_garage_sale' => $id_barang_garage_sale,
                'id_invoice'            => $invoice,
                'qty'                   => $qty,
            );
            $execute = $this->REST_API_model->insert_data('keranjang_belanja', $tambah_barang);
            if ($execute >= 1) {
                $barang               = $this->REST_API_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                $qty_sebelum          = $barang[0]['stok_terpesan'];
                $update_stok_terpesan = array(
                    'stok_terpesan' => $qty_sebelum - $qty,
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->REST_API_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                if ($execute >= 1) {
                    // $keranjang_belanja = $this->REST_API_model->get_keranjang_barang("where id_invoice = '$invoice'");
                    // $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
                    $json_data['status']  = "sukses";
                    $json_data['invoice'] = $invoice;
                    echo json_encode($json_data);
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        } else {
            $json_data['status'] = "gagal";
            echo json_encode($json_data);
        }
    }

    public function batal_beli()
    {
        $invoice       = $this->input->post("invoice");
        $cek_data_cart = $this->REST_API_model->get_keranjang_barang("where kb.id_invoice = '$invoice'");
        if (empty($cek_data_cart)) {
            echo "0";
        } elseif (!empty($cek_data_cart)) {
            // print_r($cek_data_cart);
            $i = 0;
            foreach ($cek_data_cart as $c) {
                $barang_di_keranjang   = $this->REST_API_model->get_keranjang_barang("where id_keranjang_belanja = $c[id_keranjang_belanja]");
                $qty                   = $barang_di_keranjang[0]['qty'];
                $id_barang_garage_sale = $barang_di_keranjang[0]['id_barang_garage_sale'];
                $barang                = $this->REST_API_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                $qty_sebelum           = $barang[0]['stok_terpesan'];
                $update_stok_terpesan  = array(
                    'stok_terpesan' => $qty_sebelum + $qty,
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->REST_API_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                if ($execute >= 1) {
                    $where   = array('id_keranjang_belanja' => $c['id_keranjang_belanja']);
                    $execute = $this->REST_API_model->delete_data('keranjang_belanja', $where);
                    if ($execute >= 1) {
                        $current_stat = "sukses";
                        $i++;
                    } else {
                        $json_data['status'] = "gagal";
                        echo json_encode($json_data);
                    }
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            }
            if ($current_stat == "sukses") {
                $where   = array('id_invoice' => $invoice);
                $execute = $this->REST_API_model->delete_data('pembelian', $where);
                if ($execute >= 1) {
                    $json_data['status'] = "sukses";
                    echo json_encode($json_data);
                } else {
                    $json_data['status'] = "gagal";
                    echo json_encode($json_data);
                }
            }
        }
    }

    public function keranjang_belanja()
    {
        $email             = $this->input->post("email");
        $invoice           = $this->input->post("invoice");
        $keranjang_belanja = $this->REST_API_model->get_keranjang_barang("where p.id_invoice = '$invoice' and id_status_pembelian = 5");
        if ($invoice == "") {
            $keranjang_belanja = array();
            echo json_encode($keranjang_belanja);
        } elseif ($invoice != "") {
            // $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
            echo json_encode($keranjang_belanja);
        } else if (empty($keranjang_belanja)) {
            $keranjang_belanja = array();
            echo json_encode($keranjang_belanja);
        }
    }

    public function hapus_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_keranjang_belanja  = $this->input->post("id_keranjang_belanja");
        $barang_di_keranjang   = $this->REST_API_model->get_keranjang_barang("where id_keranjang_belanja = $id_keranjang_belanja");
        $qty                   = $barang_di_keranjang[0]['qty'];
        $id_barang_garage_sale = $barang_di_keranjang[0]['id_barang_garage_sale'];
        $barang                = $this->REST_API_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
        $qty_sebelum           = $barang[0]['stok_terpesan'];
        $update_stok_terpesan  = array(
            'stok_terpesan' => $qty_sebelum + $qty,
        );
        $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
        $execute = $this->REST_API_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
        if ($execute >= 1) {
            $where   = array('id_keranjang_belanja' => $id_keranjang_belanja);
            $execute = $this->REST_API_model->delete_data('keranjang_belanja', $where);
            if ($execute >= 1) {
                // $keranjang_belanja = $this->REST_API_model->get_keranjang_barang("where id_invoice = '$invoice'");
                // $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        } else {
            $json_data['status'] = "gagal";
            echo json_encode($json_data);
        }
    }

    public function pembelian()
    {
        $email          = $this->input->post("email");
        $invoice        = $this->input->post("invoice");
        $update_invoice = array(
            'id_status_pembelian' => 1,
        );
        $where   = array('id_invoice' => $invoice);
        $execute = $this->REST_API_model->update_data('pembelian', $update_invoice, $where);
        if ($execute >= 1) {
            $json_data['status'] = "sukses";
            echo json_encode($json_data);
        } else {
            $json_data['status'] = "gagal";
            echo json_encode($json_data);
        }
    }

    public function list_konfirmasi_pembayaran()
    {
        $email = $this->input->post("email");
        $this->exp_pembelian($email);
        $list_pembelian = $this->REST_API_model->get_list_pembelian("where email = '$email' and id_status_pembelian = 1");
        // $this->load->view("rest_api/v_list_pembelian", array('list_pembelian' => $list_pembelian));
        echo json_encode($list_pembelian);
    }

    public function detail_pembelian()
    {
        $invoice           = $this->input->post("invoice");
        $keranjang_belanja = $this->REST_API_model->get_keranjang_barang("where p.id_invoice = '$invoice'");
        if ($invoice == "") {
            echo "Tidak ada invoice<br>";
            echo json_encode($keranjang_belanja);
        } elseif ($invoice != "") {
            // $this->load->view("rest_api/v_detail_pembelian", array('keranjang_belanja' => $keranjang_belanja, 'invoice' => $invoice));
            echo json_encode($keranjang_belanja);
        }
    }

    // public function form_konfirmasi_pembelian()
    // {
    //     $invoice       = $this->input->post("invoice");
    //     $total_tagihan = $this->REST_API_model->get_total_tagihan("and id_invoice = '$invoice'");
    //     // $this->load->view("rest_api/v_form_konfirmasi_pembelian", array('total_tagihan' => $total_tagihan, 'invoice' => $invoice));
    //     echo json_encode($total_tagihan);
    // }

    public function konfirmasi_pembelian()
    {
        $invoice                 = $this->input->post("invoice");
        $config['upload_path']   = './uploads/konfirmasi_pembayaran/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('struk')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            $json_data['status'] = "error";
            echo json_encode($json_data);
        } else {
            $data = array('upload_data' => $this->upload->data());
            // echo "<img src='" . base_url() . "uploads/" . $this->upload->data('file_name') . "'>";
            $update_status_pembelian = array(
                'id_status_pembelian' => 2,
                'struk_pembelian'     => $this->upload->data('file_name'),
            );
            $where   = array('id_invoice' => $invoice);
            $execute = $this->REST_API_model->update_data('pembelian', $update_status_pembelian, $where);
            if ($execute >= 1) {
                $json_data['status'] = "sukses";
                echo json_encode($json_data);
            } else {
                $json_data['status'] = "gagal";
                echo json_encode($json_data);
            }
        }
    }

    public function monitor_dana()
    {
        $email       = $this->input->post("email");
        $id_kegiatan = $this->input->post("id_kegiatan");
        // if ($email != "") {
        //     $subs_kegiatan = $this->REST_API_model->get_subscribe_donatur("where email = '$email'");
        //     $this->load->view("rest_api/v_list_monitor_dana", array('subs_kegiatan' => $subs_kegiatan));
        //     echo json_encode($subs_kegiatan);
        // } elseif ($id_kegiatan != "") {
        $lpj = $this->REST_API_model->get_laporan_pengeluaran("where m.id_kegiatan = $id_kegiatan order by m.id_monitor_dana_kegiatan desc");
        $this->load->view("rest_api/v_detail_monitor_dana", array('lpj' => $lpj));
        echo json_encode($lpj);
        // }
    }

    public function dokumentasi()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        $dokumentasi = $this->REST_API_model->get_dokumentasi("where d.id_kegiatan = $id_kegiatan");
        echo json_encode($dokumentasi);
    }

    public function send_notification()
    {
        $title = $this->input->post("title");
        $body  = $this->input->post("body");

        echo $title . "<br>";
        echo $body . "<br>";

        $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
        $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
        $data        = $this->REST_API_model->get_relawan();

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
                'title' => $title,
                'body'  => $body,
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
    }

    public function exp_donasi($email)
    {
        $today      = date('Y-m-d');
        $donasi_exp = $this->REST_API_model->get_transaksi_donasi("where d.id_status_donasi = 1 and dn.email = '$email'");
        foreach ($donasi_exp as $d) {
            $payday   = date('Y-m-d', strtotime($d['tanggal_donasi']));
            $exp_date = date('Y-m-d', strtotime($payday . ' + 2 days'));
            if (($today >= $payday) && ($today <= $exp_date)) {
                // OK
            } else {
                // T E R C Y D U Q
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

    public function exp_pembelian($email)
    {
        $today         = date('Y-m-d');
        $pembelian_exp = $this->REST_API_model->get_invoice("where p.id_status_pembelian = 1 and d.email = '$email'");
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
                $execute = $this->REST_API_model->update_data('pembelian', $update_status_pembelian, $where);
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
}
