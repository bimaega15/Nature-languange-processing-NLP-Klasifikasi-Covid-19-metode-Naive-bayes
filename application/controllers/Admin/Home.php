<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();

        if (!$this->session->has_userdata('id_admin')) {
            show_404();
        }
        $this->load->model(['NegativeWords/NegativeWords_model', 'PositiveWords/PositiveWords_model', 'Label/Label_model', 'Stopwords/Stopwords_model', 'Stemming/Stemming_model', 'Hasil/Hasil_model', 'Users/Users_model', 'Pengujian/Pengujian_model', 'Hasil/Hasil_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Dashboard';
        $data['admin'] = $this->Users_model->get()->num_rows();
        $data['negative_words'] = $this->NegativeWords_model->get()->num_rows();
        $data['positive_words'] = $this->PositiveWords_model->get()->num_rows();
        $data['label'] = $this->Label_model->get()->num_rows();
        $data['stopword'] = $this->Stopwords_model->get()->num_rows();
        $data['stemming'] = $this->Stemming_model->get()->num_rows();
        $data['pengujian'] = $this->Pengujian_model->get()->num_rows();
        $data['hasil'] = $this->Hasil_model->get()->num_rows();
        $this->template->admin('admin/home/main', $data);
    }
}
