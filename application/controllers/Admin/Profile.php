<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model('Users/Users_model');
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Profile', 'Admin/Profile');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Profile';
        $data['profile'] = check_profile();
        $this->template->admin('admin/profile/main', $data);
    }
    public function process()
    {
        $password = $this->input->post('password', true);
        if ($password != null) {
            $password_fix = md5($this->input->post('password', true));
        } else {
            $password_fix = $this->input->post('password_old', true);
        }
        $data = [
            'nama' => $this->input->post('nama', true),
            'username' => $this->input->post('username', true),
            'password' => $password_fix,
        ];
        $id_admin = $this->input->post('id_admin', true);
        $update = $this->Users_model->update($data, $id_admin);
        if ($update > 0) {
            $this->session->set_flashdata('success', 'Berhasil update data profile');
        } else {
            $this->session->set_flashdata('error', 'Gagal update data profile');
        }
        return redirect(base_url('Admin/Profile'));
    }
}
