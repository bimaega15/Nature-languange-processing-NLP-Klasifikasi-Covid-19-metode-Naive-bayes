<?php
function check_already_login()
{
    $ci = &get_instance();

    $session = $ci->session->userdata('id_admin');
    if (!empty($session)) {
        redirect(base_url('Admin/Home'));
    }
}
function tanggal_indo($tanggal = null)
{
    if ($tanggal != null) {
        $explode = explode('-', $tanggal);
        $data_tanggal = [];
        $data_tanggal[0] = $explode[2];
        $data_tanggal[1] = $explode[1];
        $data_tanggal[2] = $explode[0];
        $output = implode('-', $data_tanggal);
        return $output;
    }
}
function check_not_login()
{
    $ci = &get_instance();
    if (!$ci->session->has_userdata('id_admin')) {
        redirect(base_url('Login'));
    }
}
function numeric($number)
{
    $output = number_format($number, 0, '.', ',');
    return $output;
}
function check_profile()
{
    $ci = &get_instance();
    $session_id = $ci->session->userdata('id_admin');
    $rows = $ci->db->get_where('admin', ['id_admin' => $session_id])->row();
    return $rows;
}

function bulan_laporan($data)
{
    $bulan = [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    return $bulan[$data];
}

function wordTextSlider($text, $limit)
{
    if (strlen($text) > $limit) {
        $word = strip_tags($text);
        $word = mb_substr($word, 0, $limit) . " ... ";
    } else {
        $word = $text;
    }
    return ($word);
}
function rupiah($nominal)
{
    $get = number_format($nominal, 0, '.', ',');
    return $get;
}
function konfigurasi()
{
    $ci = &get_instance();
    $get = $ci->db->get('konfigurasi')->row();
    return $get;
}
function check_disposisi($id_disposisi = null)
{
    $ci = &get_instance();
    $ci->load->model('Disposisi/Disposisi_model');
    $get = $ci->Disposisi_model->get($id_disposisi);
    return $get;
}
function get_setdata()
{
    $ci = &get_instance();
    $ci->load->model('SetData_model');
    $data = $ci->SetData_model->allData()->result();

    $fix_data = [];
    foreach ($data as $key => $r_data) {
        $fix_data[$r_data->id_setdata][] = [
            'nama_sub_dataset' => $r_data->nama_sub_dataset
        ];
    }
    $result = [];
    $no = 1;
    $dataset = $ci->Dataset_model->get()->num_rows();

    if ($data == null) {
        $push[0] = 'tidak ada';
        $push[1] = 'tidak ada';

        for ($i = 1; $i <= $dataset; $i++) {
            array_push($push, 'tidak ada');
        }
        $result['data'] = $push;
    } else {
        $no = 1;
        foreach ($fix_data as $id_setdata => $v_data) {
            $push[0] = $no++;
            foreach ($v_data as $index => $r_data) {
                array_push($push, $r_data['nama_sub_dataset']);
            }
            array_push($push, '
            <div class="text-center">
                <a href="' . base_url('Admin/SetData/edit/' . $id_setdata) . '" class="btn btn-warning btn-edit" data-id_setdata="' . $id_setdata . '">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a href="' . base_url('Admin/SetData/delete/' . $id_setdata) . '" class="btn btn-danger btn-delete" data-id_setdata="' . $id_setdata . '">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
            ');
        }
    }

    $result['data'] = $push;
    return $result;
}

function check_dataset($id = null)
{
    $ci = &get_instance();
    $ci->load->model('Dataset/Dataset_model');
    $get = $ci->Dataset_model->get($id);
    return $get;
}
function check_label($id_label = null)
{
    $ci = &get_instance();
    $ci->load->model('Label/Label_model');
    $get = $ci->Label_model->get($id_label);
    return $get;
}
