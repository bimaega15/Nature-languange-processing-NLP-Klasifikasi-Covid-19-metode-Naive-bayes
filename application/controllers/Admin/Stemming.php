<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stemming extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Stemming/Stemming_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Stemming', 'Admin/Stemming');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Stemming';
        $this->template->admin('admin/stemming/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('awal_stemming', 'Awal Text', 'required');
        $this->form_validation->set_rules('akhir_stemming', 'Text diperbaiki', 'required');
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
                $data_Stemming = [
                    'awal_stemming' => htmlspecialchars($this->input->post('awal_stemming', true)),
                    'akhir_stemming' => htmlspecialchars($this->input->post('akhir_stemming', true)),
                ];

                $insert = $this->Stemming_model->insert($data_Stemming);
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
                $id = htmlspecialchars($this->input->post('id_stemming', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_stemming', true));
                $data_Stemming = [
                    'awal_stemming' => htmlspecialchars($this->input->post('awal_stemming', true)),
                    'akhir_stemming' => htmlspecialchars($this->input->post('akhir_stemming', true)),
                ];

                $update = $this->Stemming_model->update($data_Stemming, $id);
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
        $get = $this->Stemming_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_stemming = htmlspecialchars_decode($this->input->post('id_stemming', true));
        $delete = $this->Stemming_model->delete($id_stemming);
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
        $data = $this->Stemming_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->awal_stemming,
                $v_data->akhir_stemming,
                '<div class="text-center">
                    <a href="' . base_url('Admin/Stemming/edit/' . $v_data->id_stemming) . '" class="btn btn-warning btn-edit" data-id_stemming="' . $v_data->id_stemming . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Stemming/delete/' . $v_data->id_stemming) . '" class="btn btn-danger btn-delete" data-id_stemming="' . $v_data->id_stemming . '">
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


            $Stemming = [];
            $rekam = null;
            for ($i = 2; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if ($cek != null) {
                    $count[] = $i;

                    $text = $sheetData[$i][0];
                    $explode = explode(' ', $text);
                    $join = [];
                    if (count($explode) > 2) {
                        foreach ($explode as $key => $v_explode) {
                            if ($key > 1) {
                                $join[] = $v_explode;
                            }
                        }
                        $akhir_stemming = implode(' ', $join);
                    } else {
                        $rekam = $explode[1];
                        $akhir_stemming = $rekam;
                    }

                    $awal_stemming = $explode[0];

                    $Stemming[] = [
                        'awal_stemming' => trim($awal_stemming),
                        'akhir_stemming' => trim($akhir_stemming),
                    ];
                }
            }

            $rows = $this->Stemming_model->insertMany($Stemming);

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
    public function export()
    {
        $dataLabel = $this->Stemming_model->get()->result();

        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Text Awal')
            ->setCellValue('B1', 'KBBI');

        $kolom = 2;
        $nomor = 1;
        foreach ($dataLabel as $result) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $result->awal_stemming)
                ->setCellValue('B' . $kolom, $result->akhir_stemming);

            $kolom++;
            $nomor++;
        }

        $styleArray_title = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleArray_title);


        $styleArrayColumn = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $kolom = $kolom - 1;
        $spreadsheet->getActiveSheet()->getStyle('A2:B' . $kolom)->applyFromArray($styleArrayColumn);
        $spreadsheet->getActiveSheet()->getStyle('A2:B' . $kolom)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2:B' . $kolom)
            ->getAlignment()->setWrapText(true);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datastemming.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
