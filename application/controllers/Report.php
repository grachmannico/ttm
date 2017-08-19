<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }
    public function index()
    {
        $this->load->library('pdfgenerator');

        // $data['users'] = array(
        //     array('firstname' => 'I am', 'lastname' => 'Programmer', 'email' => 'iam@programmer.com'),
        //     array('firstname' => 'I am', 'lastname' => 'Designer', 'email' => 'iam@designer.com'),
        //     array('firstname' => 'I am', 'lastname' => 'User', 'email' => 'iam@user.com'),
        //     array('firstname' => 'I am', 'lastname' => 'Quality Assurance', 'email' => 'iam@qualityassurance.com'),
        // );
        // $html = $this->load->view('table_report', $data, true);
        // $filename = 'report_' . time();
        // $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');

        // $this->load->view('ppg/v_coba_lpj');
        $data_kegiatan         = $this->PPG_model->get_detail_kegiatan("where k.id_kegiatan = 1");
        $data_pengeluaran_dana = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = 1");
        $dokumentasi_kegiatan  = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = 1");
        $total_donasi          = $this->Kewirausahaan_model->get_total_donasi("where id_kegiatan = 1");
        $jumlah_relawan        = $this->PPG_model->get_jumlah_relawan("where k.id_kegiatan = 1");
        $html                  = $this->load->view('ppg/v_coba_lpj', array('data_kegiatan' => $data_kegiatan, 'data_pengeluaran_dana' => $data_pengeluaran_dana, 'dokumentasi_kegiatan' => $dokumentasi_kegiatan, 'total_donasi' => $total_donasi, 'jumlah_relawan' => $jumlah_relawan), true);
        // $this->load->view('ppg/v_coba_lpj', array('data_kegiatan' => $data_kegiatan, 'data_pengeluaran_dana' => $data_pengeluaran_dana, 'dokumentasi_kegiatan' => $dokumentasi_kegiatan, 'total_donasi' => $total_donasi, 'jumlah_relawan' => $jumlah_relawan));
        $filename = 'report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
    }

    public function print_lpj($id_kegiatan = "")
    {
        $this->load->library('pdfgenerator');
        $data_kegiatan         = $this->PPG_model->get_detail_kegiatan("where k.id_kegiatan = $id_kegiatan");
        $data_pengeluaran_dana = $this->Kewirausahaan_model->get_laporan_pengeluaran("where id_kegiatan = $id_kegiatan");
        $dokumentasi_kegiatan  = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
        $total_donasi          = $this->Kewirausahaan_model->get_total_donasi("where id_kegiatan = $id_kegiatan");
        $jumlah_relawan        = $this->PPG_model->get_jumlah_relawan("where k.id_kegiatan = $id_kegiatan and gk.id_status_absensi_relawan = 2");
        $html                  = $this->load->view('ppg/v_coba_lpj', array('data_kegiatan' => $data_kegiatan, 'data_pengeluaran_dana' => $data_pengeluaran_dana, 'dokumentasi_kegiatan' => $dokumentasi_kegiatan, 'total_donasi' => $total_donasi, 'jumlah_relawan' => $jumlah_relawan), true);
        $filename              = 'report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
    }

    public function sertifikat_kegiatan($email = "", $id_kegiatan = "")
    {
        $this->load->library('pdfgenerator');

        // $email       = $this->input->post("email");
        // $id_kegiatan = $this->input->post("id_kegiatan");
        // $email       = "ocin@gmail.com";
        // $id_kegiatan = 3;

        $data_relawan  = $this->Relawan_model->get_data_relawan("where r.email = '$email'");
        $data_kegiatan = $this->PPG_model->get_detail_kegiatan("where k.id_kegiatan = $id_kegiatan");

        $ketua = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi = 1");
        $wakil = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi = 2");

        $html     = $this->load->view('relawan/v_sertifikat_kegiatan', array('data_relawan' => $data_relawan, 'data_kegiatan' => $data_kegiatan, 'ketua' => $ketua, 'wakil' => $wakil), true);
        $filename = 'report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
    }

    public function sertifikat_aktif_relawan($email = "", $tahun = "")
    {
        $this->load->library('pdfgenerator');

        // $email = "ocin@gmail.com";

        $data_relawan = $this->Relawan_model->get_data_relawan("where r.email = '$email'");

        $ketua = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi = 1");
        $wakil = $this->Relawan_model->get_data_relawan("where r.id_pangkat_divisi = 2");

        $html     = $this->load->view('relawan/v_sertifikat_aktif_relawan', array('data_relawan' => $data_relawan, 'ketua' => $ketua, 'wakil' => $wakil, 'tahun' => $tahun), true);
        $filename = 'report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
    }
}
