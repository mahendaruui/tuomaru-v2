<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('my_model');
    if (!$this->session->userdata('id')) {
      $this->session->set_flashdata("msg", "<br/><div class='alert alert-info'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong></strong> Silahkan login terlebih dahulu.
			</div>");
      redirect('login');
    }
  }

  public function index()
  {
    $whereisset = array('no_ujian' => $this->session->userdata('id'));
    $cekissetujian = $this->my_model->cek_data("hasil_tes", $whereisset)->row_array();
    if (isset($cekissetujian)) {
      redirect('dashboard/redirectujian');
    } else {
      $data['title'] = 'Sipenmaru | UUI';
      $where = array('no_ujian' => $this->session->userdata('id'));
      $data['datapeserta'] = $this->my_model->cek_data("pendaftar", $where)->result();

      $this->db->join('jadwal b', 'b.gelombang = a.sesi');
      $cekjadwal = $this->my_model->cek_data("pendaftar a", $where)->result();
      if ($cekjadwal) :
        $data['cekujian'] = $cekjadwal;
        $this->load->view('templates_peserta/header', $data);
        $this->load->view('templates_peserta/topbar', $data);
        $this->load->view('peserta/dashboard', $data);
        $this->load->view('templates_peserta/footer');
      else :
        $this->load->view('templates_peserta/header', $data);
        $this->load->view('templates_peserta/topbar', $data);
        $this->load->view('peserta/dashboard', $data);
        $this->load->view('templates_peserta/footer');
      endif;
    }
  }

  public function profil()
  {
    $data['title'] = "Halaman Profilku";
    $where = array('no_ujian' => $this->session->userdata('id'));
    $dataprofil = $this->my_model->cek_data("pendaftar", $where)->result();
    $data['profilmember'] = $dataprofil;

    $this->load->view('templates_peserta/header', $data);
    $this->load->view('templates_peserta/topbar', $data);
    $this->load->view('peserta/profil', $data);
    $this->load->view('templates_peserta/footer', $data);
  }

  public function lamanUjian()
  {
    //catatan belum cek sesi data. sehingga klw user masuk pada metode ini tanpa tombol start jadi dapat diakses
    $where = array('no_ujian' => $this->session->userdata('id'));
    $dataPeserta = $this->my_model->cek_data("pendaftar", $where)->result();
    // $data['peserta'] = $dataPeserta;

    // $this->db->order_by('id', 'DESC');
    // $where = ['kat' => 'mtk'];
    $where2 = [];
    $this->db->limit(100);
    $soalRandom = $this->my_model->cek_data("m_soal", $where2)->result();
    $data['soal'] = $soalRandom;

    foreach ($dataPeserta as $tesPeserta) {
      $no_peserta = $tesPeserta->no_ujian;
    }

    foreach ($soalRandom as $soal) {
      $idSoal =  $soal->id;

      $dataTes = ['no_ujian' => $no_peserta, 'id_soal' => $idSoal, 'jwb' => ''];

      $simpanDataSoalMember = $this->my_model->tambahdata('hasil_tes', $dataTes);
    }

    if ($simpanDataSoalMember) {
      redirect('dashboard/redirectujian');
    } else {
      echo "404";
    }
  }

  public function redirectujian()
  {
    $whereissetdata = array('no_ujian' => $this->session->userdata('id'));
    $cekissetdata = $this->my_model->cek_data("hasil_tes", $whereissetdata)->row_array();
    if (!isset($cekissetdata)) {
      redirect('dashboard');
    } else {
      $whereMember = array('no_ujian' => $this->session->userdata('id'));

      $dataPeserta = $this->my_model->cek_data("pendaftar", $whereMember)->result();
      foreach ($dataPeserta as $cekujian) :
        if ($cekujian->hadir_tulis == "Y") :
          redirect('dashboard/selesai');
        else :
          $data['peserta'] = $dataPeserta;
          $data['title'] = 'Sipenmaru | Semoga Sukses';
          $this->db->order_by('b.id');
          $where = array('no_ujian' => $this->session->userdata('id'));
          $this->db->join('hasil_tes b', 'b.id_soal = a.id');
          $this->db->limit(100);
          $kirimHasil = $this->my_model->cek_data("m_soal a", $where)->result();
          $data['datatesoke'] = $kirimHasil;
          $data['disablebtn'] = 1;
          $data['wktmundurtes'] = '';

          $this->db->join('pendaftar b', 'b.sesi = a.gelombang');
          $countingtimetes = $this->my_model->cek_data("jadwal a", $where)->result();
          foreach ($countingtimetes as $ctt) {
            $tts = date('Y-m-d H:i:s', $ctt->tgl_tes);
            $data['wktmundurtes'] = date('Y-m-d H:i:s', strtotime($tts . ' + 120 minute'));
          }

          $this->load->view('templates_peserta/header', $data);
          $this->load->view('templates_peserta/topbar', $data);
          $this->load->view('peserta/lamanujian', $data);
          $this->load->view('templates_peserta/footer', $data);
        endif;
      endforeach;
    }
  }

  public function livetesans()
  {
    $idsoal = trim($this->security->xss_clean($this->input->post('idsoal')));
    $jawab = trim($this->security->xss_clean($this->input->post('jawaban')));
    // $status = trim($this->security->xss_clean($this->input->post('status')));
    $where = array('no_ujian' => $this->session->userdata('id'), 'id' => $idsoal);
    $datajwb = array('jwb' => $jawab);
    $this->my_model->update('hasil_tes', $where, $datajwb);
  }

  public function selesai()
  {
    $data['title'] = "Testing Selesai";
    $no_ujian = $this->session->userdata('id');

    // Mark the student as having completed the exam
    $where = array('no_ujian' => $no_ujian);
    $dataupdate = array('hadir_tulis' => 'Y', 'tes_tulis' => 'Y');
    $this->my_model->update('pendaftar', $where, $dataupdate);

    // Calculate exam results
    $hasilBenar = 0;
    $hasilSalah = 0;
    $totalSoal = 0;

    // Get all answers for this student
    $where = array('b.no_ujian' => $no_ujian);
    $this->db->select('b.no_ujian, b.jwb, a.jawaban, a.id');
    $this->db->join('hasil_tes b', 'b.id_soal = a.id');
    $kirimHasil = $this->my_model->cek_data("m_soal a", $where)->result();

    // Count total questions
    $totalSoal = count($kirimHasil);

    // Process each answer
    foreach ($kirimHasil as $hasil) {
      // Only count if the student actually answered (not empty)
      if ($hasil->jwb != '') {
        if ($hasil->jwb == $hasil->jawaban) {
          $hasilBenar++;
        } else {
          $hasilSalah++;
        }
      }
    }

    // Calculate score
    $score = 0;
    if ($totalSoal > 0) {
      $score = round(($hasilBenar / $totalSoal) * 100);
    }

    // Update or insert results
    $whereid = array('no_ujian' => $no_ujian);
    $ceknilaites = $this->my_model->cek_data("nilaites", $whereid)->num_rows();

    if ($ceknilaites < 1) {
      // Insert new record
      $datasink = array(
        'no_ujian' => $no_ujian,
        'jwb_b' => $hasilBenar,
        'jwb_s' => $hasilSalah,
        'nilai' => $score,
        'status' => 'X'
      );
      $this->my_model->tambahdata("nilaites", $datasink);
    } else {
      // Update existing record
      $whereUpdate = array('no_ujian' => $no_ujian);
      $dataSinkUp = array(
        'jwb_b' => $hasilBenar,
        'jwb_s' => $hasilSalah,
        'nilai' => $score
      );
      $this->my_model->update("nilaites", $whereUpdate, $dataSinkUp);
    }

    // Load the completion page
    $wherea = array('a.no_ujian' => $no_ujian);
    $datacekselesai = $this->my_model->cek_data("pendaftar a", $wherea)->result();

    foreach ($datacekselesai as $dp) {
      if ($dp->hadir_tulis == 'Y') {
        $where = ['no_ujian' => $no_ujian];
        $cektestulis = $this->my_model->cek_data('pendaftar', $where)->result();
        $data['cektes'] = $cektestulis;

        $this->db->select('a.no_ujian, b.status, a.hadir_tulis, a.tes_tulis, a.nama, a.foto, b.jwb_b, b.jwb_s');
        $this->db->join('nilaites b', 'a.no_ujian = b.no_ujian');
        $dataPeserta = $this->my_model->cek_data("pendaftar a", $wherea)->result();
        $data['pesertates'] = $dataPeserta;

        $this->load->view('templates_peserta/header', $data);
        $this->load->view('templates_peserta/topbar', $data);
        $this->load->view('peserta/selesai', $data);
        $this->load->view('templates_peserta/footer', $data);
      } else {
        echo "Anda Tidak menghadiri tes tulis";
      }
    }
  }
}
