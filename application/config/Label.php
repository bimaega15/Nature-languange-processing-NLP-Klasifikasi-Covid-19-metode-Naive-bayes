<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Label extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Label/Label_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Label', 'Admin/Label');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Label';
        $data['result'] = $this->Label_model->get()->result();
        $this->template->admin('admin/label/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_label', 'Label', 'required');
        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if (($_POST['page']) == 'add') {
            if ($this->form_validation->run() == false) {
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $data_label = [
                    'nama_label' => htmlspecialchars($this->input->post('nama_label', true)),
                ];
                $insert = $this->Label_model->insert($data_label);
                if ($insert > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil menambah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        } else if (($_POST['page']) == 'edit') {
            if ($this->form_validation->run() == false) {
                $id = htmlspecialchars($this->input->post('id_label', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_label', true));

                $data_label = [
                    'nama_label' => htmlspecialchars($this->input->post('nama_label', true)),
                ];
                $update = $this->Label_model->update($data_label, $id);
                if ($update > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil mengubah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }
    public function edit($id)
    {

        $get = $this->Label_model->get($id)->row();

        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_label = htmlspecialchars_decode($this->input->post('id_label', true));
        $delete = $this->Label_model->delete($id_label);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }

    public function loadData()
    {
        $data = $this->Label_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'][] = [
                'Tidak ada data',
                'Tidak ada data',
                'Tidak ada data'
            ];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_label,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Label/edit/' . $v_data->id_label) . '" class="btn btn-warning btn-edit" data-id_label="' . $v_data->id_label . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Label/delete/' . $v_data->id_label) . '" class="btn btn-danger btn-delete" data-id_label="' . $v_data->id_label . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
}
