<?php
class Template
{
    protected $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
    }
    public function home($template, $data = null)
    {
        $data['content'] = $this->ci->load->view($template, $data, true);
        $this->ci->load->view('home', $data);
    }
    public function login($template, $data = null)
    {
        $data['content'] = $this->ci->load->view($template, $data, true);
        $this->ci->load->view('login', $data);
    }
    public function admin($template, $data = null)
    {
        $data['sidebar'] = $this->ci->load->view('template/admin/partials/sidebar.php', $data, true);
        $data['header'] = $this->ci->load->view('template/admin/partials/header.php', $data, true);
        $data['footer'] = $this->ci->load->view('template/admin/partials/footer.php', null, true);
        $data['content'] = $this->ci->load->view($template, $data, true);
        $data['right_sidebar'] = $this->ci->load->view('template/admin/partials/right_sidebar.php', null, true);

        $this->ci->load->view('template/admin/main', $data);
    }
    public function warga($template, $data = null)
    {
        $data['sidebar'] = $this->ci->load->view('template/partialwarga/sidebar', $data, true);
        $data['topbar'] = $this->ci->load->view('template/partialwarga/topbar', $data, true);
        $data['content'] = $this->ci->load->view($template, $data, true);
        $data['footer'] = $this->ci->load->view('template/partialwarga/footer', null, true);

        $this->ci->load->view('template/admin/main', $data);
    }
    public function kepdes($template, $data = null)
    {
        $data['right_sidebar'] = $this->ci->load->view('template/partialadmin/right_sidebar', $data, true);

        $data['sidebar'] = $this->ci->load->view('template/partialkepdes/sidebar', $data, true);
        $data['topbar'] = $this->ci->load->view('template/partialkepdes/topbar', $data, true);
        $data['content'] = $this->ci->load->view($template, $data, true);
        $data['footer'] = $this->ci->load->view('template/partialkepdes/footer', null, true);

        $this->ci->load->view('template/admin/main', $data);
    }
    public function pengurus($template, $data = null)
    {
        $data['right_sidebar'] = $this->ci->load->view('template/partialadmin/right_sidebar', $data, true);

        $data['sidebar'] = $this->ci->load->view('template/partialpengurus/sidebar', $data, true);
        $data['topbar'] = $this->ci->load->view('template/partialpengurus/topbar', $data, true);
        $data['content'] = $this->ci->load->view($template, $data, true);
        $data['footer'] = $this->ci->load->view('template/partialpengurus/footer', null, true);

        $this->ci->load->view('template/admin/main', $data);
    }
}
