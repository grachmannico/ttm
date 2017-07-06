<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('v_upload', array('error' => ' '));
    }

    public function do_upload()
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        // $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('v_upload', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            echo "<img src='" . base_url() . "uploads/" . $this->upload->data('file_name') . "'>";
            // $this->load->view('v_upload_success', $data);
        }
    }
}
