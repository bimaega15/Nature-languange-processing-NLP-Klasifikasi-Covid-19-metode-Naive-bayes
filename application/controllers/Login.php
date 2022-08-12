<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users/Users_model');
    }
    public function index()
    {
        check_already_login();
        $data['title'] = 'Login Page';
        $this->template->login('login/main', $data);
    }
    public function process()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $model = $this->Users_model->login($username, $password);
        if ($model->num_rows() > 0) {
            $row = $model->row();
            $this->session->set_userdata([
                'id_admin' => $row->id_admin,
            ]);
            $this->session->set_flashdata('success', 'Selamat login! ' . $row->nama);
            return redirect(base_url('Admin/Home'));
        } else {
            $this->session->set_flashdata('error', 'Username atau password admin salah');
            return redirect('/Login');
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(base_url('Login'));
    }
}
