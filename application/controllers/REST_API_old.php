<?php
defined('BASEPATH') or exit('No direct script access allowed');
class REST_API extends CI_Controller
{
    private $status;

    public function index()
    {
        echo "This is Web Service<br>";
        $this->tampil_kegiatan();
    }

    public function auth()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        if ($email != "" && $password != "") {
            $pengguna = $this->pengguna_model->get_pengguna("where email = '$email'");
            if (empty($pengguna)) {
                $status['status']        = "gagal";
                $status['tipe_pengguna'] = "gagal";
                $status['email']         = "null";
                $status['nama']          = "null";
                echo json_encode($status);
            } else {
                if ($email == $pengguna[0]['email'] && $password == $pengguna[0]['pass']) {
                    if ($pengguna[0]['tipe_pengguna'] == "relawan") {
                        $status['status']        = "sukses";
                        $status['tipe_pengguna'] = "relawan";
                        $status['email']         = $pengguna[0]['email'];
                        $status['nama']          = $pengguna[0]['nama'];
                        echo json_encode($status);
                        // echo json_encode($pengguna[0]);
                    } elseif ($pengguna[0]['tipe_pengguna'] == "donatur") {
                        $status['status']        = "sukses";
                        $status['tipe_pengguna'] = "donatur";
                        $status['email']         = $pengguna[0]['email'];
                        $status['nama']          = $pengguna[0]['nama'];
                        echo json_encode($status);
                        // echo json_encode($pengguna[0]);
                    }
                } else {
                    $status['status']        = "gagal";
                    $status['tipe_pengguna'] = "gagal";
                    $status['email']         = "null";
                    $status['nama']          = "null";
                    echo json_encode($status);
                }
            }
        } else {
            $status['status']        = "gagal";
            $status['tipe_pengguna'] = "gagal";
            $status['email']         = "null";
            $status['nama']          = "null";
            echo json_encode($status);
        }
    }

    public function register()
    {
        $nama     = $this->input->post("nama");
        $email    = $this->input->post("email");
        $password = $this->input->post("password");
        if ($nama != "" && $email != "" && $password != "") {
            $cek_pengguna = $this->pengguna_model->get_pengguna("where email = '$email'");
            if (!empty($cek_pengguna)) {
                $status['status'] = "exist";
                echo json_encode($status);
            } else {
                $pengguna_baru = array(
                    'nama'             => $nama,
                    'email'            => $email,
                    'pass'             => $password,
                    'id_tipe_pengguna' => 2,
                    'fcm_token'        => "",
                );
                $execute = $this->pengguna_model->insert_data('pengguna', $pengguna_baru);
                if ($execute >= 1) {
                    $status['status'] = "sukses";
                    echo json_encode($status);
                } else {
                    $status['status'] = "gagal";
                    echo json_encode($status);
                }
            }
        } else {
            $status['status'] = "gagal";
            echo json_encode($status);
        }
    }

    public function tampil_kegiatan()
    {
        $data_kegiatan = $this->pengguna_model->get_kegiatan();
        $this->load->view("rest_api/v_rest_api", array('data_kegiatan' => $data_kegiatan));
        echo json_encode($data_kegiatan);
    }

    public function detail_kegiatan()
    {
        $data_detail_kegiatan = array();
        $id_kegiatan          = $this->input->post("id_kegiatan");
        // if ($id_kegiatan != "") {
        $data_kegiatan  = $this->pengguna_model->get_detail_kegiatan("where id_kegiatan = $id_kegiatan and id_status_kegiatan = 1");
        $jumlah_relawan = $this->pengguna_model->get_jumlah_relawan("where k.id_kegiatan = $id_kegiatan");
        $jumlah_donasi  = $this->pengguna_model->get_jumlah_donasi("and k.id_kegiatan = $id_kegiatan");
        if (empty($jumlah_donasi)) {
            $donasi_terkumpul = 0;
        } else {
            $donasi_terkumpul = $jumlah_donasi[0]['jumlah_donasi'];
        }
        $data_detail_kegiatan['id_kegiatan']             = $data_kegiatan[0]['id_kegiatan'];
        $data_detail_kegiatan['nama_kegiatan']           = $data_kegiatan[0]['nama_kegiatan'];
        $data_detail_kegiatan['pesan_ajakan']            = $data_kegiatan[0]['pesan_ajakan'];
        $data_detail_kegiatan['deskripsi_kegiatan']      = $data_kegiatan[0]['deskripsi_kegiatan'];
        $data_detail_kegiatan['id_kegiatan']             = $data_kegiatan[0]['id_kegiatan'];
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
        $this->load->view("rest_api/v_detail_kegiatan", array('data_detail_kegiatan' => $data_detail_kegiatan));
        echo json_encode($data_detail_kegiatan);
        // }
    }

    public function gabung_kegiatan()
    {
        $id_kegiatan = $this->input->post("gabung");
        $email       = $this->input->post("email");
        $cek_relawan = $this->pengguna_model->get_relawan("where email = '$email'");
        if (!empty($cek_relawan)) {
            $status['status'] = "exist";
            echo json_encode($status);
        } else {
            $gabung_kegiatan = array(
                'id_status_kehadiran_relawan' => 1,
                'id_kegiatan'                 => $id_kegiatan,
                'email'                       => $email,
            );
            $execute = $this->pengguna_model->insert_data('relawan', $gabung_kegiatan);
            if ($execute >= 1) {
                $status['status'] = "sukses";
                echo json_encode($status);
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        }
    }

    public function donasi()
    {
        $id_kegiatan    = $this->input->post("donasi");
        $email          = $this->input->post("email");
        $nominal_donasi = $this->input->post("nominal_donasi");
        if ($nominal_donasi == 0) {
            $status['status'] = "0";
            echo json_encode($status);
        } else {
            $donasi_kegiatan = array(
                'id_kegiatan'      => $id_kegiatan,
                'email'            => $email,
                'id_status_donasi' => 1,
                'nominal_donasi'   => $nominal_donasi,
                'tanggal_donasi'   => date("Y-m-d"),
            );
            $execute = $this->pengguna_model->insert_data('donasi', $donasi_kegiatan);
            if ($execute >= 1) {
                $status['status'] = "sukses";
                echo json_encode($status);
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        }
    }

    public function list_konfirmasi_donasi()
    {
        $email                  = $this->input->post("email");
        $list_konfirmasi_donasi = $this->pengguna_model->get_list_konfirmasi_donasi("and email = '$email'");
        echo json_encode($list_konfirmasi_donasi);
        $this->load->view("rest_api/v_list_konfirmasi_donasi", array('list_konfirmasi_donasi' => $list_konfirmasi_donasi));
    }

    public function form_konfirmasi_donasi()
    {
        $id_donasi         = $this->input->post("id_donasi");
        $konfirmasi_donasi = $this->pengguna_model->get_list_konfirmasi_donasi("and id_donasi = $id_donasi");
        $this->load->view("rest_api/v_konfirmasi_donasi", array('konfirmasi_donasi' => $konfirmasi_donasi));
    }

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
        } else {
            $data = array('upload_data' => $this->upload->data());
            // echo "<img src='" . base_url() . "uploads/" . $this->upload->data('file_name') . "'>";
            $update_status_donasi = array(
                'id_status_donasi' => 2,
                'struk_donasi'     => $this->upload->data('file_name'),
            );
            $where   = array('id_donasi' => $id_donasi);
            $execute = $this->pengguna_model->update_data('donasi', $update_status_donasi, $where);
            if ($execute >= 1) {
                $status['status'] = "sukses";
                echo json_encode($status);
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        }
    }

    public function list_kegiatan_diikuti()
    {
        $email    = $this->input->post("email");
        $pengguna = $this->pengguna_model->get_pengguna("where email = '$email'");
        if ($pengguna[0]['tipe_pengguna'] == "relawan") {
            $subscribe = $this->pengguna_model->get_subscribe_relawan("where email = '$email' and id_status_kegiatan = 3");
        } elseif ($pengguna[0]['tipe_pengguna'] == "donatur") {
            $subscribe = $this->pengguna_model->get_subscribe_donatur("where email = '$email' and id_status_kegiatan = 3");
        }
        $this->load->view("rest_api/v_list_kegiatan_diikuti", array('subscribe' => $subscribe));
    }

    public function form_feedback()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        $email       = $this->input->post("email");
        $this->load->view("rest_api/v_form_feedback", array('id_kegiatan' => $id_kegiatan, 'email' => $email));
    }

    public function kirim_feedback()
    {
        $email             = $this->input->post("email");
        $id_kegiatan       = $this->input->post("id_kegiatan");
        $komentar          = $this->input->post("komentar");
        $rating            = $this->input->post("rating");
        $feedback_kegiatan = array(
            'email'       => $email,
            'id_kegiatan' => $id_kegiatan,
            'rating'      => $rating,
            'komentar'    => $komentar,
        );
        $execute = $this->pengguna_model->insert_data('feedback_kegiatan', $feedback_kegiatan);
        if ($execute >= 1) {
            $status['status'] = "sukses";
            echo json_encode($status);
        } else {
            $status['status'] = "gagal";
            echo json_encode($status);
        }
    }

    public function lihat_garage_sale()
    {
        $email   = $this->input->post("email");
        $invoice = $this->input->post("invoice");
        if ($invoice == "") {
            $barang = $this->pengguna_model->get_barang();
            $this->load->view("rest_api/v_garage_sale", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
        } else if ($invoice != "") {
            $barang = $this->pengguna_model->get_barang();
            $this->load->view("rest_api/v_garage_sale", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
        }
    }

    public function detail_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        if ($invoice == "") {
            $invoice = "";
            $barang  = $this->pengguna_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
            $this->load->view("rest_api/v_detail_barang", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
        } else {
            $barang = $this->pengguna_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
            $this->load->view("rest_api/v_detail_barang", array('barang' => $barang, 'email' => $email, 'invoice' => $invoice));
        }
    }

    public function beli_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        $qty                   = $this->input->post("qty");
        if ($invoice == "") {
            $date         = (string) date("Y-m-d");
            $invoice      = $email . $date;
            $invoice_baru = array(
                'id_invoice'          => $invoice,
                'id_status_pembelian' => 5,
                'email'               => $email,
                'tanggal_pembelian'   => date("Y-m-d"),
            );
            $execute = $this->pengguna_model->insert_data('pembelian', $invoice_baru);
            if ($execute >= 1) {
                $tambah_barang = array(
                    'id_barang_garage_sale' => $id_barang_garage_sale,
                    'id_invoice'            => $invoice,
                    'qty'                   => $qty,
                );
                $execute = $this->pengguna_model->insert_data('keranjang_belanja', $tambah_barang);
                if ($execute >= 1) {
                    $barang               = $this->pengguna_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                    $qty_sebelum          = $barang[0]['stok_terpesan'];
                    $update_stok_terpesan = array(
                        'stok_terpesan' => $qty_sebelum - $qty,
                    );
                    $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                    $execute = $this->pengguna_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                    if ($execute >= 1) {
                        $keranjang_belanja = $this->pengguna_model->get_keranjang_barang("where id_invoice = '$invoice'");
                        $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
                    } else {
                        $status['status'] = "gagal";
                        echo json_encode($status);
                    }
                } else {
                    $status['status'] = "gagal";
                    echo json_encode($status);
                }
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        } elseif ($invoice != "") {
            $tambah_barang = array(
                'id_barang_garage_sale' => $id_barang_garage_sale,
                'id_invoice'            => $invoice,
                'qty'                   => $qty,
            );
            $execute = $this->pengguna_model->insert_data('keranjang_belanja', $tambah_barang);
            if ($execute >= 1) {
                $barang               = $this->pengguna_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
                $qty_sebelum          = $barang[0]['stok_terpesan'];
                $update_stok_terpesan = array(
                    'stok_terpesan' => $qty_sebelum - $qty,
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->pengguna_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
                if ($execute >= 1) {
                    $keranjang_belanja = $this->pengguna_model->get_keranjang_barang("where id_invoice = '$invoice'");
                    $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
                } else {
                    $status['status'] = "gagal";
                    echo json_encode($status);
                }
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        }
    }

    public function keranjang_belanja()
    {
        $email             = $this->input->post("email");
        $invoice           = $this->input->post("invoice");
        $keranjang_belanja = $this->pengguna_model->get_keranjang_barang("where id_invoice = '$invoice'");
        if ($invoice == "") {
            echo "Tidak ada invoice<br>";
        } elseif ($invoice != "") {
            $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
        }
    }

    public function hapus_barang()
    {
        $email                 = $this->input->post("email");
        $invoice               = $this->input->post("invoice");
        $id_keranjang_belanja  = $this->input->post("id_keranjang_belanja");
        $barang_di_keranjang   = $this->pengguna_model->get_keranjang_barang("where id_keranjang_belanja = $id_keranjang_belanja");
        $qty                   = $barang_di_keranjang[0]['qty'];
        $id_barang_garage_sale = $barang_di_keranjang[0]['id_barang_garage_sale'];
        $barang                = $this->pengguna_model->get_barang("where id_barang_garage_sale = $id_barang_garage_sale");
        $qty_sebelum           = $barang[0]['stok_terpesan'];
        $update_stok_terpesan  = array(
            'stok_terpesan' => $qty_sebelum + $qty,
        );
        $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
        $execute = $this->pengguna_model->update_data('barang_garage_sale', $update_stok_terpesan, $where);
        if ($execute >= 1) {
            $where   = array('id_keranjang_belanja' => $id_keranjang_belanja);
            $execute = $this->pengguna_model->delete_data('keranjang_belanja', $where);
            if ($execute >= 1) {
                $keranjang_belanja = $this->pengguna_model->get_keranjang_barang("where id_invoice = '$invoice'");
                $this->load->view("rest_api/v_keranjang_belanja", array('keranjang_belanja' => $keranjang_belanja, 'email' => $email, 'invoice' => $invoice));
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        } else {
            $status['status'] = "gagal";
            echo json_encode($status);
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
        $execute = $this->pengguna_model->update_data('pembelian', $update_invoice, $where);
        if ($execute >= 1) {
            $status['status'] = "sukses";
            echo json_encode($status);
        } else {
            $status['status'] = "gagal";
            echo json_encode($status);
        }
    }

    public function list_konfirmasi_pembayaran()
    {
        $email          = $this->input->post("email");
        $list_pembelian = $this->pengguna_model->get_list_pembelian("where email = '$email' and id_status_pembelian = 1");
        $this->load->view("rest_api/v_list_pembelian", array('list_pembelian' => $list_pembelian));
    }

    public function detail_pembelian()
    {
        $invoice           = $this->input->post("invoice");
        $keranjang_belanja = $this->pengguna_model->get_keranjang_barang("where id_invoice = '$invoice'");
        if ($invoice == "") {
            echo "Tidak ada invoice<br>";
        } elseif ($invoice != "") {
            $this->load->view("rest_api/v_detail_pembelian", array('keranjang_belanja' => $keranjang_belanja, 'invoice' => $invoice));
        }
    }

    public function form_konfirmasi_pembelian()
    {
        $invoice       = $this->input->post("invoice");
        $total_tagihan = $this->pengguna_model->get_total_tagihan("and id_invoice = '$invoice'");
        $this->load->view("rest_api/v_form_konfirmasi_pembelian", array('total_tagihan' => $total_tagihan, 'invoice' => $invoice));
    }

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
        } else {
            $data = array('upload_data' => $this->upload->data());
            // echo "<img src='" . base_url() . "uploads/" . $this->upload->data('file_name') . "'>";
            $update_status_pembelian = array(
                'id_status_pembelian' => 2,
                'struk_pembelian'     => $this->upload->data('file_name'),
            );
            $where   = array('id_invoice' => $invoice);
            $execute = $this->pengguna_model->update_data('pembelian', $update_status_pembelian, $where);
            if ($execute >= 1) {
                $status['status'] = "sukses";
                echo json_encode($status);
            } else {
                $status['status'] = "gagal";
                echo json_encode($status);
            }
        }
    }
}
