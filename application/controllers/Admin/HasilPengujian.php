<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class HasilPengujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Pengujian/Pengujian_model', 'Label/Label_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil Pengujian', 'Admin/HasilPengujian');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Hasil Pengujian';
        $this->template->admin('admin/hasilpengujian/main', $data);
    }

    public function detail($id)
    {
        // get data
        $row = $this->Pengujian_model->get($id)->row();

        $data_latih = $row->input_latih_pengujian;
        $data_uji = $row->input_uji_pengujian;

        // pembagian data
        $latih = explode(',', $row->latih_id_pengujian);
        $uji = explode(',', $row->uji_id_pengujian);

        $dataLatih = $this->Label_model->get(null, $latih)->result();
        $dataUji = $this->Label_model->get(null, $uji)->result();

        $id_label = [];
        foreach ($dataLatih as $key => $v_data_latih) {
            $id_label[] = $v_data_latih->id_label;
        }

        // label class
        $save_array = [];
        $metode = new NaiveBayes();
        $id_label = $metode->id_label($id_label)['id_label'];
        $getDataLabel = $metode->id_label($id_label)['getDataLabel'];

        foreach ($dataUji as $key => $v_data_uji) {
            // text processing single
            $data_text = $v_data_uji->text_label;

            $caseFolding = '';
            $text_mining = new SingleTextMining();
            $caseFolding = $text_mining->caseFolding($data_text);

            $cleansing = '';
            $cleansing = $text_mining->cleansing($caseFolding);

            $tokenizing = '';
            $tokenizing = $text_mining->tokenizing($cleansing);

            $stopword = '';
            $stopword = $text_mining->stopword($tokenizing);

            $stemming = '';
            $stemming = $text_mining->stemming($stopword);

            $hasil_akhir = $stemming;

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

            // cari hasil data terbaru
            $gabungkanHasil = [];
            $gabungkanHasil = $metode->cariTotal($elemenPerText, $totalDocument)['gabungkanHasil'];
            // cari total
            $totalHasil = [];
            $totalHasil = $metode->cariTotal($elemenPerText, $totalDocument)['totalHasil'];

            // hasil klasifikasi
            $outputAkhir = $metode->hasilKlasifikasi($totalHasil, $data_text);
            $dataPengujian['hasil'][] = [
                'id_label' => $v_data_uji->id_label,
                'klasifikasi' => $outputAkhir['klasifikasi']
            ];
        }


        $getPengujian['pengujian'] = $dataPengujian;
        $getPengujian['pengujian']['data_latih'] = $data_latih;
        $getPengujian['pengujian']['data_uji'] = $data_uji;
        $getPengujian['pengujian']['tb_latih'] = $dataLatih;
        $getPengujian['pengujian']['tb_uji'] = $dataUji;

        $getSession = $getPengujian['pengujian'];
        $metode = new NaiveBayes();
        $dataUji = $metode->confusionMatrix($getSession)['dataUji'];
        $accuracy = $metode->confusionMatrix($getSession)['accuracy'];
        $precision = $metode->confusionMatrix($getSession)['precision'];
        $recall = $metode->confusionMatrix($getSession)['recall'];

        $pPositif = $metode->confusionMatrix($getSession)['pPositif'];
        $pNegatif = $metode->confusionMatrix($getSession)['pNegatif'];
        $pNetral = $metode->confusionMatrix($getSession)['pNetral'];

        $nPositif = $metode->confusionMatrix($getSession)['nPositif'];
        $nNegatif = $metode->confusionMatrix($getSession)['nNegatif'];
        $nNetral = $metode->confusionMatrix($getSession)['nNetral'];

        $netPositif = $metode->confusionMatrix($getSession)['netPositif'];
        $netNegatif = $metode->confusionMatrix($getSession)['netNegatif'];
        $netNetral = $metode->confusionMatrix($getSession)['netNetral'];

        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Hasil Pengujian', 'Admin/HasilPengujian');
        $this->breadcrumbs->push('Detail Hasil Pengujian', 'Admin/HasilPengujian/detail/' . $id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Detail Hasil Pengujian';

        $data['data_latih'] = $getSession['data_latih'];
        $data['data_uji'] = $getSession['data_uji'];
        $data['tb_latih'] = $getSession['tb_latih'];
        $data['tb_uji'] = $dataUji;

        $data['accuracy'] = $accuracy;
        $data['precision'] = $precision;
        $data['recall'] = $recall;

        $data['table_pengujian']['tb_latih'] =  $getSession['tb_latih'];
        $data['table_pengujian']['tb_uji'] =  $getSession['tb_uji'];
        $data['table_pengujian']['hasil_uji'] =  $dataUji;

        $data['table_pengujian']['accuracy'] =  $accuracy;
        $data['table_pengujian']['precision'] =  $precision;
        $data['table_pengujian']['recall'] =  $recall;
        $this->session->set_userdata('table_pengujian', $data['table_pengujian']);


        $data['pPositif'] = $pPositif;
        $data['pNegatif'] = $pNegatif;
        $data['pNetral'] = $pNetral;

        $data['nPositif'] = $nPositif;
        $data['nNegatif'] = $nNegatif;
        $data['nNetral'] = $nNetral;

        $data['netPositif'] = $netPositif;
        $data['netNegatif'] = $netNegatif;
        $data['netNetral'] = $netNetral;

        $this->template->admin('admin/hasilpengujian/detail', $data);
    }

    public function delete()
    {
        $id_pengujian = htmlspecialchars_decode($this->input->post('id_pengujian', true));
        $delete = $this->Pengujian_model->delete($id_pengujian);
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
        $data = $this->Pengujian_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->input_latih_pengujian,
                $v_data->input_uji_pengujian,
                round(($v_data->akurasi_pengujian * 100), 2) . '%',
                round(($v_data->precision_pengujian * 100), 2) . '%',
                round(($v_data->recall_pengujian * 100), 2) . '%',
                '<div class="text-center">
                    <a href="' . base_url('Admin/HasilPengujian/detail/' . $v_data->id_pengujian) . '" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/HasilPengujian/delete/' . $v_data->id_pengujian) . '" class="btn btn-danger btn-delete" data-id_pengujian="' . $v_data->id_pengujian . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }

    public function loadDataLatih()
    {
        $data = (object) $this->session->userdata('table_pengujian')['tb_latih'];
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
            ];
        }
        echo json_encode($result);
    }

    public function loadDataUji()
    {
        $data = (object) $this->session->userdata('table_pengujian')['tb_uji'];
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
            ];
        }
        echo json_encode($result);
    }

    public function loadDataHasil()
    {
        $data = (object) $this->session->userdata('table_pengujian')['hasil_uji'];

        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $check_hasil = $v_data->hasil_banding;
            $tampil_check = '';
            if ($check_hasil) {
                $tampil_check = '<i class="fas fa-check fa-2x text-success"></i>';
            } else {
                $tampil_check = '<i class="fas fa-times fa-2x text-danger"></i>';
            }
            $result['data'][] = [
                $no++,
                $v_data->nama_label,
                $v_data->text_label,
                ucwords($v_data->klasifikasi_label),
                $v_data->score_label,
                $v_data->klasifikasi,
                $tampil_check,
            ];
        }
        echo json_encode($result);
    }
}
