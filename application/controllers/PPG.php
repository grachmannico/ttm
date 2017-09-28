<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PPG extends CI_Controller
{
    private $def_lat;
    private $def_lng;

    private $persentase_kehadiran;
    private $persentase_donasi;
    private $hasil_rating_relawan;
    private $hasil_rating_donatur;
    private $persentase_gabung_relawan;
    private $persentase_rating_relawan;
    private $persentase_rating_donatur;
    private $jml_relawan;
    private $jml_relawan_hadir;
    private $hasil_analisis;
    private $kesimpulan;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('pangkat_divisi') == "Ketua Divisi" && $this->session->userdata('divisi') == "Penelitian Pengembangan dan Gerakan") {
            $this->load->view('header');
            $this->load->view('ppg/sidebar-ppg');
            //map config
            $this->load->helper(array('form', 'url'));
            $this->load->config('map');
            $this->def_lat = $this->config->item('default_lat');
            $this->def_lng = $this->config->item('default_lng');
            $this->load->library('googlemaps');
        } else {
            redirect("Auth");
        }
    }

    public function index()
    {
        $akan    = $this->PPG_model->get_jml_kegiatan("where k.id_status_kegiatan = 1");
        $sedang  = $this->PPG_model->get_jml_kegiatan("where k.id_status_kegiatan = 2");
        $selesai = $this->PPG_model->get_jml_kegiatan("where k.id_status_kegiatan = 3");
        $latlng  = $this->PPG_model->get_detail_kegiatan();

        //Start Map
        $center = $this->def_lat . "," . $this->def_lng;
        $cfg    = array(
            'class'                       => 'map-canvas',
            'map_div_id'                  => 'map-canvas',
            'center'                      => $center,
            'zoom'                        => 'auto',
            'places'                      => true, //Aktifkan pencarian alamat
            'placesAutocompleteInputID'   => 'cari', //set sumber pencarian input
            'placesAutocompleteBoundsMap' => true,
            'placesAutocompleteOnChange'  => 'showmap();', //Aksi ketika pencarian dipilih
        );
        $this->googlemaps->initialize($cfg);

        $method = "POST";
        $target = "PPG/detail_kegiatan";
        foreach ($latlng as $ll) {
            $marker = array(
                'position'           => $ll['lat'] . "," . $ll['lng'],
                'infowindow_content' => 'Nama Kegiatan: <b>' . $ll['nama_kegiatan'] . '</b><br>Status Kegiatan: ' . $ll['status_kegiatan'] . '<br><br><form action=' . base_url() . $target . ' method= ' . $method . '><button class="btn btn-info btn-block btn-sm" name="kegiatan" value="' . $ll['id_kegiatan'] . '">Lihat Detail Kegiatan <i class="fa fa-arrow-circle-right"></i></button></form>',
                'animation'          => 'DROP',
                'draggable'          => false,
                // 'title'              => 'Coba diDrag',
                'ondragend'          => "document.getElementById('lat').value = event.latLng.lat();
                            document.getElementById('lng').value = event.latLng.lng();
                            showmap();",
            );
            $this->googlemaps->add_marker($marker);
        }
        $d['map'] = $this->googlemaps->create_map();
        // $d['lat'] = $this->def_lat;
        // $d['lng'] = $this->def_lng;
        //End Map

        $this->load->view("ppg/dashboard_ppg", array('akan' => $akan, 'sedang' => $sedang, 'selesai' => $selesai, 'd' => $d));
        $this->load->view('footer');
    }

    public function mengelola_kegiatan()
    {
        $id_status_kegiatan = $this->input->post("id_status_kegiatan");
        if ($id_status_kegiatan == "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $data_kegiatan = $this->PPG_model->get_kegiatan("where k.id_status_kegiatan != 0");
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        } elseif ($id_status_kegiatan != "") {
            $data_kegiatan = $this->PPG_model->get_kegiatan("where k.id_status_kegiatan = $id_status_kegiatan and k.id_status_kegiatan != 0");
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        }
    }

    public function tambah_kegiatan()
    {
        $nama_kegiatan             = $this->input->post("nama_kegiatan");
        $id_status_kegiatan        = $this->input->post("id_status_kegiatan");
        $pesan_ajakan              = $this->input->post("pesan_ajakan");
        $deskripsi_kegiatan        = $this->input->post("deskripsi_kegiatan");
        $minimal_relawan           = str_replace(str_split('_.'), "", $this->input->post("minimal_relawan"));
        $minimal_donasi            = str_replace(str_split('_.'), "", $this->input->post("minimal_donasi"));
        $uang_kas                  = str_replace(str_split('_.'), "", $this->input->post("uang_kas"));
        $tanggal_kegiatan_mulai    = $this->input->post("tanggal_kegiatan_mulai");
        $tanggal_kegiatan_berakhir = $this->input->post("tanggal_kegiatan_berakhir");
        $batas_akhir_pendaftaran   = $this->input->post("batas_akhir_pendaftaran");
        $alamat                    = $this->input->post("alamat");
        $lat                       = $this->input->post("lat");
        $lng                       = $this->input->post("lng");

        //Start Map
        $center = $this->def_lat . "," . $this->def_lng;
        $cfg    = array(
            'class'                       => 'map-canvas',
            'map_div_id'                  => 'map-canvas',
            'center'                      => $center,
            'zoom'                        => 17,
            'places'                      => true, //Aktifkan pencarian alamat
            'placesAutocompleteInputID'   => 'cari', //set sumber pencarian input
            'placesAutocompleteBoundsMap' => true,
            'placesAutocompleteOnChange'  => 'showmap();', //Aksi ketika pencarian dipilih
        );
        $this->googlemaps->initialize($cfg);

        $marker = array(
            'position'  => $center,
            'draggable' => true,
            'title'     => 'Coba diDrag',
            'ondragend' => "document.getElementById('lat').value = event.latLng.lat();
                            document.getElementById('lng').value = event.latLng.lng();
                            showmap();",
        );
        $this->googlemaps->add_marker($marker);

        $d['map'] = $this->googlemaps->create_map();
        $d['lat'] = $this->def_lat;
        $d['lng'] = $this->def_lng;
        //End Map

        if ($nama_kegiatan == "" && $id_status_kegiatan == "" && $pesan_ajakan == "" && $deskripsi_kegiatan == "" && $minimal_relawan == "" && $minimal_donasi == "" && $tanggal_kegiatan_mulai == "" && $tanggal_kegiatan_berakhir == "" && $batas_akhir_pendaftaran == "" && $alamat == "" && $lat == "" && $lng == "") {
            $this->load->view("ppg/v_form_tambah_kegiatan", $d);
            $this->load->view('footer');
        } elseif ($nama_kegiatan != "" && $id_status_kegiatan != "" && $pesan_ajakan != "" && $deskripsi_kegiatan != "" && $minimal_relawan != "" && $minimal_donasi != "" && $tanggal_kegiatan_mulai != "" && $tanggal_kegiatan_berakhir != "" && $batas_akhir_pendaftaran != "" && $alamat != "" && $lat != "" && $lng != "") {
            $config['upload_path']   = './uploads/gambar_kegiatan/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            $cek_nama_kegiatan = $this->PPG_model->get_kegiatan("where k.nama_kegiatan = '$nama_kegiatan'");
            if (empty($cek_nama_kegiatan)) {
                if (!$this->upload->do_upload('banner')) {
                    // $error = array('error' => $this->upload->display_errors());
                    // echo "error";

                    $tambah_kegiatan = array(
                        'nama_kegiatan'             => $nama_kegiatan,
                        'id_status_kegiatan'        => $id_status_kegiatan,
                        'pesan_ajakan'              => $pesan_ajakan,
                        'deskripsi_kegiatan'        => $deskripsi_kegiatan,
                        'minimal_relawan'           => $minimal_relawan,
                        'minimal_donasi'            => $minimal_donasi,
                        'tanggal_kegiatan_mulai'    => $tanggal_kegiatan_mulai,
                        'tanggal_kegiatan_berakhir' => $tanggal_kegiatan_berakhir,
                        'batas_akhir_pendaftaran'   => $batas_akhir_pendaftaran,
                        'alamat'                    => $alamat,
                        'lat'                       => $lat,
                        'lng'                       => $lng,
                    );
                    $execute = $this->PPG_model->insert_data('kegiatan', $tambah_kegiatan);
                    if ($execute >= 1) {

                        //Start FCM Code
                        $get_id_kegiatan = $this->PPG_model->get_kegiatan("where nama_kegiatan = '$nama_kegiatan' order by k.id_kegiatan desc");
                        $title           = "Kegiatan Baru: " . $nama_kegiatan;
                        $body            = $pesan_ajakan;
                        $message         = "null";
                        $message_type    = "kegiatan";
                        $intent          = "DetailKegiatanActivity";
                        $id_target       = $get_id_kegiatan[0]['id_kegiatan'];
                        $date_rcv        = date("Y-m-d");

                        $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                        $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                        $data        = $this->PPG_model->get_all_user();
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

                        if ($uang_kas != "" && $uang_kas != 0) {
                            $tambah_uang = array(
                                'email'            => "admin@ttm.com",
                                'id_status_donasi' => 3,
                                'id_kegiatan'      => $id_target,
                                'nominal_donasi'   => $uang_kas,
                                'tanggal_donasi'   => date("Y-m-d"),
                            );
                            $execute = $this->PPG_model->insert_data('donasi', $tambah_uang);
                            if ($execute >= 1) {
                                // GO AHEAD
                            } else {
                                // Database Error
                            }
                        } elseif ($uang_kas == "" || $uang_kas == 0) {
                            // DO Nothing
                        }

                        $pesan  = "Sukses Menambah Kegiatan";
                        $sukses = array('pesan' => $pesan);
                        $this->session->set_flashdata('success_msg', $sukses);
                        redirect("PPG/mengelola_kegiatan");

                    } else {
                        $pesan      = "Gagal Menambah Kegiatan. Silahkan Cek Kembali.";
                        $url_target = "PPG/tambah_kegiatan";
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
                    $data            = array('upload_data' => $this->upload->data());
                    $tambah_kegiatan = array(
                        'nama_kegiatan'             => $nama_kegiatan,
                        'id_status_kegiatan'        => $id_status_kegiatan,
                        'pesan_ajakan'              => $pesan_ajakan,
                        'deskripsi_kegiatan'        => $deskripsi_kegiatan,
                        'minimal_relawan'           => $minimal_relawan,
                        'minimal_donasi'            => $minimal_donasi,
                        'tanggal_kegiatan_mulai'    => $tanggal_kegiatan_mulai,
                        'tanggal_kegiatan_berakhir' => $tanggal_kegiatan_berakhir,
                        'batas_akhir_pendaftaran'   => $batas_akhir_pendaftaran,
                        'alamat'                    => $alamat,
                        'lat'                       => $lat,
                        'lng'                       => $lng,
                        'banner'                    => $this->upload->data('file_name'),
                    );
                    $execute = $this->PPG_model->insert_data('kegiatan', $tambah_kegiatan);
                    if ($execute >= 1) {

                        //Start FCM Code
                        $get_id_kegiatan = $this->PPG_model->get_kegiatan("where nama_kegiatan = '$nama_kegiatan'");
                        $title           = "Kegiatan Baru: " . $nama_kegiatan;
                        $body            = $pesan_ajakan;
                        $message         = "null";
                        $message_type    = "kegiatan";
                        $intent          = "DetailKegiatanActivity";
                        $id_target       = $get_id_kegiatan[0]['id_kegiatan'];
                        $date_rcv        = date("Y-m-d");

                        $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                        $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                        $data        = $this->PPG_model->get_all_user();
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

                        if ($uang_kas != "" && $uang_kas != 0) {
                            $tambah_uang = array(
                                'email'            => "admin@ttm.com",
                                'id_status_donasi' => 3,
                                'id_kegiatan'      => $id_target,
                                'nominal_donasi'   => $uang_kas,
                                'tanggal_donasi'   => date("Y-m-d"),
                            );
                            $execute = $this->PPG_model->insert_data('donasi', $tambah_uang);
                            if ($execute >= 1) {
                                // GO AHEAD
                            } else {
                                // Database Error
                            }
                        } elseif ($uang_kas == "" || $uang_kas == 0) {
                            // DO Nothing
                        }

                        $pesan  = "Sukses Menambah Kegiatan $nama_kegiatan";
                        $sukses = array('pesan' => $pesan);
                        $this->session->set_flashdata('success_msg', $sukses);

                        redirect("PPG/mengelola_kegiatan");
                    } else {
                        $pesan      = "Gagal Menambah Kegiatan. Silahkan Cek Kembali.";
                        $url_target = "PPG/tambah_kegiatan";
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
                $pesan      = "Gagal Menambah Kegiatan. Nama Kegiatan Sama, Silahkan Cek Kembali.";
                $url_target = "PPG/tambah_kegiatan";
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
            $pesan      = "Gagal Menambah Kegiatan. Isi Seluruh Form Yang Tersedia.";
            $url_target = "PPG/tambah_kegiatan";
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

    public function edit_kegiatan()
    {
        $edit                      = $this->input->post("edit");
        $id_kegiatan               = $this->input->post("id_kegiatan");
        $nama_kegiatan             = $this->input->post("nama_kegiatan");
        $id_status_kegiatan        = $this->input->post("id_status_kegiatan");
        $pesan_ajakan              = $this->input->post("pesan_ajakan");
        $deskripsi_kegiatan        = $this->input->post("deskripsi_kegiatan");
        $minimal_relawan           = str_replace(str_split('_.'), "", $this->input->post("minimal_relawan"));
        $minimal_donasi            = str_replace(str_split('_.'), "", $this->input->post("minimal_donasi"));
        $uang_kas                  = str_replace(str_split('_.'), "", $this->input->post("uang_kas"));
        $tanggal_kegiatan_mulai    = $this->input->post("tanggal_kegiatan_mulai");
        $tanggal_kegiatan_berakhir = $this->input->post("tanggal_kegiatan_berakhir");
        $batas_akhir_pendaftaran   = $this->input->post("batas_akhir_pendaftaran");
        $alamat                    = $this->input->post("alamat");
        $lat                       = $this->input->post("lat");
        $lng                       = $this->input->post("lng");
        if ($edit != "") {
            $detail_kegiatan = $this->PPG_model->get_detail_kegiatan("where id_kegiatan = $edit");
            $data_uang_kas   = $this->PPG_model->get_uang_kas("where id_kegiatan = $edit and email = 'admin@ttm.com'");

            //Start Map
            // $center = $detail_kegiatan[0]['lat'] . "," . $detail_kegiatan[0]['lng'];
            $this->def_lat = $detail_kegiatan[0]['lat'];
            $this->def_lng = $detail_kegiatan[0]['lng'];
            $center        = $this->def_lat . "," . $this->def_lng;
            $cfg           = array(
                'class'                       => 'map-canvas',
                'map_div_id'                  => 'map-canvas',
                'center'                      => $center,
                'zoom'                        => 17,
                'places'                      => true, //Aktifkan pencarian alamat
                'placesAutocompleteInputID'   => 'cari', //set sumber pencarian input
                'placesAutocompleteBoundsMap' => true,
                'placesAutocompleteOnChange'  => 'showmap();', //Aksi ketika pencarian dipilih
            );
            $this->googlemaps->initialize($cfg);

            $marker = array(
                'position'  => $center,
                'draggable' => true,
                'title'     => 'Coba diDrag',
                'ondragend' => "document.getElementById('lat').value = event.latLng.lat();
                            document.getElementById('lng').value = event.latLng.lng();
                            showmap();",
            );
            $this->googlemaps->add_marker($marker);

            $d['map'] = $this->googlemaps->create_map();
            $d['lat'] = $this->def_lat;
            $d['lng'] = $this->def_lng;
            //End Map

            // $this->load->view("ppg/v_form_edit_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'd' => $d));
            $this->load->view("ppg/v_form_edit_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'data_uang_kas' => $data_uang_kas, 'd' => $d));
            $this->load->view('footer');
        } elseif ($id_kegiatan != "" && $nama_kegiatan != "" && $id_status_kegiatan != "" && $pesan_ajakan != "" && $deskripsi_kegiatan != "" && $minimal_relawan != "" && $minimal_donasi != "" && $tanggal_kegiatan_mulai != "" && $tanggal_kegiatan_berakhir != "" && $batas_akhir_pendaftaran != "" && $alamat != "" && $lat != "" && $lng != "") {
            $config['upload_path']   = './uploads/gambar_kegiatan/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            $data_uang_kas = $this->PPG_model->get_uang_kas("where id_kegiatan = $id_kegiatan and email = 'admin@ttm.com'");
            if (!$this->upload->do_upload('banner')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";

                if (empty($data_uang_kas)) {
                    if ($uang_kas != "" && $uang_kas != 0) {
                        $tambah_uang = array(
                            'email'            => "admin@ttm.com",
                            'id_status_donasi' => 3,
                            'id_kegiatan'      => $id_kegiatan,
                            'nominal_donasi'   => $uang_kas,
                            'tanggal_donasi'   => date("Y-m-d"),
                        );
                        $execute = $this->PPG_model->insert_data('donasi', $tambah_uang);
                        if ($execute >= 1) {
                            // GO AHEAD
                        } else {
                            // Database Error
                        }
                    } elseif ($uang_kas == "" || $uang_kas == 0) {
                        // DO Nothing
                    }
                } else {
                    if ($uang_kas != "") {
                        $update_uang_kas = array(
                            'nominal_donasi' => $uang_kas,
                        );
                        $where   = array('id_donasi' => $data_uang_kas[0]['id_donasi']);
                        $execute = $this->PPG_model->update_data('donasi', $update_uang_kas, $where);
                        if ($execute >= 1) {
                            // GO AHEAD
                        } else {
                            // Database Error
                        }
                    } elseif ($uang_kas == "") {
                        // DO Nothing
                    }
                }

                $update_kegiatan = array(
                    'nama_kegiatan'             => $nama_kegiatan,
                    'id_status_kegiatan'        => $id_status_kegiatan,
                    'pesan_ajakan'              => $pesan_ajakan,
                    'deskripsi_kegiatan'        => $deskripsi_kegiatan,
                    'minimal_relawan'           => $minimal_relawan,
                    'minimal_donasi'            => $minimal_donasi,
                    'tanggal_kegiatan_mulai'    => $tanggal_kegiatan_mulai,
                    'tanggal_kegiatan_berakhir' => $tanggal_kegiatan_berakhir,
                    'batas_akhir_pendaftaran'   => $batas_akhir_pendaftaran,
                    'alamat'                    => $alamat,
                    'lat'                       => $lat,
                    'lng'                       => $lng,
                );
                $where   = array('id_kegiatan' => $id_kegiatan);
                $execute = $this->PPG_model->update_data('kegiatan', $update_kegiatan, $where);
                if ($execute >= 1) {

                    //Start FCM Code
                    $get_id_kegiatan = $this->PPG_model->get_kegiatan("where nama_kegiatan = '$nama_kegiatan'");
                    $title           = "Kegiatan " . $nama_kegiatan . " Diperbarui";
                    $body            = "Kegiatan telah diperbarui, lihat sekarang.";
                    $message         = "null";
                    $message_type    = "kegiatan";
                    $intent          = "DetailKegiatanActivity";
                    $id_target       = $get_id_kegiatan[0]['id_kegiatan'];
                    $date_rcv        = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                    $data        = $this->PPG_model->get_all_user();
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

                    $pesan  = "Sukses Meng-edit Kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("PPG/mengelola_kegiatan");
                } else {
                    $pesan      = "Gagal Edit Kegiatan. Silahkan Cek Kembali.";
                    $url_target = "PPG/edit_kegiatan";
                    $name       = "edit";
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
                if (empty($data_uang_kas)) {
                    if ($uang_kas != "" && $uang_kas != 0) {
                        $tambah_uang = array(
                            'email'            => "admin@ttm.com",
                            'id_status_donasi' => 3,
                            'id_kegiatan'      => $id_kegiatan,
                            'nominal_donasi'   => $uang_kas,
                            'tanggal_donasi'   => date("Y-m-d"),
                        );
                        $execute = $this->PPG_model->insert_data('donasi', $tambah_uang);
                        if ($execute >= 1) {
                            // GO AHEAD
                        } else {
                            // Database Error
                        }
                    } elseif ($uang_kas == "" || $uang_kas == 0) {
                        // DO Nothing
                    }
                } else {
                    if ($uang_kas != "") {
                        $update_uang_kas = array(
                            'nominal_donasi' => $uang_kas,
                        );
                        $where   = array('id_donasi' => $data_uang_kas[0]['id_donasi']);
                        $execute = $this->PPG_model->update_data('donasi', $update_uang_kas, $where);
                        if ($execute >= 1) {
                            // GO AHEAD
                        } else {
                            // Database Error
                        }
                    } elseif ($uang_kas == "") {
                        // DO Nothing
                    }
                }

                $data            = array('upload_data' => $this->upload->data());
                $update_kegiatan = array(
                    'nama_kegiatan'             => $nama_kegiatan,
                    'id_status_kegiatan'        => $id_status_kegiatan,
                    'pesan_ajakan'              => $pesan_ajakan,
                    'deskripsi_kegiatan'        => $deskripsi_kegiatan,
                    'minimal_relawan'           => $minimal_relawan,
                    'minimal_donasi'            => $minimal_donasi,
                    'tanggal_kegiatan_mulai'    => $tanggal_kegiatan_mulai,
                    'tanggal_kegiatan_berakhir' => $tanggal_kegiatan_berakhir,
                    'batas_akhir_pendaftaran'   => $batas_akhir_pendaftaran,
                    'alamat'                    => $alamat,
                    'lat'                       => $lat,
                    'lng'                       => $lng,
                    'banner'                    => $this->upload->data('file_name'),
                );
                $where   = array('id_kegiatan' => $id_kegiatan);
                $execute = $this->PPG_model->update_data('kegiatan', $update_kegiatan, $where);
                if ($execute >= 1) {

                    //Start FCM Code
                    $get_id_kegiatan = $this->PPG_model->get_kegiatan("where nama_kegiatan = '$nama_kegiatan'");
                    $title           = "Kegiatan " . $nama_kegiatan . " Diperbarui";
                    $body            = "Kegiatan telah diperbarui, lihat sekarang.";
                    $message         = "null";
                    $message_type    = "kegiatan";
                    $intent          = "DetailKegiatanActivity";
                    $id_target       = $get_id_kegiatan[0]['id_kegiatan'];
                    $date_rcv        = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                    // $data        = $this->PPG_model->get_all_user();
                    $data = $this->PPG_model->get_subs_all_user("k.id_kegiatan = $id_kegiatan");
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

                    $pesan  = "Sukses Meng-edit Kegiatan $nama_kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);

                    redirect("PPG/mengelola_kegiatan");
                } else {
                    $pesan      = "Gagal Edit Kegiatan. Silahkan Cek Kembali.";
                    $url_target = "PPG/edit_kegiatan";
                    $name       = "edit";
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
            }
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "PPG/mengelola_kegiatan";
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

    public function hapus_kegiatan()
    {
        $hapus = $this->input->post("hapus");
        if ($hapus != "") {
            $cek_gabung_relawan = $this->PPG_model->get_cek_gabung_relawan("where id_kegiatan = $hapus");
            $cek_donasi         = $this->PPG_model->get_cek_donasi("where id_kegiatan = $hapus");
            $status_kegiatan    = $this->PPG_model->get_kegiatan("where k.id_kegiatan = $hapus");
            // if (empty($cek_gabung_relawan) && empty($cek_donasi) && $status_kegiatan[0]['id_status_kegiatan'] == 1) {
            if (empty($cek_gabung_relawan) && empty($cek_donasi)) {
                $where   = array('id_kegiatan' => $hapus);
                $execute = $this->PPG_model->delete_data('kegiatan', $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menghapus Kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("PPG/mengelola_kegiatan");
                } else {
                    $pesan      = "Gagal Hapus Kegiatan. Silahkan Cek Kembali.";
                    $url_target = "PPG/mengelola_kegiatan";
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
            } elseif (!empty($cek_gabung_relawan) || !empty($cek_donasi)) {
                if ($status_kegiatan[0]['id_status_kegiatan'] == 1) {
                    //Start FCM Code
                    $title        = "Kegiatan " . $status_kegiatan[0]['nama_kegiatan'] . " Dibatalkan";
                    $body         = "Kegiatan telah dibatalkan. Untuk para donatur, donasi akan dikembalikan sesuai dengan nominal transfer ke no.rekening sesuai struk transfer.";
                    $message      = "null";
                    $message_type = "kegiatan";
                    $intent       = "NotificationFragment";
                    $id_target    = "null";
                    $date_rcv     = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                    // $data        = $this->PPG_model->get_all_user();
                    $data = $this->PPG_model->get_subs_all_user("k.id_kegiatan = $hapus");
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
                }
                $update_kegiatan = array(
                    'id_status_kegiatan' => 0,
                );
                $where   = array('id_kegiatan' => $hapus);
                $execute = $this->PPG_model->update_data('kegiatan', $update_kegiatan, $where);
                if ($execute >= 1) {
                    $pesan  = "Sukses Menghapus Kegiatan (Data Kegiatan Dialihkan Ke Menu Arsip)";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    redirect("PPG/mengelola_kegiatan");
                } else {
                    $pesan      = "Gagal Hapus Kegiatan. Silahkan Cek Kembali.";
                    $url_target = "PPG/mengelola_kegiatan";
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
            $url_target = "PPG/mengelola_kegiatan";
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

    public function detail_kegiatan()
    {
        $kegiatan = $this->input->post("kegiatan");
        if ($kegiatan != "") {
            $detail_kegiatan = $this->PPG_model->get_detail_kegiatan("where k.id_kegiatan = $kegiatan");
            $jumlah_relawan  = $this->PPG_model->get_jumlah_relawan("where k.id_kegiatan = $kegiatan");
            $jumlah_donasi   = $this->PPG_model->get_jumlah_donasi("and k.id_kegiatan = $kegiatan");
            $dokumentasi     = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $kegiatan");

            //Start Map
            // $center = $detail_kegiatan[0]['lat'] . "," . $detail_kegiatan[0]['lng'];
            // $this->def_lat = $detail_kegiatan[0]['lat'];
            // $this->def_lng = $detail_kegiatan[0]['lng'];
            // $center        = $this->def_lat . "," . $this->def_lng;
            // $cfg           = array(
            //     'class'                       => 'map-canvas',
            //     'map_div_id'                  => 'map-canvas',
            //     'center'                      => $center,
            //     'zoom'                        => 17,
            //     'places'                      => true, //Aktifkan pencarian alamat
            //     'placesAutocompleteInputID'   => 'cari', //set sumber pencarian input
            //     'placesAutocompleteBoundsMap' => true,
            //     'placesAutocompleteOnChange'  => 'showmap();', //Aksi ketika pencarian dipilih
            // );
            // $this->googlemaps->initialize($cfg);

            // $marker = array(
            //     'position'  => $center,
            //     'draggable' => false,
            //     'title'     => 'Coba diDrag',
            //     'ondragend' => "document.getElementById('lat').value = event.latLng.lat();
            //                 document.getElementById('lng').value = event.latLng.lng();
            //                 showmap();",
            // );
            // $this->googlemaps->add_marker($marker);

            // $d['map'] = $this->googlemaps->create_map();
            // $d['lat'] = $this->def_lat;
            // $d['lng'] = $this->def_lng;

            $this->def_lat = $detail_kegiatan[0]['lat'];
            $this->def_lng = $detail_kegiatan[0]['lng'];
            $center        = $this->def_lat . "," . $this->def_lng;
            $cfg           = array(
                'class'                       => 'map-canvas',
                'map_div_id'                  => 'map-canvas',
                'center'                      => $center,
                'zoom'                        => 17,
                'places'                      => true, //Aktifkan pencarian alamat
                'placesAutocompleteInputID'   => 'cari', //set sumber pencarian input
                'placesAutocompleteBoundsMap' => true,
                'placesAutocompleteOnChange'  => 'showmap();', //Aksi ketika pencarian dipilih
            );
            $this->googlemaps->initialize($cfg);
            $target = "PPG/detail_kegiatan";
            $marker = array(
                'position'  => $detail_kegiatan[0]['lat'] . "," . $detail_kegiatan[0]['lng'],
                'animation' => 'DROP',
                'draggable' => false,
                'ondragend' => "document.getElementById('lat').value = event.latLng.lat();
                            document.getElementById('lng').value = event.latLng.lng();
                            showmap();",
            );
            $this->googlemaps->add_marker($marker);
            $d['map'] = $this->googlemaps->create_map();

            //End Map

            // $this->load->view("ppg/v_detail_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'jumlah_relawan' => $jumlah_relawan, 'jumlah_donasi' => $jumlah_donasi, 'dokumentasi' => $dokumentasi, 'd' => $d));
            $this->hasil_analisis_kegiatan($kegiatan);
            if ($detail_kegiatan[0]['id_status_kegiatan'] == 3 && $this->hasil_rating_relawan != 0 && $this->hasil_rating_donatur) {
                $this->load->view("ppg/v_detail_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'jumlah_relawan' => $jumlah_relawan, 'jumlah_donasi' => $jumlah_donasi, 'dokumentasi' => $dokumentasi, 'd' => $d, 'persentase_kehadiran' => $this->persentase_kehadiran, 'jml_relawan' => $this->jml_relawan, 'jml_relawan_hadir' => $this->jml_relawan_hadir, 'persentase_donasi' => $this->persentase_donasi, 'persentase_rating_relawan' => $this->persentase_rating_relawan, 'persentase_rating_donatur' => $this->persentase_rating_donatur, 'hasil_rating_relawan' => $this->hasil_rating_relawan, 'hasil_rating_donatur' => $this->hasil_rating_donatur, 'hasil_analisis' => $this->hasil_analisis, 'kesimpulan' => $this->kesimpulan, 'persentase_gabung_relawan' => $this->persentase_gabung_relawan));
                // } elseif ($detail_kegiatan[0]['id_status_kegiatan'] != 3) {
            } else {
                $this->load->view("ppg/v_detail_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'jumlah_relawan' => $jumlah_relawan, 'jumlah_donasi' => $jumlah_donasi, 'dokumentasi' => $dokumentasi, 'hasil_rating_relawan' => 0, 'hasil_rating_donatur' => 0, 'd' => $d));
            }
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "PPG/mengelola_kegiatan";
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

    public function tambah_dokumentasi_kegiatan()
    {
        $dokumen          = $this->input->post("dokumentasi");
        $id_kegiatan      = $this->input->post("id_kegiatan");
        $nama_dokumentasi = $this->input->post("nama_dokumentasi");
        $deskripsi        = $this->input->post("deskripsi");
        $tanggal          = $this->input->post("tanggal");

        // echo $dokumen."<br>";
        // echo $id_kegiatan."<br>";
        // echo $deskripsi."<br>";
        // echo $tanggal."<br>";

        if ($dokumen != "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $check_status_kegiatan = $this->PPG_model->get_kegiatan("where k.id_kegiatan = $dokumen");
            if ($check_status_kegiatan[0]['id_status_kegiatan'] > 1) {
                $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $dokumen");
                $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $dokumen, 'kegiatan' => $check_status_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Tidak Bisa Menambah Dokumentasi Karena Kegiatan Masih Dalam Promosi Kegiatan.";
                $url_target = "PPG/mengelola_kegiatan";
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
        } else if ($this->session->flashdata('dokumentasi')) {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $doc                   = $this->session->flashdata('dokumentasi');
            $check_status_kegiatan = $this->PPG_model->get_kegiatan("where k.id_kegiatan = $doc[dokumentasi]");
            if ($check_status_kegiatan[0]['id_status_kegiatan'] > 1) {
                $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $doc[dokumentasi]");
                $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $doc['dokumentasi'], 'kegiatan' => $check_status_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Tidak Bisa Menambah Dokumentasi Karena Kegiatan Masih Dalam Promosi Kegiatan.";
                $url_target = "PPG/mengelola_kegiatan";
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
        } else if ($id_kegiatan != "" && $deskripsi != "" && $tanggal != "" && $nama_dokumentasi != "") {
            $config['upload_path']   = './uploads/dokumentasi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";

                $pesan      = "Gagal Menambah Dokumentasi. Pastiakan Anda Yang Anda Unggah Adalah Foto/Gambar.";
                $url_target = "PPG/mengelola_kegiatan";
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
            } else {
                $data               = array('upload_data' => $this->upload->data());
                $tambah_dokumentasi = array(
                    'nama_dokumentasi'   => $nama_dokumentasi,
                    'deskripsi'          => $deskripsi,
                    'tanggal'            => $tanggal,
                    'id_kegiatan'        => $id_kegiatan,
                    'gambar_dokumentasi' => $this->upload->data('file_name'),
                );
                $execute = $this->PPG_model->insert_data('dokumentasi', $tambah_dokumentasi);
                if ($execute >= 1) {
                    $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");

                    //Start FCM Code
                    $get_id_kegiatan = $this->PPG_model->get_kegiatan("where id_kegiatan = '$id_kegiatan'");
                    $title           = "Dokumentasi Baru " . $get_id_kegiatan[0]['nama_kegiatan'];
                    $body            = $nama_dokumentasi;
                    $message         = "null";
                    $message_type    = "dokumentasi";
                    // $intent          = "DetailKegiatanDiikutiActivity";
                    $intent    = "DokumentasiActivity";
                    $id_target = $get_id_kegiatan[0]['id_kegiatan'];
                    $date_rcv  = date("Y-m-d");

                    $path_to_fcm = "http://fcm.googleapis.com/fcm/send";
                    $server_key  = "AAAAePlAp50:APA91bH6EsjQE1M3XszHIahm50NRB2HSSz-jrfrxJZooRakGgaF0RvH0zLeHU6x7dhrnn8EpWTxIIUDqRxoH8X1FzmzBCmMvAmA0JujfkGLmgR17jfDYY5wwQOLkQmgjhJlORNGrqk2s";
                    $data        = $this->PPG_model->get_subs_all_user("k.id_kegiatan = $id_kegiatan");
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

                    $pesan  = "Sukses Menambah Dokumentasi Kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    $dokumentasi = array('dokumentasi' => $id_kegiatan);
                    $this->session->set_flashdata('dokumentasi', $dokumentasi);
                    redirect("PPG/tambah_dokumentasi_kegiatan");

                    $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                    $this->load->view('footer');
                } else {
                    $pesan      = "Gagal Menambah Dokumentasi. Silahkan Cek Kembali.";
                    $url_target = "PPG/mengelola_kegiatan";
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
            $url_target = "PPG/mengelola_kegiatan";
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

    public function edit_dokumentasi_kegiatan()
    {
        $edit             = $this->input->post("edit");
        $id_dokumentasi   = $this->input->post("id_dokumentasi");
        $nama_dokumentasi = $this->input->post("nama_dokumentasi");
        $id_kegiatan      = $this->input->post("id_kegiatan");
        $deskripsi        = $this->input->post("deskripsi");
        $tanggal          = $this->input->post("tanggal");
        if ($edit != "") {
            $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_dokumentasi = $edit");
            $this->load->view("ppg/v_form_edit_dokumentasi", array('dokumentasi' => $dokumentasi));
            $this->load->view('footer');
        } elseif ($id_dokumentasi != "" && $id_kegiatan != "" && $deskripsi != "" && $tanggal != "" && $nama_dokumentasi != "") {
            $config['upload_path']   = './uploads/dokumentasi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $update_dokumentasi = array(
                    'nama_dokumentasi' => $nama_dokumentasi,
                    'deskripsi'        => $deskripsi,
                    'tanggal'          => $tanggal,
                    'id_kegiatan'      => $id_kegiatan,
                );
                $where   = array('id_dokumentasi' => $id_dokumentasi);
                $execute = $this->PPG_model->update_data('dokumentasi', $update_dokumentasi, $where);
                if ($execute >= 1) {
                    $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");

                    $pesan  = "Sukses Meng-edit Dokumentasi Kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    $dokumentasi = array('dokumentasi' => $id_kegiatan);
                    $this->session->set_flashdata('dokumentasi', $dokumentasi);
                    redirect("PPG/tambah_dokumentasi_kegiatan");

                    // $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                    // $this->load->view('footer');
                } else {
                    $pesan      = "Gagal Meng-edit Dokumentasi. Silahkan Cek Kembali.";
                    $url_target = "PPG/edit_dokumentasi_kegiatan";
                    $name       = "edit";
                    $value      = $id_dokumentasi;
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
                $update_dokumentasi = array(
                    'nama_dokumentasi'   => $nama_dokumentasi,
                    'deskripsi'          => $deskripsi,
                    'tanggal'            => $tanggal,
                    'id_kegiatan'        => $id_kegiatan,
                    'gambar_dokumentasi' => $this->upload->data('file_name'),
                );
                $where   = array('id_dokumentasi' => $id_dokumentasi);
                $execute = $this->PPG_model->update_data('dokumentasi', $update_dokumentasi, $where);
                if ($execute >= 1) {
                    $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");

                    //Start FCM Code
                    //End FCM Code

                    $pesan  = "Sukses Menambah Dokumentasi Kegiatan";
                    $sukses = array('pesan' => $pesan);
                    $this->session->set_flashdata('success_msg', $sukses);
                    $dokumentasi = array('dokumentasi' => $id_kegiatan);
                    $this->session->set_flashdata('dokumentasi', $dokumentasi);
                    redirect("PPG/tambah_dokumentasi_kegiatan");

                    // $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                    // $this->load->view('footer');
                } else {
                    $pesan      = "Gagal Meng-edit Dokumentasi. Silahkan Cek Kembali.";
                    $url_target = "PPG/edit_dokumentasi_kegiatan";
                    $name       = "edit";
                    $value      = $id_dokumentasi;
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
            $url_target = "PPG/mengelola_kegiatan";
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

    public function hapus_dokumentasi_kegiatan()
    {
        $hapus       = $this->input->post("hapus");
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($hapus != "") {
            $where   = array('id_dokumentasi' => $hapus);
            $execute = $this->PPG_model->delete_data('dokumentasi', $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Menghapus Dokumentasi Kegiatan";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                $dokumentasi = array('dokumentasi' => $id_kegiatan);
                $this->session->set_flashdata('dokumentasi', $dokumentasi);
                redirect("PPG/tambah_dokumentasi_kegiatan");

                // $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                // $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                // $this->load->view('footer');
            } else {
                $pesan      = "Gagal Hapus Dokumentasi. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_kegiatan";
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
            $url_target = "PPG/mengelola_kegiatan";
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

    public function mengelola_feedback()
    {
        $data_kegiatan = $this->PPG_model->get_data_feedback_kegiatan("where k.id_status_kegiatan = 3");
        $this->load->view("ppg/v_mengelola_feedback", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function feedback_kegiatan()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($id_kegiatan != "") {
            $feedback_relawan = $this->PPG_model->get_feedback_kegiatan_relawan("where k.id_kegiatan = $id_kegiatan");
            $feedback_donatur = $this->PPG_model->get_feedback_kegiatan_donatur("where k.id_kegiatan = $id_kegiatan");
            $this->load->view("ppg/v_list_feedback", array('feedback_relawan' => $feedback_relawan, 'feedback_donatur' => $feedback_donatur, 'id_kegiatan' => $id_kegiatan));
            $this->load->view('footer');
        } else {
            $pesan      = "Akses Link Secara Ilegal Terdeteksi, Silahkan Kembali.";
            $url_target = "PPG/mengelola_feedback";
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

    public function balas_feedback_relawan()
    {
        $balas                = $this->input->post("balas");
        $id_kegiatan          = $this->input->post("id_kegiatan");
        $id_feedback_kegiatan = $this->input->post("id_feedback_kegiatan");
        $email                = $this->input->post("email");
        $nama                 = $this->input->post("nama");
        $komentar             = $this->input->post("komentar");
        if ($balas != "") {
            $feedback       = $this->PPG_model->get_feedback_kegiatan_relawan("where id_feedback_kegiatan = $balas");
            $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan_relawan("where id_feedback_kegiatan = $balas");

            $data_baru = array();
            $i         = 0;
            foreach ($balas_feedback as $b) {
                if ($b['email'] == $this->session->userdata('email')) {
                    $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                    $data_baru[$i]['email']             = "admin@ttm.com";
                    $data_baru[$i]['nama']              = "Admin Turun Tangan Malang";
                    $data_baru[$i]['komentar']          = $b['komentar'];
                    $data_baru[$i]['tanggal']           = $b['tanggal'];
                } else {
                    $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                    $data_baru[$i]['email']             = $b['email'];
                    $data_baru[$i]['nama']              = $b['nama'];
                    $data_baru[$i]['komentar']          = $b['komentar'];
                    $data_baru[$i]['tanggal']           = $b['tanggal'];
                }
                $i++;
            }

            // for session
            $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
            $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
            // $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
            $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $data_baru, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
            $this->load->view('footer');
        } elseif ($id_feedback_kegiatan != "" && $email != "" && $nama != "" && $komentar != "") {
            $balas_komentar = array(
                'email'                => $email,
                'id_feedback_kegiatan' => $id_feedback_kegiatan,
                'komentar'             => $komentar,
                'tanggal'              => date("Y-m-d"),
            );
            $execute = $this->PPG_model->insert_data('balas_feedback_relawan', $balas_komentar);
            if ($execute >= 1) {
                $feedback       = $this->PPG_model->get_feedback_kegiatan_relawan("where id_feedback_kegiatan = $id_feedback_kegiatan");
                $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan_relawan("where id_feedback_kegiatan = $id_feedback_kegiatan");

                $data_baru = array();
                $i         = 0;
                foreach ($balas_feedback as $b) {
                    if ($b['email'] == $this->session->userdata('email')) {
                        $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                        $data_baru[$i]['email']             = "admin@ttm.com";
                        $data_baru[$i]['nama']              = "Admin Turun Tangan Malang";
                        $data_baru[$i]['komentar']          = $b['komentar'];
                        $data_baru[$i]['tanggal']           = $b['tanggal'];
                    } else {
                        $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                        $data_baru[$i]['email']             = $b['email'];
                        $data_baru[$i]['nama']              = $b['nama'];
                        $data_baru[$i]['komentar']          = $b['komentar'];
                        $data_baru[$i]['tanggal']           = $b['tanggal'];
                    }
                    $i++;
                }

                // for session
                $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
                $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
                // $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
                $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $data_baru, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Gagal Membalas Feedback. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_feedback";
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
            $url_target = "PPG/mengelola_feedback";
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

    public function balas_feedback_donatur()
    {
        $balas                = $this->input->post("balas");
        $id_kegiatan          = $this->input->post("id_kegiatan");
        $id_feedback_kegiatan = $this->input->post("id_feedback_kegiatan");
        $email                = $this->input->post("email");
        $nama                 = $this->input->post("nama");
        $komentar             = $this->input->post("komentar");
        if ($balas != "") {
            $feedback       = $this->PPG_model->get_feedback_kegiatan_donatur("where id_feedback_kegiatan = $balas");
            $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan_donatur("where id_feedback_kegiatan = $balas");

            $data_baru = array();
            $i         = 0;
            foreach ($balas_feedback as $b) {
                if ($b['email'] == $this->session->userdata('email')) {
                    $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                    $data_baru[$i]['email']             = "admin@ttm.com";
                    $data_baru[$i]['nama']              = "Admin Turun Tangan Malang";
                    $data_baru[$i]['komentar']          = $b['komentar'];
                    $data_baru[$i]['tanggal']           = $b['tanggal'];
                } else {
                    $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                    $data_baru[$i]['email']             = $b['email'];
                    $data_baru[$i]['nama']              = $b['nama'];
                    $data_baru[$i]['komentar']          = $b['komentar'];
                    $data_baru[$i]['tanggal']           = $b['tanggal'];
                }
                $i++;
            }

            // for session
            // $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
            // $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
            // $this->load->view("ppg/v_balas_feedback_donatur", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));

            // inject
            $email_admin = "admin@ttm.com";
            $nama_admin  = "Admin Turun Tangan Malang";
            $this->load->view("ppg/v_balas_feedback_donatur", array('feedback' => $feedback, 'balas_feedback' => $data_baru, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
            $this->load->view('footer');
        } elseif ($id_feedback_kegiatan != "" && $email != "" && $nama != "" && $komentar != "") {
            $balas_komentar = array(
                'email'                => $email,
                'id_feedback_kegiatan' => $id_feedback_kegiatan,
                'komentar'             => $komentar,
                'tanggal'              => date("Y-m-d"),
            );
            $execute = $this->PPG_model->insert_data('balas_feedback_donatur', $balas_komentar);
            if ($execute >= 1) {
                $feedback       = $this->PPG_model->get_feedback_kegiatan_donatur("where id_feedback_kegiatan = $id_feedback_kegiatan");
                $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan_donatur("where id_feedback_kegiatan = $id_feedback_kegiatan");

                // $data_baru = array();
                // $i         = 0;
                // foreach ($balas_feedback as $b) {
                //     if ($b['email'] == $this->session->userdata('email')) {
                //         $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                //         $data_baru[$i]['email']             = "admin@ttm.com";
                //         $data_baru[$i]['nama']              = "Admin Turun Tangan Malang";
                //         $data_baru[$i]['komentar']          = $b['komentar'];
                //         $data_baru[$i]['tanggal']           = $b['tanggal'];
                //     } else {
                //         $data_baru[$i]['id_balas_feedback'] = $b['id_balas_feedback'];
                //         $data_baru[$i]['email']             = $b['email'];
                //         $data_baru[$i]['nama']              = $b['nama'];
                //         $data_baru[$i]['komentar']          = $b['komentar'];
                //         $data_baru[$i]['tanggal']           = $b['tanggal'];
                //     }
                //     $i++;
                // }

                // for session
                // $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
                // $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
                // $this->load->view("ppg/v_balas_feedback_donatur", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));

                // inject
                $email_admin = "admin@ttm.com";
                $nama_admin  = "Admin Turun Tangan Malang";
                $this->load->view("ppg/v_balas_feedback_donatur", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
                $this->load->view('footer');
            } else {
                $pesan      = "Gagal Membalas Feedback. Silahkan Cek Kembali.";
                $url_target = "PPG/mengelola_feedback";
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
            $url_target = "PPG/mengelola_feedback";
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
    public function mengelola_arsip_kegiatan()
    {
        $data_kegiatan = $this->PPG_model->get_kegiatan("where k.id_status_kegiatan = 0");
        $this->load->view("ppg/v_mengelola_arsip_kegiatan", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function restore_data_kegiatan()
    {
        $arsip                = $this->input->post("arsip");
        $cek_gabung_relawan   = $this->PPG_model->get_cek_gabung_relawan("where id_kegiatan = $arsip");
        $cek_donasi           = $this->PPG_model->get_cek_donasi("where id_kegiatan = $arsip");
        $cek_dokumentasi      = $this->PPG_model->get_cek_dokumentasi("where id_kegiatan = $arsip");
        $cek_feedback_relawan = $this->PPG_model->get_cek_feeback_relawan("where id_kegiatan = $arsip");
        $cek_feedback_donatur = $this->PPG_model->get_cek_feeback_donatur("where id_kegiatan = $arsip");
        if ($arsip != "") {
            if ((!empty($cek_gabung_relawan) || !empty($cek_donasi)) && empty($cek_dokumentasi) && (empty($cek_feedback_relawan) && empty($cek_feedback_donatur))) {
                $update_kegiatan = array(
                    'id_status_kegiatan' => 1,
                );
                $where = array('id_kegiatan' => $arsip);
            } elseif ((!empty($cek_gabung_relawan) || !empty($cek_donasi)) && !empty($cek_dokumentasi) && (empty($cek_feedback_relawan) || empty($cek_feedback_donatur))) {
                $update_kegiatan = array(
                    'id_status_kegiatan' => 2,
                );
                $where = array('id_kegiatan' => $arsip);
            } elseif ((!empty($cek_gabung_relawan) || !empty($cek_donasi)) && !empty($cek_dokumentasi) && (!empty($cek_feedback_relawan) || !empty($cek_feedback_donatur))) {
                $update_kegiatan = array(
                    'id_status_kegiatan' => 3,
                );
                $where = array('id_kegiatan' => $arsip);
            } elseif ((!empty($cek_gabung_relawan) || !empty($cek_donasi)) && empty($cek_dokumentasi) && (!empty($cek_feedback_relawan) || !empty($cek_feedback_donatur))) {
                $update_kegiatan = array(
                    'id_status_kegiatan' => 3,
                );
                $where = array('id_kegiatan' => $arsip);
            }
            $execute = $this->PPG_model->update_data('kegiatan', $update_kegiatan, $where);
            if ($execute >= 1) {
                $pesan  = "Sukses Mengembalikan Data Kegiatan. Silahkan Ubah Status Kegiatan Sesuai Dengan Status Kegiatan Sebelumnya (Jika Data Salah).";
                $sukses = array('pesan' => $pesan);
                $this->session->set_flashdata('success_msg', $sukses);
                redirect("PPG/mengelola_kegiatan");
            } else {
                $pesan      = "Gagal Mengembalikan Data Dokumentasi. Silahkan Coba Kembali.";
                $url_target = "PPG/edit_dokumentasi_kegiatan";
                $name       = "edit";
                $value      = $id_dokumentasi;
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
            $url_target = "PPG/mengelola_arsip_kegiatan";
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
    public function hasil_analisis_kegiatan($id_kegiatan = "")
    {
        $point                = 0;
        $this->hasil_analisis = "<b>Hasil evaluasi dari sistem:</b><br>";

        $detail_kegiatan      = $this->PPG_model->get_detail_kegiatan("where k.id_kegiatan = $id_kegiatan");
        $jumlah_relawan       = $this->PPG_model->get_jumlah_relawan("where k.id_kegiatan = $id_kegiatan");
        $jumlah_relawan_hadir = $this->PPG_model->get_jumlah_relawan("where k.id_kegiatan = $id_kegiatan and gk.id_status_absensi_relawan = 2");
        $rating_feedback      = $this->PPG_model->get_data_feedback_kegiatan("where k.id_kegiatan = $id_kegiatan");
        $jumlah_donasi        = $this->PPG_model->get_jumlah_donasi("and k.id_kegiatan = $id_kegiatan");

        // Hitung Kontribusi Relawan TTM
        $this->persentase_gabung_relawan = ($jumlah_relawan[0]['jumlah_relawan'] / $detail_kegiatan[0]['minimal_relawan']) * 100;
        // if ($jumlah_relawan[0]['jumlah_relawan'] < $detail_kegiatan[0]['minimal_relawan']) {
        if ($this->persentase_gabung_relawan < 70) {
            $point                = $point + 1;
            $this->hasil_analisis = $this->hasil_analisis . "Kontibusi relawan tergolong <u>kurang</u>";
        } elseif ($this->persentase_gabung_relawan >= 70 && $this->persentase_gabung_relawan < 90) {
            $point                = $point + 2;
            $this->hasil_analisis = $this->hasil_analisis . "Kontibusi relawan tergolong <u>baik</u>";
        } elseif ($this->persentase_gabung_relawan >= 90) {
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . "Kontibusi relawan tergolong <u>sangat baik</u>/Antusias relawan terhadap kegiatan tinggi";
        }

        // Hitung Persentase Relawan Yang Hadir
        if ($jumlah_relawan[0]['jumlah_relawan'] == 0) {
            $this->persentase_kehadiran = 0;
        } elseif (empty($jumlah_relawan_hadir[0]['jumlah_relawan'])) {
            $this->persentase_kehadiran = 0;
        } elseif (!empty($jumlah_relawan_hadir[0]['jumlah_relawan']) || $jumlah_relawan_hadir[0]['jumlah_relawan'] > 0) {
            $this->persentase_kehadiran = ($jumlah_relawan_hadir[0]['jumlah_relawan'] / $jumlah_relawan[0]['jumlah_relawan']) * 100;
        }
        if ($this->persentase_kehadiran >= 80) {
            if ($point == 1) {
                $this->hasil_analisis = $this->hasil_analisis . ", namun ";
            } elseif ($point >= 2) {
                $this->hasil_analisis = $this->hasil_analisis . ", ";
            }
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . "mayoritas relawan yang bergabung hadir dalam kegiatan.";
        } elseif ($this->persentase_kehadiran >= 50 && $this->persentase_kehadiran < 80) {
            $point                = $point + 2;
            $this->hasil_analisis = $this->hasil_analisis . ", rata-rata relawan yang bergabung hadir dalam kegiatan.";
        } elseif ($this->persentase_kehadiran < 50) {
            if ($point == 3) {
                $this->hasil_analisis = $this->hasil_analisis . ", namun";
            } elseif ($point <= 2) {
                $this->hasil_analisis = $this->hasil_analisis . ", ";
            }
            $point                = $point + 1;
            $this->hasil_analisis = $this->hasil_analisis . ", kurang dari setengah relawan yang bergabung hadir dalam kegiatan.";
        }

        // Hitung Rating dan Persentase Feedback Relawan
        $this->hasil_rating_relawan = $rating_feedback[0]['rating_relawan'];
        if ($this->hasil_rating_relawan >= 4) {
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Berdasarkan hasil <i>feedback</i> dari relawan didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_relawan'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa <u>kegiatan berjalan dengan baik dan mendapat respon yang positif dari para relawan.</u>";
        } elseif ($this->hasil_rating_relawan >= 3 && $this->hasil_rating_relawan < 4) {
            $point                = $point + 2;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Berdasarkan hasil <i>feedback</i> dari relawan didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_relawan'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa <u>kegiatan berjalan dengan cukup baik dan mendapat respon yang cukup positif dari para relawan</u>. Diperlukan evaluasi sehingga dikegiatan berikutnya dapat berjalan lebih baik.";
        } elseif ($this->hasil_rating_relawan < 3) {
            $point                = $point + 1;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Berdasarkan hasil <i>feedback</i> dari relawan didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_relawan'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa <u>kegiatan berjalan kurang baik dan mendapat respon yang kurang positif dari para relawan</u>. <b>Diperlukan evaluasi lebih lanjut dalam rapat besar berikutnya.</b>";
        }

        // Hitung Rating dan Persentase Feedback Donatur
        $this->hasil_rating_donatur = $rating_feedback[0]['rating_donatur'];
        if ($this->hasil_rating_donatur >= 4) {
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . " Berdasarkan hasil <i>feedback</i> dari donatur juga didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_donatur'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa menurut para donatur, <u>kegiatan tersebut berjalan dengan baik dan mayoritas donatur memberi respon yang positif</u> terhadap kegiatan yang telah dilaksanakan.";
        } elseif ($this->hasil_rating_donatur >= 3 && $this->hasil_rating_donatur < 4) {
            $point                = $point + 2;
            $this->hasil_analisis = $this->hasil_analisis . " Berdasarkan hasil <i>feedback</i> dari donatur juga didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_donatur'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa menurut para donatur, <u>kegiatan tersebut berjalan dengan cukup baik dan mayoritas donatur memberi respon yang cukup positif</u> terhadap kegiatan yang telah dilaksanakan.";
        } elseif ($this->hasil_rating_donatur < 3) {
            $point                = $point + 1;
            $this->hasil_analisis = $this->hasil_analisis . " Berdasarkan hasil <i>feedback</i> dari donatur juga didapatkan hasil <u>" . number_format((float) $rating_feedback[0]['rating_donatur'], 2, '.', '') . "</u> dimana dapat disimpulkan bahwa menurut para donatur, <u>kegiatan tersebut berjalan kurang baik dan mayoritas donatur memberi respon yang kurang positif</u> terhadap kegiatan yang telah dilaksanakan.";
        }

        // Hitung Persentase Donasi
        if (empty($jumlah_donasi[0]['jumlah_donasi'])) {
            $this->persentase_donasi = 0;
        } elseif (!empty($jumlah_donasi[0]['jumlah_donasi']) || $jumlah_donasi[0]['jumlah_donasi'] > 0) {
            $this->persentase_donasi = ($jumlah_donasi[0]['jumlah_donasi'] / $detail_kegiatan[0]['minimal_donasi']) * 100;
        }
        if ($this->persentase_donasi > 100) {
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Dari segi penggalangan dana, hasil donasi yang diberikan oleh para donatur <u>lebih dari cukup</u> untuk mendanai pelaksanaan kegiatan.";
        } elseif ($this->persentase_donasi >= 80 && $this->persentase_donasi <= 100) {
            $point                = $point + 3;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Dari segi penggalangan dana, hasil donasi yang diberikan oleh para donatur <u>sangat cukup</u> untuk mendanai pelaksanaan kegiatan.";
        } elseif ($this->persentase_donasi >= 50 && $this->persentase_donasi < 80) {
            $point                = $point + 2;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Dari segi penggalangan dana, hasil donasi yang diberikan oleh para donatur <u>cukup</u> untuk mendanai pelaksanaan kegiatan.";
        } elseif ($this->persentase_donasi < 50) {
            $point                = $point + 1;
            $this->hasil_analisis = $this->hasil_analisis . "<br>Dari segi penggalangan dana, hasil donasi yang diberikan oleh para donatur <u>kurang cukup</u> untuk mendanai pelaksanaan kegiatan.";
        }

        // Kesimpulan :)
        $hasil = $point / 5;
        if ($hasil >= 2.5) {
            $this->kesimpulan = "Hasil Penilaian Kegiatan: <b>Baik.</b>";
        } elseif ($hasil >= 2.0) {
            $this->kesimpulan = "Hasil Penilaian Kegiatan: <b>Cukup Baik.</b>";
        } elseif ($hasil < 2.0) {
            $this->kesimpulan = "Hasil Penilaian Kegiatan: <b>Kurang Baik.</b>";
        }

        // $this->hasil_rating_relawan      = $rating_feedback[0]['rating_relawan'];
        // $this->hasil_rating_donatur      = $rating_feedback[0]['rating_donatur'];
        $this->persentase_rating_relawan = ($this->hasil_rating_relawan / 5) * 100;
        $this->persentase_rating_donatur = ($this->hasil_rating_donatur / 5) * 100;
        $this->jml_relawan               = $jumlah_relawan[0]['jumlah_relawan'];
        if (empty($jumlah_relawan_hadir[0]['jumlah_relawan'])) {
            $this->jml_relawan_hadir = 0;
        } elseif (!empty($jumlah_relawan_hadir[0]['jumlah_relawan']) || $jumlah_relawan_hadir[0]['jumlah_relawan'] > 0) {
            $this->jml_relawan_hadir = $jumlah_relawan_hadir[0]['jumlah_relawan'];
        }

        // echo $this->kesimpulan . "<br>";
        // echo $this->hasil_analisis . "<br>";
        // echo $point;
    }
}
