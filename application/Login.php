<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            $this->load->view('v_login_sukses');
        } else {
            $this->load->view('v_login');
        }
    }

    public function auth()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );
        if ($this->form_validation->run() == false) {
            $this->load->view('v_login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($username != "" && $password != "") {
                if ($username == "135150407111002" && $password == "a") {
                    $usersess = array(
                        'username' => $username
                        );
                    $this->session->set_userdata($usersess);
                    // echo $_SESSION['logged_in'];
                    // $this->load->view('v_login_sukses');
                    redirect(site_url('login'));
                }
            } else {
                echo "masukkan username dan password";
            }
        }
    }

    public function logout()
    {
        unset($_SESSION["logged_in"]);
        session_destroy();
        redirect('login');
    }
}
