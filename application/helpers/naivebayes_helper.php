<?php
class NaiveBayes
{
    public $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model(['Label_model/Label_model']);
    }
    public function id_label($id_label = [])
    {
        $getDataLabel = $this->ci->Label_model->get(null, $id_label)->result();
        foreach ($getDataLabel as $key => $value) {
            $set_id_label[] = $value->id_label;
        }

        return [
            'id_label' => $set_id_label,
            'getDataLabel' => $getDataLabel,
        ];
    }
    public function document($stemming)
    {
        // document
        $document = [];
        foreach ($stemming as $id_label => $value) {
            $get_data_label = check_label($id_label)->row();
            $document[$get_data_label->score_label][] = $get_data_label->id_label;
        }
        // total document
        $totalDocument = [];
        $count_document = count($stemming);
        foreach ($document as $class => $value) {
            $count = count($value);
            $totalDocument[$class] = $count / $count_document;
        }
        return [
            'document' => $document,
            'totalDocument' => $totalDocument,
        ];
    }
    public function pengkondisianClass($stemming)
    {
        // gabungkan semua data jika ada yang sama
        $gabungkan_kata = [];
        foreach ($stemming as $id_label => $v_label) {
            $arr_text_label = $v_label['text_label'];
            foreach ($arr_text_label as $key => $value) {
                $gabungkan_kata[$value][] = $id_label;
            }
        }

        // melihat class
        $showClass = [];
        foreach ($gabungkan_kata as $text => $value) {
            foreach ($value as $key => $id_label) {
                $check_data_label = check_label($id_label)->row();
                $score_label = $check_data_label->score_label;
                $showClass[$text][$score_label][] = $id_label;
            }
        }

        // banyaknya class
        $banyakClass = [];
        foreach ($showClass as $text => $data_class) {
            foreach ($data_class as $class => $value) {
                $banyakClass[$class][] = $class;
            }
        }

        // total class
        $totalClass = 0;
        foreach ($banyakClass as $class => $dataClass) {
            $count = count($dataClass);
            $totalClass += $count;
        }
        return [
            'gabungkan_kata' => $gabungkan_kata,
            'showClass' => $showClass,
            'banyakClass' => $banyakClass,
            'totalClass' => $totalClass,
        ];
    }

    public function elemenPerText($hasil_akhir, $banyakClass, $totalClass, $showClass)
    {
        $elemenPerText = [];
        foreach ($hasil_akhir as $key => $v_text) {
            // positif
            if (isset($showClass[$v_text][1])) {
                $countClass = count($showClass[$v_text][1]);
            } else {
                $countClass = 0;
            }
            $hitung = ($countClass + 1) / (count($banyakClass[1]) + $totalClass);
            $elemenPerText[$v_text][1] = $hitung;

            // netral
            if (isset($showClass[$v_text][0])) {
                $countClass = count($showClass[$v_text][0]);
            } else {
                $countClass = 0;
            }

            $hitung = ($countClass + 1) / (count($banyakClass[0]) + $totalClass);
            $elemenPerText[$v_text][0] = $hitung;


            // negatif
            if (isset($showClass[$v_text][-1])) {
                $countClass = count($showClass[$v_text][-1]);
            } else {
                $countClass = 0;
            }
            $hitung = ($countClass + 1) / (count($banyakClass[-1]) + $totalClass);
            $elemenPerText[$v_text][-1] = $hitung;
        }
        return $elemenPerText;
    }

    public function cariTotal($elemenPerText, $totalDocument)
    {
        // cari hasil data terbaru
        $gabungkanHasil = [];
        foreach ($elemenPerText as $text => $dataClass) {
            foreach ($dataClass as $class => $value) {
                $gabungkanHasil[$class][] = $value;
            }
        }

        // cari total
        $totalHasil = [];
        foreach ($gabungkanHasil as $class => $value) {
            $total = 1;
            foreach ($value as $key => $row) {
                $total *= $row;
            }
            $valueDocument = $totalDocument[$class];
            $total *= $valueDocument;

            $totalHasil[$class] = $total;
        }

        return [
            'gabungkanHasil' => $gabungkanHasil,
            'totalHasil' => $totalHasil,
        ];
    }
    public function hasilKlasifikasi($totalHasil, $data_text)
    {
        $max = max($totalHasil);
        $search = array_search($max, $totalHasil);
        $outputAkhir = [
            'text_label' => $data_text,
            'klasifikasi' => $search,
            'hasil' => $max,
        ];
        return $outputAkhir;
    }
    public function confusionMatrix($getSession)
    {
        // perbandingan data uji
        $confusionMatrix = [];
        $dataUji = [];
        foreach ($getSession['hasil'] as $key => $value) {
            $get_data_label = check_label($value['id_label'])->row();
            $confusionMatrix[$get_data_label->score_label][$value['klasifikasi']][] = $value['klasifikasi'];

            $boolean = false;
            if ($get_data_label->score_label == $value['klasifikasi']) {
                $boolean = true;
            }
            $arr_label = (array) $get_data_label;
            $merge = array_merge($arr_label, [
                'klasifikasi' => $value['klasifikasi'],
                'hasil_banding' => $boolean
            ]);
            $dataUji[] = (object) $merge;
        }

        $pPositif = isset($confusionMatrix[1][1]) ? count($confusionMatrix[1][1]) : 0;
        $pNegatif = isset($confusionMatrix[1][-1]) ? count($confusionMatrix[1][-1]) : 0;
        $pNetral = isset($confusionMatrix[1][0]) ? count($confusionMatrix[1][0]) : 0;

        $nPositif = isset($confusionMatrix[-1][1]) ? count($confusionMatrix[-1][1]) : 0;
        $nNegatif = isset($confusionMatrix[-1][-1]) ? count($confusionMatrix[-1][-1]) : 0;
        $nNetral = isset($confusionMatrix[-1][0]) ? count($confusionMatrix[-1][0]) : 0;

        $netPositif = isset($confusionMatrix[0][1]) ? count($confusionMatrix[0][1]) : 0;
        $netNegatif = isset($confusionMatrix[0][-1]) ? count($confusionMatrix[0][-1]) : 0;
        $netNetral = isset($confusionMatrix[0][0]) ? count($confusionMatrix[0][0]) : 0;

        $accuracy = ($pPositif + $nNegatif + $netNetral) / ($pPositif + $pNegatif + $pNetral + $nPositif + $nNegatif + $nNetral + $netPositif + $netNegatif + $netNetral);

        $fpPositive = ($pPositif + $pNegatif + $pNetral);
        $fpNegative = ($nNegatif + $nPositif + $nNetral);
        $fpNetral = ($netNetral + $netPositif + $netNegatif);

        if ($pPositif == 0 && $fpPositive == 0) {
            $precisionPositive = 0;
        } else {
            $precisionPositive = ($pPositif) / ($fpPositive);
        }

        if ($nNegatif == 0 && $fpNegative == 0) {
            $precisionNegative = 0;
        } else {
            $precisionNegative = ($nNegatif) / ($fpNegative);
        }

        if ($netNetral == 0 && $fpNetral == 0) {
            $precisionNetral = 0;
        } else {
            $precisionNetral = ($netNetral) / ($fpNetral);
        }
        $precision = ($precisionPositive + $precisionNegative + $precisionNetral) / 3;

        $fnPositive = ($pPositif + $nPositif + $netPositif);
        $fnNegative = ($nNegatif + $pNegatif + $netNegatif);
        $fnNetral = ($netNetral + $pNetral + $nNetral);

        if ($pPositif == 0 && $fnPositive == 0) {
            $recallPositive = 0;
        } else {
            $recallPositive = ($pPositif) / ($fnPositive);
        }

        if ($nNegatif == 0 && $fnNegative == 0) {
            $recallNegative = 0;
        } else {
            $recallNegative = ($nNegatif) / ($fnNegative);
        }

        if ($netNetral == 0 && $fnNetral == 0) {
            $recallNetral = 0;
        } else {
            $recallNetral = ($netNetral) / ($fnNetral);
        }
        $recall = ($recallPositive + $recallNegative + $recallNetral) / 3;


        return [
            'dataUji' => $dataUji,
            'accuracy' => $accuracy,
            'precision' => $precision,
            'recall' => $recall,

            'pPositif' => $pPositif,
            'pNegatif' => $pNegatif,
            'pNetral' => $pNetral,

            'nPositif' => $nPositif,
            'nNegatif' => $nNegatif,
            'nNetral' => $nNetral,

            'netPositif' => $netPositif,
            'netNegatif' => $netNegatif,
            'netNetral' => $netNetral,
        ];
    }
}
