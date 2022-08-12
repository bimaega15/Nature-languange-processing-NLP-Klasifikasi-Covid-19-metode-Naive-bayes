<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Users/Users_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Users', 'Admin/Users');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Users';
        $this->template->admin('admin/users/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_validationUsername');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('password', 'Password', 'callback_validatePassword');
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
                $data_Users = [
                    'nama' => htmlspecialchars($this->input->post('nama', true)),
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => htmlspecialchars(md5($this->input->post('password', true))),
                ];

                $insert = $this->Users_model->insert($data_Users);
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
                $id = htmlspecialchars($this->input->post('id_admin', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_admin', true));
                $password = $this->input->post('password', true);
                if ($password == null) {
                    $password = $this->input->post('password_old', true);
                } else {
                    $password = md5($password);
                }

                $data_Users = [
                    'nama' => htmlspecialchars($this->input->post('nama', true)),
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => $password,
                ];
                $update = $this->Users_model->update($data_Users, $id);
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
        $get = $this->Users_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_admin = htmlspecialchars_decode($this->input->post('id_admin', true));
        $delete = $this->Users_model->delete($id_admin);
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
        $data = $this->Users_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $button = '';
            $id_admin = $this->session->userdata('id_admin');
            if ($v_data->id_admin != $id_admin) {
                $button = '<a href="' . base_url('Admin/Users/delete/' . $v_data->id_admin) . '" class="btn btn-danger btn-delete" data-id_admin="' . $v_data->id_admin . '">
                <i class="fas fa-trash"></i>
            </a>';
            }
            $result['data'][] = [
                $no++,
                $v_data->username,
                $v_data->nama,
                '<div class="text-center">
                    <a href="' . base_url('Admin/Users/edit/' . $v_data->id_admin) . '" class="btn btn-warning btn-edit" data-id_admin="' . $v_data->id_admin . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    ' . $button . '
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validationUsername()
    {
        $boolean = true;
        if ($_POST['page'] == 'add') {
            $username = $this->input->post('username', true);
            $check_nip = $this->db->get_where('admin', [
                'username' => $username
            ])->num_rows();
            if ($check_nip > 0) {
                $this->form_validation->set_message('validationUsername', 'NIP sudah digunakan');
                $boolean = false;
            }
        } else {
            $username = $this->input->post('username', true);
            $id_admin = $this->input->post('id_admin', true);
            $check_nip = $this->db->get_where('admin', [
                'username' => $username,
                'id_admin <> ' => $id_admin
            ])->num_rows();
            if ($check_nip > 0) {
                $this->form_validation->set_message('validationUsername', 'NIP sudah digunakan');
                $boolean = false;
            }
        }

        return $boolean;
    }

    public function validatePassword()
    {
        $boolean = true;
        if ($_POST['page'] == 'add') {
            $password = $this->input->post('password', true);
            $confirm_password = $this->input->post('confirm_password', true);
            if ($password == null) {
                $this->form_validation->set_message('validatePassword', 'Password tidak boleh kosong');
                $boolean = false;
                return $boolean;
            }

            if ($confirm_password == null) {
                $this->form_validation->set_message('validatePassword', 'Confirm Password tidak boleh kosong');
                $boolean = false;
                return $boolean;
            }
            if ($confirm_password != $password) {
                $this->form_validation->set_message('validatePassword', 'Password tidak sama dengan confirm password');
                $boolean = false;
                return $boolean;
            }
        } else {
            $password = $this->input->post('password', true);
            $confirm_password = $this->input->post('confirm_password', true);
            if ($password != null && $confirm_password != null) {
                if ($password != $confirm_password) {
                    $this->form_validation->set_message('validatePassword', 'Password tidak sama dengan confirm password');
                    $boolean = false;
                    return $boolean;
                }
            }
        }

        return $boolean;
    }
}
