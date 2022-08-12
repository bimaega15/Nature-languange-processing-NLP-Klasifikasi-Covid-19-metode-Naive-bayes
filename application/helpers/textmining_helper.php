<?php
class TextMining
{
    public $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model(['PositiveWords/PositiveWords_model', 'NegativeWords/NegativeWords_model', 'Stopwords/Stopwords_model', 'Stemming/Stemming_model']);
    }
    public function caseFolding($text)
    {
        $caseFolding = [];
        foreach ($text as $key => $value) {
            $caseFolding[$key] = [
                'text_label' => strtolower($value['text_label']),
                'nama_label' => ($value['nama_label']),
            ];
        }
        return $caseFolding;
    }
    public function cleansing($text)
    {
        $cleansing = [];
        foreach ($text as $key => $value) {
            $text_clean = preg_replace("/[^a-zA-Z0-9]/", " ", $value['text_label']);
            $cleansing[$key] = [
                'text_label' => trim($text_clean),
                'nama_label' => ($value['nama_label']),
            ];
        }
        return $cleansing;
    }
    public function tokenizing($text)
    {
        $tokenizing = [];
        foreach ($text as $key => $value) {
            $explode = explode(' ', $value['text_label']);
            $tokenizing[$key] = [
                'text_label' => $explode,
                'nama_label' => ($value['nama_label']),
            ];
        }
        $fix_tokenizing = [];
        foreach ($tokenizing as $key => $value) {
            $fix_tokenizing[$key] = [
                'text_label' => array_filter($value['text_label']),
                'nama_label' => ($value['nama_label']),
            ];
        }
        return $fix_tokenizing;
    }

    public function stopword($text)
    {
        $stopword = [];
        foreach ($text as $key => $value) {
            $text_label = [];
            foreach ($value['text_label'] as $key2 => $r_value) {
                $rows = $this->ci->Stopwords_model->checkWord($r_value)->num_rows();
                if (($rows == 0)) {
                    $text_label[] = $r_value;
                }
            }
            $stopword[$key] = [
                'text_label' => $text_label,
                'nama_label' => ($value['nama_label']),
            ];
        }
        return $stopword;
    }

    public function stemming($text)
    {
        $stemming = [];
        foreach ($text as $key => $value) {
            $text_label = [];
            foreach ($value['text_label'] as $key2 => $r_value) {
                $rows = $this->ci->Stemming_model->checkWord($r_value)->row();

                if (($rows == null)) {
                    $text_label[] = $r_value;
                } else {
                    $text_label[] = $rows->akhir_stemming;
                }
            }
            $stemming[$key] = [
                'text_label' => $text_label,
                'nama_label' => ($value['nama_label']),
            ];
        }
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
