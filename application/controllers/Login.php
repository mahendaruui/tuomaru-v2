<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    // is_logged_in();
    $this->load->model('my_model');


    // $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = "Tes Online Sipenmaru";

    $this->load->view('auth/member', $data);
  }

  function readlogin($id,$pass){
    $username = $id;
    $password = $pass;

    $where = array('no_ujian' => $username, 'pass' => $password);

    $cekmember = $this->my_model->cek_data("pendaftar", $where)->row_array();
    if (!$cekmember) {
      $this->session->set_userdata('member_msg', "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Username atau password salah.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
      redirect('login');
    } else {
      $data = [
        'id' => $cekmember['no_ujian'],
        'nama' => $cekmember['nama']
      ];
      $this->session->set_userdata($data);
      redirect('dashboard');
    }
  }

  function ceklogin()
  {
    $username = trim($this->security->xss_clean($this->input->post('username')));
    $password = trim($this->security->xss_clean($this->input->post('password')));

    $where = array('no_ujian' => $username, 'pass' => $password);

    $cekmember = $this->my_model->cek_data("pendaftar", $where)->row_array();
    if (!$cekmember) {
      $this->session->set_userdata('member_msg', "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Username atau password salah.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
      redirect('login');
    } else {
      $data = [
        'id' => $cekmember['no_ujian'],
        'nama' => $cekmember['nama']
      ];
      $this->session->set_userdata($data);
      redirect('dashboard');
    }
  }

  public function logout()
  {

    $this->session->sess_destroy();

    $this->session->set_userdata('member_msg', "<div class='alert alert-success alert-dismissible fade show' role='alert'>Anda berhasil logout.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
    redirect('login');
  }
}
