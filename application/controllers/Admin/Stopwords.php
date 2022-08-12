<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stopwords extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Stopwords/Stopwords_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Stopwords', 'Admin/Stopwords');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Stopwords';
        $this->template->admin('admin/stopwords/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('text_stopwords', 'Text', 'required');
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
                $data_Stopwords = [
                    'text_stopwords' => htmlspecialchars($this->input->post('text_stopwords', true)),
                ];

                $insert = $this->Stopwords_model->insert($data_Stopwords);
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
                $id = htmlspecialchars($this->input->post('id_stopwords', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_stopwords', true));
                $data_Stopwords = [
                    'text_stopwords' => htmlspecialchars($this->input->post('text_stopwords', true)),
                ];
                $update = $this->Stopwords_model->update($data_Stopwords, $id);
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
        $get = $this->Stopwords_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_stopwords = htmlspecialchars_decode($this->input->post('id_stopwords', true));
        $delete = $this->Stopwords_model->delete($id_stopwords);
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
        $data = $this->Stopwords_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->text_stopwords,
                '<div class="text-center">
                    <a href="' . base_url('Admin/Stopwords/edit/' . $v_data->id_stopwords) . '" class="btn btn-warning btn-edit" data-id_stopwords="' . $v_data->id_stopwords . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Stopwords/delete/' . $v_data->id_stopwords) . '" class="btn btn-danger btn-delete" data-id_stopwords="' . $v_data->id_stopwords . '">
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

            $stopwords = [];
            for ($i = 2; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if ($cek != null) {
                    $count[] = $i;
                    $stopwords[] = [
                        'text_stopwords' => $sheetData[$i][0]
                    ];
                }
            }

            $rows = $this->Stopwords_model->insertMany($stopwords);

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
        $dataLabel = $this->Stopwords_model->get()->result();

        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Klasifikasi')
            ->setCellValue('B1', 'Score')
            ->setCellValue('C1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach ($dataLabel as $result) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $result->klasifikasi_label)
                ->setCellValue('B' . $kolom, $result->score_label)
                ->setCellValue('C' . $kolom, $result->text_label);

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
        $spreadsheet->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray_title);


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
        $spreadsheet->getActiveSheet()->getStyle('A2:C' . $kolom)->applyFromArray($styleArrayColumn);
        $spreadsheet->getActiveSheet()->getStyle('A2:C' . $kolom)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2:C' . $kolom)
            ->getAlignment()->setWrapText(true);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(55);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datalavel_covid.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
