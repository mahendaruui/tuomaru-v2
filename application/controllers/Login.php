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
      $this->session->set_flashdata("msg", "<br/><div class='alert alert-danger' role='alert'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      Username atau Password Salah!!.
      </div>");
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
      $this->session->set_flashdata("msg", "<br/><div class='alert alert-danger' role='alert'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			Username atau Password Salah!!.
      </div>");
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

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
    redirect('login');
  }
}
