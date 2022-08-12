<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class HasilSentimen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Hasil/Hasil_model', 'Label/Label_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil Sentimen', 'Admin/HasilSentimen');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Hasil sentimen';
        $this->template->admin('admin/hasilsentimen/main', $data);
    }

    public function detail($id)
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil Sentimen', 'Admin/HasilSentimen');
        $this->breadcrumbs->push('Detail Hasil Sentimen', 'Admin/HasilSentimen/detail/' . $id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Detail Hasil sentimen';

        // mulai process
        $getData = $this->Hasil_model->get($id)->row();
        $get_id_label = explode(',', $getData->label_id);

        // label class
        $save_array = [];
        $metode = new NaiveBayes();
        $id_label = [];
        $id_label = $metode->id_label($get_id_label)['id_label'];
        $getDataLabel = $metode->id_label($get_id_label)['getDataLabel'];
        $save_array['id_label'] = $id_label;

        // text processing single
        $data_text = $getData->text_hasil;
        $save_array['sentimen']['text_sentimen'] = $data_text;

        $caseFolding = '';
        $text_mining = new SingleTextMining();
        $caseFolding = $text_mining->caseFolding($data_text);
        $save_array['sentimen']['caseFolding'] = $caseFolding;


        $cleansing = '';
        $cleansing = $text_mining->cleansing($caseFolding);
        $save_array['sentimen']['cleansing'] = $cleansing;


        $tokenizing = '';
        $tokenizing = $text_mining->tokenizing($cleansing);
        $save_array['sentimen']['tokenizing'] = $tokenizing;


        $stopword = '';
        $stopword = $text_mining->stopword($tokenizing);
        $save_array['sentimen']['stopword'] = $stopword;

        $stemming = '';
        $stemming = $text_mining->stemming($stopword);
        $save_array['sentimen']['stemming'] = $stemming;

        $hasil_akhir = $stemming;
        $save_array['sentimen']['hasil_akhir'] = $hasil_akhir;

        // text processing many
        $parsing_data = [];
        foreach ($getDataLabel as $key => $r_label) {
            $parsing_data[$r_label->id_label] = [
                'text_label' => $r_label->text_label,
                'nama_label' => $r_label->nama_label,
            ];
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

        // document
        $document = [];
        $document = $metode->document($stemming)['document'];

        // total document
        $totalDocument = [];
        $totalDocument = $metode->document($stemming)['totalDocument'];
        $save_array['perhitungan']['totalDocument'] = $totalDocument;


        // gabungkan semua data jika ada yang sama
        $gabungkan_kata = [];
        $gabungkan_kata = $metode->pengkondisianClass($stemming)['gabungkan_kata'];

        // melihat class
        $showClass = [];
        $showClass = $metode->pengkondisianClass($stemming)['showClass'];


        // banyaknya class
        $banyakClass = [];
        $banyakClass = $metode->pengkondisianClass($stemming)['banyakClass'];


        // total class
        $totalClass = 0;
        $totalClass = $metode->pengkondisianClass($stemming)['totalClass'];


        // mencari elemen per text
        // 1 = positif, 0 = netral, -1 = negatif
        $elemenPerText = [];
        $elemenPerText = $metode->elemenPerText($hasil_akhir, $banyakClass, $totalClass, $showClass);
        $save_array['perhitungan']['elemenPerText'] = $elemenPerText;

        // cari hasil data terbaru
        $gabungkanHasil = [];
        $gabungkanHasil = $metode->cariTotal($elemenPerText, $totalDocument)['gabungkanHasil'];
        // cari total
        $totalHasil = [];
        $totalHasil = $metode->cariTotal($elemenPerText, $totalDocument)['totalHasil'];
        $save_array['perhitungan']['totalHasil'] = $totalHasil;


        // hasil klasifikasi
        $outputAkhir = $metode->hasilKlasifikasi($totalHasil, $data_text);
        $save_array['output'] = $outputAkhir;
        $data['naive_bayes'] = $save_array;
        $this->template->admin('admin/hasilsentimen/detail', $data);
    }

    public function delete()
    {
        $id_hasil = htmlspecialchars_decode($this->input->post('id_hasil', true));
        $delete = $this->Hasil_model->delete($id_hasil);
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
        $data = $this->Hasil_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->text_hasil,
                ucwords($v_data->klasifikasi_hasil),
                $v_data->nilai_hasil,
                '<div class="text-center">
                    <a href="' . base_url('Admin/HasilSentimen/detail/' . $v_data->id_hasil) . '" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/HasilSentimen/delete/' . $v_data->id_hasil) . '" class="btn btn-danger btn-delete" data-id_hasil="' . $v_data->id_hasil . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
}
