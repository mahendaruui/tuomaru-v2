<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atursoal extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    // is_logged_in();
    $this->load->helper(array('form', 'url'));
    $this->load->library('user_agent');
    // $this->load->library('form_validation');
  }

  public function simpansoal()
  {
    // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->model('my_model');

    $katsoal = trim($this->security->xss_clean($this->input->post('kat_soal')));
    $pertanyaan = trim($this->security->xss_clean($this->input->post('pertanyaan')));
    $jawabana = trim($this->security->xss_clean($this->input->post('jawabana')));
    $jawabanb = trim($this->security->xss_clean($this->input->post('jawabanb')));
    $jawabanc = trim($this->security->xss_clean($this->input->post('jawabanc')));
    $jawaband = trim($this->security->xss_clean($this->input->post('jawaband')));
    $jawabane = trim($this->security->xss_clean($this->input->post('jawabane')));
    $kuncijwb = trim($this->security->xss_clean($this->input->post('kuncijwb')));
    $bahas = trim($this->security->xss_clean($this->input->post('bahasan')));

    $datainput = array('kat' => $katsoal, 'soal' => $pertanyaan, 'opsi_a' => $jawabana, 'opsi_b' => $jawabanb, 'opsi_c' => $jawabanc, 'opsi_d' => $jawaband, 'opsi_e' => $jawabane, 'jawaban' => $kuncijwb, 'pembahasan' => $bahas, 'tgl_input' => date("Y-m-d H:i:s"));
    $cekinput = $this->my_model->tambahdata("m_soal", $datainput);
    if ($cekinput) {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil Disimpan!!</div></div>");
      redirect('admin/viewsoal');
    } else {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Gagal Disimpan!!</div></div>");
      redirect('admin/viewsoal');
    }
  }

  public function updatesoal()
  {
    // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->model('my_model');

    $idsoal = trim($this->security->xss_clean($this->input->post('idsoal')));
    $kat_soal = trim($this->security->xss_clean($this->input->post('kat_soal')));
    $pertanyaan = trim($this->security->xss_clean($this->input->post('pertanyaan')));
    $jawabana = trim($this->security->xss_clean($this->input->post('jawabana')));
    $jawabanb = trim($this->security->xss_clean($this->input->post('jawabanb')));
    $jawabanc = trim($this->security->xss_clean($this->input->post('jawabanc')));
    $jawaband = trim($this->security->xss_clean($this->input->post('jawaband')));
    $jawabane = trim($this->security->xss_clean($this->input->post('jawabane')));
    $kuncijwb = trim($this->security->xss_clean($this->input->post('kuncijwb')));
    $bahas = trim($this->security->xss_clean($this->input->post('bahasan')));

    // $IDSET = $this->uri->segment(3);
    $whereid = array('id' => $idsoal);
    $data = array('kat' => $kat_soal, 'soal' => $pertanyaan, 'opsi_a' => $jawabana, 'opsi_b' => $jawabanb, 'opsi_c' => $jawabanc, 'opsi_d' => $jawaband, 'opsi_e' => $jawabane, 'jawaban' => $kuncijwb, 'pembahasan' => $bahas, 'tgl_input' => date("Y-m-d H:i:s"));
    $cekinput = $this->my_model->update("m_soal", $whereid, $data);
    if ($cekinput) {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil diupdate!!</div></div>");
      redirect('admin/viewsoal');
    } else {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Gagal diupdate!!</div></div>");
      redirect('admin/viewsoal');
    }
  }

  public function updatejadwal()
  {
    $this->load->model('my_model');

    $id = trim($this->security->xss_clean($this->input->post('idjdw')));
    $tglujian = trim($this->security->xss_clean($this->input->post('tglujian')));
    $wktujian = trim($this->security->xss_clean($this->input->post('wktujian')));
    $aktifkan = trim($this->security->xss_clean($this->input->post('aktifkan')));

    $updujian = strtotime($tglujian . '' . $wktujian);

    if ($aktifkan == "on") {
      $aktifkan = "1";
    } else {
      $aktifkan = "0";
    }


    $whereid = array('id' => $id);
    $data = array('tgl_tes' => $updujian, 'active' => $aktifkan);
    $cekinput = $this->my_model->update("jadwal", $whereid, $data);
    if ($cekinput) {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil diupdate!!</div></div>");
      redirect('admin/jadwal');
    } else {
      $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Gagal diupdate!!</div></div>");
      redirect('admin/jadwal');
    }
  }
}
