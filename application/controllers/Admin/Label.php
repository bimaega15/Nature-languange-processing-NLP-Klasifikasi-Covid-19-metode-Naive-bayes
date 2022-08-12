<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $this->template->admin('admin/label/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('nama_label', 'Nama label', 'required');
        $this->form_validation->set_rules('text_label', 'Text label', 'required');
        $this->form_validation->set_rules('klasifikasi_label', 'Klasifikasi', 'required');
        // $this->form_validation->set_rules('score_label', 'Score', 'required');
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
                $klasifikasi_label = htmlspecialchars($this->input->post('klasifikasi_label', true));
                switch ($klasifikasi_label) {
                    case 'positif':
                        $score_label = 1;
                        break;
                    case 'negatif':
                        $score_label = -1;
                        break;
                    case 'netral':
                        $score_label = 0;
                        break;
                }
                $data_Label = [
                    'nama_label' => htmlspecialchars($this->input->post('nama_label', true)),
                    'text_label' => htmlspecialchars($this->input->post('text_label', true)),
                    'klasifikasi_label' => $klasifikasi_label,
                    'score_label' => $score_label,
                ];

                $insert = $this->Label_model->insert($data_Label);
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
                $klasifikasi_label = htmlspecialchars($this->input->post('klasifikasi_label', true));
                switch ($klasifikasi_label) {
                    case 'positif':
                        $score_label = 1;
                        break;
                    case 'negatif':
                        $score_label = -1;
                        break;
                    case 'netral':
                        $score_label = 0;
                        break;
                }
                $data_Label = [
                    'nama_label' => htmlspecialchars($this->input->post('nama_label', true)),
                    'text_label' => htmlspecialchars($this->input->post('text_label', true)),
                    'klasifikasi_label' => $klasifikasi_label,
                    'score_label' => $score_label,
                ];
                $update = $this->Label_model->update($data_Label, $id);
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
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->nama_label,
                $v_data->text_label,
                ucwords($v_data->klasifikasi_label),
                $v_data->score_label,
                '<div class="text-center">
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


            $Label = [];
            for ($i = 1; $i < count($sheetData); $i++) {
                $cek = $sheetData[$i][0];
                if ($cek != null && $cek != false) {
                    $count[] = $i;
                    $explode = str_replace('"', '',  explode(',', $cek));
                    $dataDb = $explode;

                    $dataLabel[] = [
                        'klasifikasi_label' => strtolower(trim($dataDb[1])),
                        'score_label' => trim($dataDb[2]),
                        'text_label' => trim($dataDb[3]),
                        'nama_label' => trim($dataDb[4]),
                    ];
                }
            }

            $rows = $this->Label_model->insertMany($dataLabel);

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
        $dataLabel = $this->Label_model->get()->result();

        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Klasifikasi')
            ->setCellValue('B1', 'Score')
            ->setCellValue('C1', 'Keterangan')
            ->setCellValue('D1', 'Nama');

        $kolom = 2;
        $nomor = 1;
        foreach ($dataLabel as $result) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $result->klasifikasi_label)
                ->setCellValue('B' . $kolom, $result->score_label)
                ->setCellValue('C' . $kolom, $result->text_label)
                ->setCellValue('D' . $kolom, $result->nama_label);

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
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray_title);


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
        $spreadsheet->getActiveSheet()->getStyle('A2:D' . $kolom)->applyFromArray($styleArrayColumn);
        $spreadsheet->getActiveSheet()->getStyle('A2:D' . $kolom)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2:D' . $kolom)
            ->getAlignment()->setWrapText(true);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(55);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datalavel_covid.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function dataTwitter()
    {
        $initial_tweet = initial_tweet();
        $bearer_token = initial_tweet()['bearer_token'];

        $query = 'Covid-19 di indonesia';
        $query = rawurlencode($query);

        $jumlah_data = $this->input->post('jumlah_data', true);
        $get_data = [];
        $next_token = 'b26v89c19zqg8o3fpz2mg2p4sm5nalzvebgekauzbx01p';

        do {
            $this->curl->create('https://api.twitter.com/2/tweets/search/recent?max_results=100&expansions=author_id&user.fields=name,username&tweet.fields=lang&query=' . $query . '&next_token=' . $next_token);

            // Option & Options
            $this->curl->option(CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $bearer_token
            ));

            $data = $this->curl->execute();

            $data_hasil = json_decode($data, true);
            $data_hasil_users = $data_hasil['includes'];
            $data_hasil_next_token = $data_hasil['meta']['next_token'];

            $author_id = [];
            foreach ($data_hasil_users['users'] as $key => $value) {
                $author_id[$value['id']] = $value['name'];
            }

            foreach ($data_hasil['data'] as $key => $value) {
                if ($value['lang'] == 'in') {
                    $get_data[$value['id']] = [
                        'text_label' => $value['text'],
                        'nama_label' => $author_id[$value['author_id']]
                    ];
                }
            }
            $next_token = $data_hasil_next_token;

            // $error_code = $this->curl->error_code; // int
            // $error_string = $this->curl->error_string;
        } while (count($get_data) <= $jumlah_data);
        $parsing_data = [];
        $no = 1;
        foreach ($get_data as $key => $value) {
            if ($no <= $jumlah_data) {
                $parsing_data[] = $value;
            }
            $no++;
        }

        $caseFolding = [];
        $text_mining = new TextMining();
        $caseFolding = $text_mining->caseFolding($parsing_data);

        $cleansing = [];
        $cleansing = $text_mining->cleansing($caseFolding);


        $tokenizing = [];
        $tokenizing = $text_mining->tokenizing($cleansing);

        $stopword = [];
        $stopword = $text_mining->stopword($tokenizing);

        $stemming = [];
        $stemming = $text_mining->stemming($stopword);

        $negation = [];
        $negation = $text_mining->negation($stemming);

        $hasil = [];
        foreach ($negation as $key => $v_negation) {
            $data_awal = $parsing_data[$key]['text_label'];
            $merge = array_merge([
                'text_label' => $data_awal
            ], $v_negation);
            $hasil[] = $merge;
        }

        $insert = $this->Label_model->insertMany($hasil);
        if ($insert) {
            $this->session->set_flashdata('success', 'Berhasil crawling data twitter');
            return redirect(base_url('Admin/Label'));
        } else {
            $this->session->set_flashdata('error', 'Gagal crawling data twitter');
            return redirect(base_url('Admin/Label'));
        }
    }
}
