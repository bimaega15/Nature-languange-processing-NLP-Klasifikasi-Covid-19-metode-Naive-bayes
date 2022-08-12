<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class NegativeWords extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['NegativeWords/NegativeWords_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Negative Words', 'Admin/NegativeWords');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Negative Words';
        $this->template->admin('admin/NegativeWords/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_negativewords', 'Text positive', 'required');
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
                $data_NegativeWords = [
                    'nama_negativewords' => htmlspecialchars($this->input->post('nama_negativewords', true)),
                ];

                $insert = $this->NegativeWords_model->insert($data_NegativeWords);
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
                $id = htmlspecialchars($this->input->post('id_negativewords', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_negativewords', true));
                $data_NegativeWords = [
                    'nama_negativewords' => htmlspecialchars($this->input->post('nama_negativewords', true)),
                ];
                $update = $this->NegativeWords_model->update($data_NegativeWords, $id);
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
        $get = $this->NegativeWords_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_negativewords = htmlspecialchars_decode($this->input->post('id_negativewords', true));
        $delete = $this->NegativeWords_model->delete($id_negativewords);
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
        $data = $this->NegativeWords_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_negativewords,
                '<div class="text-center">
                    <a href="' . base_url('Admin/NegativeWords/edit/' . $v_data->id_negativewords) . '" class="btn btn-warning btn-edit" data-id_negativewords="' . $v_data->id_negativewords . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/NegativeWords/delete/' . $v_data->id_negativewords) . '" class="btn btn-danger btn-delete" data-id_negativewords="' . $v_data->id_negativewords . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function import()
    {
        $this->form_validation->set_rules('import', 'Import', 'callback_validateImport');
        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            $arr_file = explode('.', $_FILES['import']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new Xlsximport;
            }

            $spreadsheet = $reader->load($_FILES['import']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $dataAwal = $this->NegativeWords_model->get()->result();
            $nama_negativewords = array_column($dataAwal, 'nama_negativewords');

            $NegativeWords = [];
            for ($i = 0; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if (!in_array($sheetData[$i][0], $nama_negativewords)) {
                    if ($cek != null) {
                        $count[] = $i;
                        $NegativeWords[] = [
                            'nama_negativewords' => $sheetData[$i][0]
                        ];
                    }
                }
            }
            if (count($NegativeWords) > 0) {
                $rows = $this->NegativeWords_model->insertMany($NegativeWords);
                if ($rows) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'berhasil import data ' . count($count) . ' data',
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal import data',
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    'status_db' => 'info',
                    'output' => 'Kata negative sudah semua',
                ];
                echo json_encode($data);
            }
        }
    }
    public function validateImport()
    {

        $boolean = TRUE;
        if ($_FILES["import"]['size'] == null || $_FILES["import"]['size'] == 0) {
            $this->form_validation->set_message('validateImport', "File import wajib diisi");
            $boolean = FALSE;
            return $boolean;
        }
        $allowedExts = array("csv", "xls", "xlsx");
        $extension = pathinfo($_FILES["import"]["name"], PATHINFO_EXTENSION);
        if (($_FILES['import']['name']) != null) {
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('validateImport', "Tidak didukung format {$extension}");
                $boolean = FALSE;
                return $boolean;
            }
        }
        return $boolean;
    }
}
