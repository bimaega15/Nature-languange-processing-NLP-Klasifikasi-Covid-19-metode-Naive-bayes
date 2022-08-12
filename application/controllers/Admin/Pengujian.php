<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class Pengujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['Hasil/Hasil_model', 'Label/Label_model', 'Pengujian/Pengujian_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Pengujian', 'Admin/Pengujian');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Pengujian';
        $this->template->admin('admin/pengujian/main', $data);
    }

    public function prosesUji()
    {
        $data_label = $this->Label_model->get()->result();
        $count_data_label = count($data_label);

        $data_latih = htmlspecialchars($this->input->post('data_latih', true));
        $data_uji = htmlspecialchars($this->input->post('data_uji', true));

        // pembagian data
        $totalLatih = round(($count_data_label * $data_latih) / 100);
        $dataLatih = [];
        $dataUji = [];
        foreach ($data_label as $key => $v_label) {
            $row = ($key + 1);
            if ($row <= $totalLatih) {
                $dataLatih[] = $v_label;
            } else {
                $dataUji[] = $v_label;
            }
        }

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

        $data['pengujian'] = $dataPengujian;
        $data['pengujian']['data_latih'] = $data_latih;
        $data['pengujian']['data_uji'] = $data_uji;
        $data['pengujian']['tb_latih'] = $dataLatih;
        $data['pengujian']['tb_uji'] = $dataUji;
        $this->session->set_userdata($data);
        return redirect(base_url('Admin/Pengujian/hasil'));
    }

    public function hasil()
    {
        if (!($this->session->has_userdata('pengujian'))) {
            $this->session->set_flashdata('error', 'Silahkan input data latih dan data uji terlebih dahulu');
            return redirect(base_url('Admin/Pengujian'));
        }
        $getSession = $this->session->userdata('pengujian');
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
        $this->breadcrumbs->push('Pengujian', 'Admin/Pengujian');
        $this->breadcrumbs->push('Hasil Pengujian', 'Admin/Pengujian/hasil');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Pengujian';

        $data['data_latih'] = $getSession['data_latih'];
        $data['data_uji'] = $getSession['data_uji'];
        $data['tb_latih'] = $getSession['tb_latih'];
        $data['tb_uji'] = $dataUji;

        $data['accuracy'] = $accuracy;
        $data['precision'] = $precision;
        $data['recall'] = $recall;

        $session['table_pengujian']['tb_latih'] =  $getSession['tb_latih'];
        $session['table_pengujian']['tb_uji'] =  $getSession['tb_uji'];
        $session['table_pengujian']['hasil_uji'] =  $dataUji;

        $session['table_pengujian']['accuracy'] =  $accuracy;
        $session['table_pengujian']['precision'] =  $precision;
        $session['table_pengujian']['recall'] =  $recall;
        $this->session->set_userdata($session);

        $data['pPositif'] = $pPositif;
        $data['pNegatif'] = $pNegatif;
        $data['pNetral'] = $pNetral;

        $data['nPositif'] = $nPositif;
        $data['nNegatif'] = $nNegatif;
        $data['nNetral'] = $nNetral;

        $data['netPositif'] = $netPositif;
        $data['netNegatif'] = $netNegatif;
        $data['netNetral'] = $netNetral;

        $this->template->admin('admin/pengujian/hasil', $data);
    }

    public function submitPengujian()
    {
        if (!($this->session->has_userdata('pengujian')) && !($this->session->has_userdata('table_pengujian'))) {
            $this->session->set_flashdata('error', 'Silahkan input data latih dan data uji terlebih dahulu');
            return redirect(base_url('Admin/Pengujian'));
        }

        $getSessionPengujian = $this->session->userdata('pengujian');
        $getConfusion = $this->session->userdata('table_pengujian');

        $latih_id_pengujian = [];
        foreach ($getConfusion['tb_latih'] as $key => $v_confusion) {
            $latih_id_pengujian[] = $v_confusion->id_label;
        }
        $latih_id_pengujian = implode(',', $latih_id_pengujian);

        $uji_id_pengujian = [];
        foreach ($getConfusion['tb_uji'] as $key => $v_confusion) {
            $uji_id_pengujian[] = $v_confusion->id_label;
        }
        $uji_id_pengujian = implode(',', $uji_id_pengujian);

        $data = [
            'akurasi_pengujian' => $getConfusion['accuracy'],
            'precision_pengujian' => $getConfusion['precision'],
            'recall_pengujian' => $getConfusion['recall'],
            'latih_id_pengujian' => $latih_id_pengujian,
            'uji_id_pengujian' => $uji_id_pengujian,
            'input_latih_pengujian' => $getSessionPengujian['data_latih'],
            'input_uji_pengujian' => $getSessionPengujian['data_uji'],
        ];
        $insert = $this->Pengujian_model->insert($data);
        if ($insert) {
            $this->session->unset_userdata('table_pengujian');
            $this->session->unset_userdata('pengujian');

            $this->session->set_flashdata('success', 'Berhasil menambahkan pengujian');
            return redirect(base_url('Admin/HasilPengujian'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan pengujian');
            return redirect(base_url('Admin/HasilPengujian'));
        }
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
