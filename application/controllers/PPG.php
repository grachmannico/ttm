<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PPG extends CI_Controller
{
    private $def_lat;
    private $def_lng;

    public function __construct()
    {
        parent::__construct();
        //map config
        $this->load->helper(array('form', 'url'));
        $this->load->config('map');
        $this->def_lat = $this->config->item('default_lat');
        $this->def_lng = $this->config->item('default_lng');
        $this->load->library('googlemaps');

        $this->load->view('header');
        $this->load->view('ppg/sidebar-ppg');
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
            $data_kegiatan = $this->PPG_model->get_kegiatan();
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        } elseif ($id_status_kegiatan == 1) {
            $data_kegiatan = $this->PPG_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        } elseif ($id_status_kegiatan == 2) {
            $data_kegiatan = $this->PPG_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
            $this->load->view("ppg/v_mengelola_kegiatan", array('data_kegiatan' => $data_kegiatan));
            $this->load->view('footer');
        } elseif ($id_status_kegiatan == 3) {
            $data_kegiatan = $this->PPG_model->get_kegiatan("where id_status_kegiatan = $id_status_kegiatan");
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
                    if ($id_status_kegiatan == 1) {
                        $get_id_kegiatan = $this->PPG_model->get_kegiatan("where nama_kegiatan = '$nama_kegiatan'");

                        //fcm
                        // $title        = "Kegiatan Baru: " . $nama_kegiatan;
                        // $body         = $pesan_ajakan;
                        // $message      = "null";
                        // $message_type = "kegiatan";
                        // $intent       = "DetailKegiatanActivity";
                        // $id_target    = $get_id_kegiatan[0]['id_kegiatan'];
                        // $date_rcv     = date("Y-m-d");

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
                                'title'       => "Kegiatan Baru: " . $nama_kegiatan,
                                'body'        => $pesan_ajakan,
                                'message'     => "null",
                                'messagetype' => "kegiatan",
                                'intent'      => "DetailKegiatanActivity",
                                'idtarget'    => $get_id_kegiatan[0]['id_kegiatan'],
                                'datercv'     => date("Y-m-d"),
                            ),
                        );
                        // print_r($fields);

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

                        // redirect("PPG/mengelola_kegiatan");
                    } elseif ($id_status_kegiatan == 2) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                        $this->load->view('footer');
                    } elseif ($id_status_kegiatan == 3) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi));
                        $this->load->view('footer');
                    }
                } else {
                    echo "gagal";
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
                    if ($id_status_kegiatan == 1) {
                        redirect("PPG/mengelola_kegiatan");
                    } elseif ($id_status_kegiatan == 2) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                        $this->load->view('footer');
                    } elseif ($id_status_kegiatan == 3) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi));
                        $this->load->view('footer');
                    }
                } else {
                    echo "gagal";
                }
            }
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
        // $banner                  = $this->input->post("banner");
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
                    if ($id_status_kegiatan == 1) {
                        redirect("PPG/mengelola_kegiatan");
                    } elseif ($id_status_kegiatan == 2) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                        $this->load->view('footer');
                    } elseif ($id_status_kegiatan == 3) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi));
                        $this->load->view('footer');
                    }
                } else {
                    echo "gagal";
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
                    if ($id_status_kegiatan == 1) {
                        redirect("PPG/mengelola_kegiatan");
                    } elseif ($id_status_kegiatan == 2) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                        $this->load->view('footer');
                    } elseif ($id_status_kegiatan == 3) {
                        $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                        $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi));
                        $this->load->view('footer');
                    }
                } else {
                    echo "gagal";
                }
            }
        }
    }

    public function hapus_kegiatan()
    {
        $hapus   = $this->input->post("hapus");
        $where   = array('id_kegiatan' => $hapus);
        $execute = $this->PPG_model->delete_data('kegiatan', $where);
        if ($execute >= 1) {
            redirect("PPG/mengelola_kegiatan");
        } else {
            echo "gagal";
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
            $this->load->view("ppg/v_detail_kegiatan", array('detail_kegiatan' => $detail_kegiatan, 'jumlah_relawan' => $jumlah_relawan, 'jumlah_donasi' => $jumlah_donasi, 'dokumentasi' => $dokumentasi));
            $this->load->view('footer');
        }
    }

    public function tambah_dokumentasi_kegiatan()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        $deskripsi   = $this->input->post("deskripsi");
        $tanggal     = $this->input->post("tanggal");

        $config['upload_path']   = './uploads/dokumentasi/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $error = array('error' => $this->upload->display_errors());
            echo "error";
        } else {
            $data               = array('upload_data' => $this->upload->data());
            $tambah_dokumentasi = array(
                'deskripsi'       => $deskripsi,
                'tanggal'         => $tanggal,
                'id_kegiatan'     => $id_kegiatan,
                'gambar_kegiatan' => $this->upload->data('file_name'),
            );
            $execute = $this->PPG_model->insert_data('gambar_kegiatan', $tambah_dokumentasi);
            if ($execute >= 1) {
                $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                $this->load->view('footer');
            } else {
                echo "gagal";
            }
        }
    }

    public function edit_dokumentasi_kegiatan()
    {
        $edit               = $this->input->post("edit");
        $id_gambar_kegiatan = $this->input->post("id_gambar_kegiatan");
        $id_kegiatan        = $this->input->post("id_kegiatan");
        $deskripsi          = $this->input->post("deskripsi");
        $tanggal            = $this->input->post("tanggal");
        if ($edit != "") {
            $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_gambar_kegiatan = $edit");
            // print_r($dokumentasi);
            $this->load->view("ppg/v_form_edit_dokumentasi", array('dokumentasi' => $dokumentasi));
            $this->load->view('footer');
        } elseif ($id_gambar_kegiatan != "" && $id_kegiatan != "" && $deskripsi != "" && $tanggal != "") {
            $config['upload_path']   = './uploads/dokumentasi/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // $error = array('error' => $this->upload->display_errors());
                // echo "error";
                $update_dokumentasi = array(
                    'deskripsi'   => $deskripsi,
                    'tanggal'     => $tanggal,
                    'id_kegiatan' => $id_kegiatan,
                );
                $where   = array('id_gambar_kegiatan' => $id_gambar_kegiatan);
                $execute = $this->PPG_model->update_data('gambar_kegiatan', $update_dokumentasi, $where);
                if ($execute >= 1) {
                    $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                    $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                    $this->load->view('footer');
                } else {
                    echo "gagal";
                }
            } else {
                $update_dokumentasi = array(
                    'deskripsi'       => $deskripsi,
                    'tanggal'         => $tanggal,
                    'id_kegiatan'     => $id_kegiatan,
                    'gambar_kegiatan' => $this->upload->data('file_name'),
                );
                $where   = array('id_gambar_kegiatan' => $id_gambar_kegiatan);
                $execute = $this->PPG_model->update_data('gambar_kegiatan', $update_dokumentasi, $where);
                if ($execute >= 1) {
                    $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
                    $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
                    $this->load->view('footer');
                } else {
                    echo "gagal";
                }
            }
        } else {
            echo "gagal";
        }
    }

    public function hapus_dokumentasi_kegiatan()
    {
        $hapus       = $this->input->post("hapus");
        $id_kegiatan = $this->input->post("id_kegiatan");
        $where       = array('id_gambar_kegiatan' => $hapus);
        $execute     = $this->PPG_model->delete_data('gambar_kegiatan', $where);
        if ($execute >= 1) {
            $dokumentasi = $this->PPG_model->get_dokumentasi_kegiatan("where id_kegiatan = $id_kegiatan");
            $this->load->view("ppg/v_form_dokumentasi", array('dokumentasi' => $dokumentasi, 'id_kegiatan' => $id_kegiatan));
            $this->load->view('footer');
        } else {
            echo "gagal";
        }
    }

    public function mengelola_feedback()
    {
        $data_kegiatan = $this->PPG_model->get_kegiatan("where k.id_status_kegiatan = 3");
        $this->load->view("ppg/v_mengelola_feedback", array('data_kegiatan' => $data_kegiatan));
        $this->load->view('footer');
    }

    public function feedback_kegiatan()
    {
        $id_kegiatan = $this->input->post("id_kegiatan");
        if ($id_kegiatan != "") {
            $feedback = $this->PPG_model->get_feedback_kegiatan("where k.id_kegiatan = $id_kegiatan");
            $this->load->view("ppg/v_list_feedback", array('feedback' => $feedback));
            $this->load->view('footer');
        }
    }

    public function balas_feedback()
    {
        $balas                = $this->input->post("balas");
        $id_feedback_kegiatan = $this->input->post("id_feedback_kegiatan");
        $email                = $this->input->post("email");
        $nama                 = $this->input->post("nama");
        $komentar             = $this->input->post("komentar");
        if ($balas != "") {
            $feedback       = $this->PPG_model->get_feedback_kegiatan("where id_feedback_kegiatan = $balas");
            $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan("where id_feedback_kegiatan = $balas");
            // for session
            $email = "kuthu@gmail.com";
            $nama  = "si kuthu";
            $this->load->view("ppg/v_balas_feedback", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $balas, 'email' => $email, 'nama' => $nama));
            $this->load->view('footer');
        } elseif ($id_feedback_kegiatan != "" && $email != "" && $nama != "" && $komentar != "") {
            $balas_komentar = array(
                'email'                => $email,
                'id_feedback_kegiatan' => $id_feedback_kegiatan,
                'komentar'             => $komentar,
            );
            $execute = $this->PPG_model->insert_data('balas_feedback', $balas_komentar);
            if ($execute >= 1) {
                $feedback       = $this->PPG_model->get_feedback_kegiatan("where id_feedback_kegiatan = $id_feedback_kegiatan");
                $balas_feedback = $this->PPG_model->get_balasan_feedback_kegiatan("where id_feedback_kegiatan = $id_feedback_kegiatan");
                $this->load->view("ppg/v_balas_feedback", array('feedback' => $feedback, 'balas_feedback' => $balas_feedback, 'id_feedback_kegiatan' => $id_feedback_kegiatan, 'email' => $email, 'nama' => $nama));
                $this->load->view('footer');
            } else {
                echo "gagal";
            }
        }
    }
}
