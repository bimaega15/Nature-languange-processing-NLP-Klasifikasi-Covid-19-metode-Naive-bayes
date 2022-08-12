<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();

        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
    }
    public function index()
    {
        $data['title'] = 'Konfigurasi';
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Konfigurasi', 'Admin/Konfigurasi');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $result = $this->db->get('konfigurasi')->row();
        if ($result != null) {
            $data['row'] = $result;
        } else {
            $obj = new stdClass();
            $obj->instansi_konfigurasi = null;
            $obj->nama_konfigurasi = null;
            $obj->nohp_konfigurasi = null;
            $obj->alamat_konfigurasi = null;
            $obj->email_konfigurasi = null;
            $obj->gambar_konfigurasi = null;
            $obj->copyright_konfigurasi = null;
            $obj->tentang_konfigurasi = null;
            $data['row'] = $obj;
        }
        $this->template->admin('admin/konfigurasi/main', $data);
    }
    public function process()
    {
        $check = $this->db->get('konfigurasi');
        if ($check->num_rows() > 0) {
            $check = $check->row();
            $id_konfigurasi = $check->id_konfigurasi;
            $data = [
                'instansi_konfigurasi' => $this->input->post('instansi_konfigurasi', true),
                'nama_konfigurasi' => $this->input->post('nama_konfigurasi', true),
                'nohp_konfigurasi' => $this->input->post('nohp_konfigurasi', true),
                'alamat_konfigurasi' => $this->input->post('alamat_konfigurasi', true),
                'email_konfigurasi' => $this->input->post('email_konfigurasi', true),
                'gambar_konfigurasi' => $this->uploadGambar(null, $id_konfigurasi),
                'copyright_konfigurasi' => $this->input->post('copyright_konfigurasi', true),
                'tentang_konfigurasi' => $this->input->post('tentang_konfigurasi', true),

            ];
            $update = $this->db->update('konfigurasi', $data, ['id_konfigurasi' => $id_konfigurasi]);
        } else {
            $data = [
                'instansi_konfigurasi' => $this->input->post('instansi_konfigurasi', true),
                'nama_konfigurasi' => $this->input->post('nama_konfigurasi', true),
                'nohp_konfigurasi' => $this->input->post('nohp_konfigurasi', true),
                'alamat_konfigurasi' => $this->input->post('alamat_konfigurasi', true),
                'email_konfigurasi' => $this->input->post('email_konfigurasi', true),
                'gambar_konfigurasi' => $this->uploadGambar(),
                'copyright_konfigurasi' => $this->input->post('copyright_konfigurasi', true),
                'tentang_konfigurasi' => $this->input->post('tentang_konfigurasi', true),
            ];
            $insert = $this->db->insert('konfigurasi', $data);
        }
        $row = $this->db->affected_rows();
        $status = $check == null ? 'Insert' : 'Update';
        if ($row > 0) {
            $this->session->set_flashdata('success', 'Berhasil ' . $status . ' konfigurasi');
        } else {
            $this->session->set_flashdata('error', 'Gagal ' . $status . ' konfigurasi');
        }
        return redirect(base_url('Admin/Konfigurasi'));
    }
    private function uploadGambar($gender = null, $id = null)
    {
        $gambar = $_FILES['gambar_konfigurasi']['name'];
        if ($gambar != null) {
            if ($id != null) {
                $this->removeImage($id);
            }
            $config['upload_path'] = './img/konfigurasi';
            $config['allowed_types'] = 'jpg|png|jpeg|bif|gif|svg';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_konfigurasi"]['name'];
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('gambar_konfigurasi')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                return $gambar['file_name'];
            }
        } else {
            if ($id != null) {
                $data = $this->db->get_where('konfigurasi', ['id_konfigurasi' => $id])->row();
                if ($data != null) {
                    return $data->gambar_konfigurasi;
                }
            }
        }
    }
    private function removeImage($id)
    {
        $konfigurasi = $this->db->get_where('konfigurasi', ['id_konfigurasi' => $id])->row();
        if ($konfigurasi != null) {
            $filename = explode('.', $konfigurasi->gambar_konfigurasi)[0];
            return array_map('unlink', glob(FCPATH . "img/konfigurasi/" . $filename . '.*'));
        }
    }
}
