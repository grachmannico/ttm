<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kewirausahaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->view('header');
        $this->load->view('kewirausahaan/sidebar-kewirausahaan');
    }

    public function index()
    {
        $this->load->view("kewirausahaan/dashboard_kewirausahaan");
        $this->load->view('footer');
    }

    public function mengelola_donatur()
    {
        $donatur = $this->Kewirausahaan_model->get_donatur();
        $this->load->view("kewirausahaan/v_mengelola_donatur", array('donatur' => $donatur));
        $this->load->view('footer');
    }

    public function edit_donatur()
    {
        $edit  = $this->input->post("edit");
        $email = $this->input->post("email");
        $nama  = $this->input->post("nama");
        $pass  = $this->input->post("pass");
        if ($edit != "") {
            $data_donatur = $this->Kewirausahaan_model->get_data_donatur("where email = '$edit'");
            $this->load->view("kewirausahaan/v_form_edit_donatur", array('data_donatur' => $data_donatur));
            $this->load->view('footer');
        } elseif ($email != "" && $nama != "" && $pass != "") {
            $update_data_donatur = array(
                'nama' => $nama,
                'pass' => $pass,
            );
            $where   = array('email' => $email);
            $execute = $this->Kewirausahaan_model->update_data('donatur', $update_data_donatur, $where);
            if ($execute >= 1) {
                redirect("Kewirausahaan/mengelola_donatur");
            } else {
                echo "gagal";
            }
        }
    }

    public function detail_donatur()
    {
        $donatur             = $this->input->post("donatur");
        $data_donatur        = $this->Kewirausahaan_model->get_donatur("where dr.email = '$donatur'");
        $data_donasi_donatur = $this->Kewirausahaan_model->get_data_donasi_donatur("where dr.email = '$donatur'");
        $this->load->view("kewirausahaan/v_detail_donatur", array('data_donatur' => $data_donatur, 'data_donasi_donatur' => $data_donasi_donatur));
        $this->load->view('footer');
    }

    public function mengelola_donasi()
    {
        $transaksi_donasi = $this->Kewirausahaan_model->get_transaksi_donasi("where id_status_donasi = 2");
        $this->load->view("kewirausahaan/v_mengelola_donasi", array('transaksi_donasi' => $transaksi_donasi));
        $this->load->view('footer');
    }

    public function validasi_donasi()
    {
        $id_donasi       = $this->input->post("id_donasi");
        $validasi_donasi = array(
            'id_status_donasi' => 3,
        );
        $where   = array('id_donasi' => $id_donasi);
        $execute = $this->Kewirausahaan_model->update_data('donasi', $validasi_donasi, $where);
        if ($execute >= 1) {
            redirect("Kewirausahaan/mengelola_donasi");
        } else {
            echo "gagal";
        }
    }

    public function mengelola_garage_sale()
    {
        $barang = $this->Kewirausahaan_model->get_barang();
        $this->load->view("kewirausahaan/v_mengelola_garage_sale", array('barang' => $barang));
        $this->load->view('footer');
    }

    public function tambah_barang_garage_sale()
    {
        $nama_barang    = $this->input->post("nama_barang");
        $deskripsi      = $this->input->post("deskripsi");
        $harga          = $this->input->post("harga");
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
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                    'stok_terpesan'  => $stok_available,
                );
                $execute = $this->Kewirausahaan_model->insert_data('barang_garage_sale', $tambah_barang);
                if ($execute >= 1) {
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    echo "gagal";
                }
            } else {
                $data          = array('upload_data' => $this->upload->data());
                $tambah_barang = array(
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                    'stok_terpesan'  => $stok_available,
                    'gambar_barang'  => $this->upload->data('file_name'),
                );
                $execute = $this->Kewirausahaan_model->insert_data('barang_garage_sale', $tambah_barang);
                if ($execute >= 1) {
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    echo "gagal";
                }
            }
        } else {
            echo "gagal";
        }
    }

    public function edit_barang_garage_sale()
    {
        $edit                  = $this->input->post("edit");
        $id_barang_garage_sale = $this->input->post("id_barang_garage_sale");
        $nama_barang           = $this->input->post("nama_barang");
        $deskripsi             = $this->input->post("deskripsi");
        $harga                 = $this->input->post("harga");
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
                $update_barang = array(
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_barang, $where);
                if ($execute >= 1) {
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    echo "gagal";
                }
            } else {
                $data          = array('upload_data' => $this->upload->data());
                $update_barang = array(
                    'nama_barang'    => $nama_barang,
                    'deskripsi'      => $deskripsi,
                    'harga'          => $harga,
                    'stok_available' => $stok_available,
                    'gambar_barang'  => $this->upload->data('file_name'),
                );
                $where   = array('id_barang_garage_sale' => $id_barang_garage_sale);
                $execute = $this->Kewirausahaan_model->update_data('barang_garage_sale', $update_barang, $where);
                if ($execute >= 1) {
                    redirect("Kewirausahaan/mengelola_garage_sale");
                } else {
                    echo "gagal";
                }
            }
        }
    }

    public function hapus_barang_garage_sale()
    {
        $hapus   = $this->input->post("hapus");
        $where   = array('id_barang_garage_sale' => $hapus);
        $execute = $this->Kewirausahaan_model->delete_data('barang_garage_sale', $where);
        if ($execute >= 1) {
            redirect("Kewirausahaan/mengelola_garage_sale");
        } else {
            echo "gagal";
        }
    }

    public function detail_barang_garage_sale()
    {
        $barang         = $this->input->post("barang");
        $detail_barang  = $this->Kewirausahaan_model->get_barang("where id_barang_garage_sale = $barang");
        $data_pembelian = $this->Kewirausahaan_model->get_data_pembelian_barang("where b.id_barang_garage_sale = $barang");
        $this->load->view("kewirausahaan/v_detail_barang_garage_sale", array('detail_barang' => $detail_barang, 'data_pembelian' => $data_pembelian));
        $this->load->view('footer');
    }

    public function validasi_pembelian()
    {
        $validasi = $this->input->post("validasi");
        if ($validasi == "") {
            $invoice = $this->Kewirausahaan_model->get_invoice("where id_status_pembelian = 2");
            $this->load->view("kewirausahaan/v_validasi_pembelian", array('invoice' => $invoice));
            $this->load->view('footer');
        } elseif ($validasi != "") {
            $validasi_pembelian = array(
                'id_status_pembelian' => 3,
            );
            $where   = array('id_invoice' => $validasi);
            $execute = $this->Kewirausahaan_model->update_data('pembelian', $validasi_pembelian, $where);
            if ($execute >= 1) {
                redirect("Kewirausahaan/validasi_pembelian");
            } else {
                echo "gagal";
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
        }
    }

    public function mengelola_lpj()
    {
        $data_kegiatan = $this->Kewirausahaan_model->get_kegiatan();
        $this->load->view("kewirausahaan/v_mengelola_lpj", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function kelola_laporan()
    {
        $id_kegiatan   = $this->input->post("id_kegiatan");
        $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
        $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
        $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
        $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
        $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
        $this->load->view('footer');
    }

    public function tambah_data_pengeluaran()
    {
        $id_kegiatan         = $this->input->post("id_kegiatan");
        $nama_dana_keluar    = $this->input->post("nama_dana_keluar");
        $tanggal             = $this->input->post("tanggal");
        $nominal_dana_keluar = $this->input->post("nominal_dana_keluar");
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
                $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
                $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
                $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
                $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
                $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
                $this->load->view('footer');
            } else {
                echo "gagal";
            }
        }
    }

    public function edit_data_pengeluaran()
    {
        $edit                     = $this->input->post("edit");
        $id_kegiatan              = $this->input->post("id_kegiatan");
        $nama_dana_keluar         = $this->input->post("nama_dana_keluar");
        $tanggal                  = $this->input->post("tanggal");
        $nominal_dana_keluar      = $this->input->post("nominal_dana_keluar");
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
                $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
                $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
                $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
                $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
                $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
                $this->load->view('footer');
            } else {
                echo "gagal";
            }
        }
    }

    public function hapus_data_pengeluaran()
    {
        $hapus       = $this->input->post("hapus");
        $id_kegiatan = $this->input->post("id_kegiatan");
        $where       = array('id_monitor_dana_kegiatan' => $hapus);
        $execute     = $this->PPG_model->delete_data('monitor_dana_kegiatan', $where);
        if ($execute >= 1) {
            $nama_kegiatan = $this->Kewirausahaan_model->get_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $dana_masuk    = $this->Kewirausahaan_model->get_data_donasi_donatur("where k.id_kegiatan = $id_kegiatan and dn.id_status_donasi = 3");
            $total_dana    = $this->Kewirausahaan_model->get_total_donasi("where id_status_donasi = 3 and id_kegiatan = $id_kegiatan");
            $dana_keluar   = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
            $this->load->view("kewirausahaan/v_kelola_laporan", array('dana_masuk' => $dana_masuk, 'total_dana' => $total_dana, 'dana_keluar' => $dana_keluar, 'id_kegiatan' => $id_kegiatan, 'nama_kegiatan' => $nama_kegiatan));
            $this->load->view('footer');
        } else {
            echo "gagal";
        }
    }
}
