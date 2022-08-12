<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class PositiveWords extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['PositiveWords/PositiveWords_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Positive Words', 'Admin/PositiveWords');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Positive Words';
        $this->template->admin('admin/positivewords/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_positivewords', 'Text positive', 'required');
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
                $data_PositiveWords = [
                    'nama_positivewords' => htmlspecialchars($this->input->post('nama_positivewords', true)),
                ];

                $insert = $this->PositiveWords_model->insert($data_PositiveWords);
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
                $id = htmlspecialchars($this->input->post('id_positivewords', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_positivewords', true));
                $data_PositiveWords = [
                    'nama_positivewords' => htmlspecialchars($this->input->post('nama_positivewords', true)),
                ];
                $update = $this->PositiveWords_model->update($data_PositiveWords, $id);
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
        $get = $this->PositiveWords_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_positivewords = htmlspecialchars_decode($this->input->post('id_positivewords', true));
        $delete = $this->PositiveWords_model->delete($id_positivewords);
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
        $data = $this->PositiveWords_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_positivewords,
                '<div class="text-center">
                    <a href="' . base_url('Admin/PositiveWords/edit/' . $v_data->id_positivewords) . '" class="btn btn-warning btn-edit" data-id_positivewords="' . $v_data->id_positivewords . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/PositiveWords/delete/' . $v_data->id_positivewords) . '" class="btn btn-danger btn-delete" data-id_positivewords="' . $v_data->id_positivewords . '">
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
            $dataAwal = $this->PositiveWords_model->get()->result();
            $nama_positivewords = array_column($dataAwal, 'nama_positivewords');


            $positivewords = [];
            for ($i = 0; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if (!in_array($sheetData[$i][0], $nama_positivewords)) {
                    if ($cek != null) {
                        $count[] = $i;
                        $positivewords[] = [
                            'nama_positivewords' => $sheetData[$i][0]
                        ];
                    }
                }
            }
            if (count($positivewords) > 0) {
                $rows = $this->PositiveWords_model->insertMany($positivewords);
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
                    'output' => 'Kata positive sudah semua',
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
