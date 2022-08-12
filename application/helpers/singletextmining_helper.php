<?php
class SingleTextMining
{
    public $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model(['PositiveWords/PositiveWords_model', 'NegativeWords/NegativeWords_model', 'Stopwords/Stopwords_model', 'Stemming/Stemming_model']);
    }
    public function caseFolding($text)
    {
        $caseFolding = strtolower($text);
        return $caseFolding;
    }
    public function cleansing($text)
    {
        $cleansing = '';
        $text_clean = preg_replace("/[^a-zA-Z0-9]/", " ", $text);
        $cleansing = $text_clean;
        return $cleansing;
    }
    public function tokenizing($text)
    {
        $tokenizing = '';
        $explode = explode(' ', $text);
        $tokenizing = array_filter($explode);

        return $tokenizing;
    }

    public function stopword($text)
    {
        $stopword = [];
        $text_label = [];
        foreach ($text as $key2 => $r_value) {
            $rows = $this->ci->Stopwords_model->checkWord($r_value)->num_rows();
            if (($rows == 0)) {
                $text_label[] = $r_value;
            }
        }
        $stopword = $text_label;
        return $stopword;
    }

    public function stemming($text)
    {
        $stemming = [];

        $text_label = [];
        foreach ($text as $key2 => $r_value) {

            $rows = $this->ci->Stemming_model->checkWord($r_value)->row();
            if (($rows == null)) {
                $text_label[] = $r_value;
            } else {
                $text_label[] = $rows->akhir_stemming;
            }
        }
        $stemming = $text_label;
        return $stemming;
    }

    public function negation($text)
    {
        $negation = [];
        foreach ($text as $key => $value) {
            $label_text = [];
            $text_label = [];
            $urut = 1;
            foreach ($value['text_label'] as $key2 => $r_value) {
                // positive
                $text_label[] = $r_value;
                $rows_positive = $this->ci->PositiveWords_model->checkWord($r_value)->num_rows();
                if ($rows_positive > 0) {
                    $label_text[] = [
                        'label' => 1,
                    ];
                }
                $rows_negative = $this->ci->NegativeWords_model->checkWord($r_value)->num_rows();
                if ($rows_negative > 0) {
                    $label_text[] = [
                        'label' => -1,
                    ];
                }

                if ($rows_negative == 0 && $rows_positive == 0) {
                    $label_text[] = [
                        'label' => 0,
                    ];
                }
                $urut++;
            }

            // check klasifikasi
            $score_label = '';
            $klasifikasi_label = '';
            foreach ($label_text as $key => $r_label) {
                if ($r_label['label'] == 1 || $r_label['label'] == -1) {
                    $score_label = $r_label['label'];
                    $klasifikasi_label = $score_label == 1 ? 'positif' : ($score_label == -1 ? 'negatif' : 'netral');
                    break;
                } else {
                    $score_label = $r_label['label'];
                    $klasifikasi_label = $score_label == 1 ? 'positif' : ($score_label == -1 ? 'negatif' : 'netral');
                }
            }

            $fix_text_label = implode(' ', $text_label);
            $negation[] = [
                'klasifikasi_label' => $klasifikasi_label,
                'score_label' => $score_label,
                'text_label_hasil' => $fix_text_label,
                'nama_label' => $value['nama_label'],
            ];
        }
        return $negation;
    }
}
