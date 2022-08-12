<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['PositiveWords/PositiveWords_model', 'NegativeWords/NegativeWords_model', 'Stopwords/Stopwords_model', 'Stemming/Stemming_model', 'Label/Label_model', 'Hasil/Hasil_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Analisa Sentimen', 'Admin/Metode');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Analisa Sentimen';
        $this->template->admin('admin/metode/main', $data);
    }
    public function analisa()
    {
        // label class
        $save_array = [];
        $metode = new NaiveBayes();
        $id_label = [];
        $id_label = $metode->id_label()['id_label'];
        $getDataLabel = $metode->id_label()['getDataLabel'];
        $save_array['naive_bayes']['id_label'] = $id_label;

        // text processing single
        $data_text = $this->input->post('text_sentimen', true);
        $data_text = preg_replace('#</?(p).*?>#is', '', $data_text);
        $save_array['naive_bayes']['sentimen']['text_sentimen'] = $data_text;

        $caseFolding = '';
        $text_mining = new SingleTextMining();
        $caseFolding = $text_mining->caseFolding($data_text);
        $save_array['naive_bayes']['sentimen']['caseFolding'] = $caseFolding;


        $cleansing = '';
        $cleansing = $text_mining->cleansing($caseFolding);
        $save_array['naive_bayes']['sentimen']['cleansing'] = $cleansing;


        $tokenizing = '';
        $tokenizing = $text_mining->tokenizing($cleansing);
        $save_array['naive_bayes']['sentimen']['tokenizing'] = $tokenizing;


        $stopword = '';
        $stopword = $text_mining->stopword($tokenizing);
        $save_array['naive_bayes']['sentimen']['stopword'] = $stopword;

        $stemming = '';
        $stemming = $text_mining->stemming($stopword);
        $save_array['naive_bayes']['sentimen']['stemming'] = $stemming;

        $hasil_akhir = $stemming;
        $save_array['naive_bayes']['sentimen']['hasil_akhir'] = $hasil_akhir;

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
        $save_array['naive_bayes']['perhitungan']['totalDocument'] = $totalDocument;

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
        $save_array['naive_bayes']['perhitungan']['elemenPerText'] = $elemenPerText;

        // cari hasil data terbaru
        $gabungkanHasil = [];
        $gabungkanHasil = $metode->cariTotal($elemenPerText, $totalDocument)['gabungkanHasil'];

        // cari total
        $totalHasil = [];
        $totalHasil = $metode->cariTotal($elemenPerText, $totalDocument)['totalHasil'];
        $save_array['naive_bayes']['perhitungan']['totalHasil'] = $totalHasil;


        // hasil klasifikasi
        $outputAkhir = $metode->hasilKlasifikasi($totalHasil, $data_text);
        $save_array['naive_bayes']['output'] = $outputAkhir;
        $this->session->set_userdata($save_array);
        return redirect(base_url('Admin/Metode/HasilAnalisa'));
    }

    public function HasilAnalisa()
    {
        if (!($this->session->has_userdata('naive_bayes'))) {
            $this->session->set_flashdata('error', 'Belum melakukan analisa text sentimen');
            return redirect(base_url('Admin/Metode'));
        }
        $getSession = $this->session->userdata('naive_bayes');

        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Analisa Sentimen', 'Admin/Metode');
        $this->breadcrumbs->push('Hasil analisa', 'Admin/Metode/HasilAnalisa');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Hasil analisa';
        $data['naive_bayes'] = $getSession;

        $this->template->admin('admin/metode/hasil', $data);
    }

    public function submit()
    {
        if (!($this->session->has_userdata('naive_bayes'))) {
            $this->session->set_flashdata('error', 'Belum melakukan analisa text sentimen');
            return redirect(base_url('Admin/Metode'));
        }
        $getSession = $this->session->userdata('naive_bayes');
        $klasifikasi = $getSession['output']['klasifikasi'] == 1 ? 'positif' : ($getSession['output']['klasifikasi'] == 0 ? 'netral' : 'negatif');
        $data = [
            'text_hasil' => $getSession['output']['text_label'],
            'klasifikasi_hasil' => $klasifikasi,
            'nilai_hasil' => $getSession['output']['hasil'],
            'label_id' => implode(',',  $getSession['id_label']),
        ];
        $insert = $this->Hasil_model->insert($data);
        if ($insert) {
            $this->session->unset_userdata('naive_bayes');
            $this->session->set_flashdata('success', 'Berhasil simpan data hasil sentimen');
            return redirect(base_url('Admin/HasilSentimen'));
        } else {
            $this->session->set_flashdata('error', 'Gagal simpan data hasil sentimen');
            return redirect(base_url('Admin/Metode'));
        }
    }
}
