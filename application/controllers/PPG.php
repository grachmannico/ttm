<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PPG extends CI_Controller
{
    private $def_lat;
    private $def_lng;

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
        $this->load->view("ppg/dashboard_ppg");
        $this->load->view('footer');
    }

    public function mengelola_kegiatan()
    {
        $id_status_kegiatan = $this->input->post("id_status_kegiatan");
        if ($id_status_kegiatan == "") {
            if ($this->session->flashdata('success_msg')) {
                $this->load->view("success", array('success' => $this->session->flashdata('success_msg')));
            }
            $data_kegiatan = $this->PPG_model->get_kegiatan();
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        } elseif ($id_status_kegiatan != "") {
            $data_kegiatan = $this->PPG_model->get_kegiatan("where k.id_status_kegiatan = $id_status_kegiatan");
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        }
    }

    public function tambah_kegiatan()
    {
        $nama_kegiatan           = $this->input->post("nama_kegiatan");
        $id_status_kegiatan      = $this->input->post("id_status_kegiatan");
        $pesan_ajakan            = $this->input->post("pesan_ajakan");
        $deskripsi_kegiatan      = $this->input->post("deskripsi_kegiatan");
        $minimal_relawan         = $this->input->post("minimal_relawan");
        $minimal_donasi          = $this->input->post("minimal_donasi");
        $tanggal_kegiatan        = $this->input->post("tanggal_kegiatan");
        $batas_akhir_pendaftaran = $this->input->post("batas_akhir_pendaftaran");
        $alamat                  = $this->input->post("alamat");
        $lat                     = $this->input->post("lat");
        $lng                     = $this->input->post("lng");

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

        if ($nama_kegiatan == "" && $id_status_kegiatan == "" && $pesan_ajakan == "" && $deskripsi_kegiatan == "" && $minimal_relawan == "" && $minimal_donasi == "" && $tanggal_kegiatan == "" && $batas_akhir_pendaftaran == "" && $alamat == "" && $lat == "" && $lng == "") {
            $this->load->view("ppg/v_form_tambah_kegiatan", $d);
            $this->load->view('footer');
        } elseif ($nama_kegiatan != "" && $id_status_kegiatan != "" && $pesan_ajakan != "" && $deskripsi_kegiatan != "" && $minimal_relawan != "" && $minimal_donasi != "" && $tanggal_kegiatan != "" && $batas_akhir_pendaftaran != "" && $alamat != "" && $lat != "" && $lng != "") {
            $config['upload_path']   = './uploads/gambar_kegiatan/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('banner')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $tambah_kegiatan = array(
                    'nama_kegiatan'           => $nama_kegiatan,
                    'id_status_kegiatan'      => $id_status_kegiatan,
                    'pesan_ajakan'            => $pesan_ajakan,
                    'deskripsi_kegiatan'      => $deskripsi_kegiatan,
                    'minimal_relawan'         => $minimal_relawan,
                    'minimal_donasi'          => $minimal_donasi,
                    'tanggal_kegiatan'        => $tanggal_kegiatan,
                    'batas_akhir_pendaftaran' => $batas_akhir_pendaftaran,
                    'alamat'                  => $alamat,
                    'lat'                     => $lat,
                    'lng'                     => $lng,
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
            } else {
                $data            = array('upload_data' => $this->upload->data());
                $tambah_kegiatan = array(
                    'nama_kegiatan'           => $nama_kegiatan,
                    'id_status_kegiatan'      => $id_status_kegiatan,
                    'pesan_ajakan'            => $pesan_ajakan,
                    'deskripsi_kegiatan'      => $deskripsi_kegiatan,
                    'minimal_relawan'         => $minimal_relawan,
                    'minimal_donasi'          => $minimal_donasi,
                    'tanggal_kegiatan'        => $tanggal_kegiatan,
                    'batas_akhir_pendaftaran' => $batas_akhir_pendaftaran,
                    'alamat'                  => $alamat,
                    'lat'                     => $lat,
                    'lng'                     => $lng,
                    'banner'                  => $this->upload->data('file_name'),
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
        $edit                    = $this->input->post("edit");
        $id_kegiatan             = $this->input->post("id_kegiatan");
        $nama_kegiatan           = $this->input->post("nama_kegiatan");
        $id_status_kegiatan      = $this->input->post("id_status_kegiatan");
        $pesan_ajakan            = $this->input->post("pesan_ajakan");
        $deskripsi_kegiatan      = $this->input->post("deskripsi_kegiatan");
        $minimal_relawan         = $this->input->post("minimal_relawan");
        $minimal_donasi          = $this->input->post("minimal_donasi");
        $tanggal_kegiatan        = $this->input->post("tanggal_kegiatan");
        $batas_akhir_pendaftaran = $this->input->post("batas_akhir_pendaftaran");
        $alamat                  = $this->input->post("alamat");
        $lat                     = $this->input->post("lat");
        $lng                     = $this->input->post("lng");
        if ($edit != "") {
            $detail_kegiatan = $this->PPG_model->get_detail_kegiatan("where id_kegiatan = $edit");

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
            $this->load->view("ppg/v_form_edit_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'd' => $d));
            $this->load->view('footer');
        } elseif ($id_kegiatan != "" && $nama_kegiatan != "" && $id_status_kegiatan != "" && $pesan_ajakan != "" && $deskripsi_kegiatan != "" && $minimal_relawan != "" && $minimal_donasi != "" && $tanggal_kegiatan != "" && $batas_akhir_pendaftaran != "" && $alamat != "" && $lat != "" && $lng != "") {
            $config['upload_path']   = './uploads/gambar_kegiatan/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('banner')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $update_kegiatan = array(
                    'nama_kegiatan'           => $nama_kegiatan,
                    'id_status_kegiatan'      => $id_status_kegiatan,
                    'pesan_ajakan'            => $pesan_ajakan,
                    'deskripsi_kegiatan'      => $deskripsi_kegiatan,
                    'minimal_relawan'         => $minimal_relawan,
                    'minimal_donasi'          => $minimal_donasi,
                    'tanggal_kegiatan'        => $tanggal_kegiatan,
                    'batas_akhir_pendaftaran' => $batas_akhir_pendaftaran,
                    'alamat'                  => $alamat,
                    'lat'                     => $lat,
                    'lng'                     => $lng,
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
            } else {
                $data            = array('upload_data' => $this->upload->data());
                $update_kegiatan = array(
                    'nama_kegiatan'           => $nama_kegiatan,
                    'id_status_kegiatan'      => $id_status_kegiatan,
                    'pesan_ajakan'            => $pesan_ajakan,
                    'deskripsi_kegiatan'      => $deskripsi_kegiatan,
                    'minimal_relawan'         => $minimal_relawan,
                    'minimal_donasi'          => $minimal_donasi,
                    'tanggal_kegiatan'        => $tanggal_kegiatan,
                    'batas_akhir_pendaftaran' => $batas_akhir_pendaftaran,
                    'alamat'                  => $alamat,
                    'lat'                     => $lat,
                    'lng'                     => $lng,
                    'banner'                  => $this->upload->data('file_name'),
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
                'draggable' => false,
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

            $this->load->view("ppg/v_detail_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'jumlah_relawan' => $jumlah_relawan, 'jumlah_donasi' => $jumlah_donasi, 'dokumentasi' => $dokumentasi, 'd' => $d));
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

                    //Start FCM Code
                    //End FCM Code

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
            // for session
            $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
            $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
            $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
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
                // for session
                $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
                $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
                $this->load->view("ppg/v_balas_feedback_relawan", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
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
            // for session
            $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
            $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
            $this->load->view("ppg/v_balas_feedback_donatur", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $balas, 'email' => $email_admin, 'nama' => $nama_admin, 'id_kegiatan' => $id_kegiatan));
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
                // for session
                $email_admin = $this->session->userdata('email'); //"kuthu@gmail.com";
                $nama_admin  = $this->session->userdata('nama'); //"si kuthu";
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
}
