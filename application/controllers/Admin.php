<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('my_model');


        // $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // count peserta ujian
        $jdw = $this->my_model->tampil('jadwal')->num_rows();
        $data1 = [];

        for ($i = 1; $i <= $jdw; $i++) {
            $where1 = ['sesi' =>  $i];
            $jmlpesertaa = $this->my_model->cek_data('pendaftar', $where1)->result();
            foreach ($jmlpesertaa as $j) {
                $data1[] = $j->sesi;
            }
        }
        $data['jmlpeserta'] = $data1;
        $data['jmlpesertaCount'] = count($data1);

        // count peserta sudah ujian
        $sudahtes = array('hadir_tulis' => "Y");
        $data['jmlselesai'] = $this->my_model->cek_data('pendaftar', $sudahtes)->num_rows();

        // yang belum ikuti ujian
        $sudahtes = array('hadir_tulis' => "N");
        $data['jmlbelum'] = $this->my_model->cek_data('pendaftar', $sudahtes)->num_rows();

        // count soal
        $data['jmlsoal'] = $this->my_model->tampil('m_soal')->num_rows();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/index_v2', $data);
        $this->load->view('templates_v2/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/role_v2', $data);
        $this->load->view('templates_v2/footer');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/role-access_v2', $data);
        $this->load->view('templates_v2/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function viewpeserta()
    {
        $this->load->model('my_model');
        $data['title'] = 'Peserta';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Cari id_jdwl terbaru yang tidak null
        $latestRow = $this->db
            ->select('id_jdwl')
            ->where('id_jdwl IS NOT NULL')
            ->order_by('id_jdwl', 'DESC')
            ->limit(1)
            ->get('pendaftar')
            ->row();

        $jadwal = $latestRow ? $latestRow->id_jdwl : null;

        $this->db->order_by('id', 'DESC');
        if ($jadwal !== null) {
            // Tampilkan peserta gelombang terkini
            $pendaftar = $this->my_model->cek_data('pendaftar', ['id_jdwl' => $jadwal]);
        } else {
            // Belum ada jadwal — tampilkan semua peserta
            $pendaftar = $this->my_model->tampil('pendaftar');
        }
        $data['pendaftar'] = $pendaftar->result();

    $this->load->view('templates_v2/header', $data);
    $this->load->view('templates_v2/sidebar', $data);
    $this->load->view('templates_v2/topbar', $data);
    $this->load->view('admin/peserta_v2', $data);
    $this->load->view('templates_v2/footer');
    }

    public function downloadTemplatePeserta()
    {
        is_logged_in();

        require_once FCPATH . 'vendor/autoload.php';

        $prodiList = $this->db
            ->select('id_prodi, nama_prodi, id_fakultas')
            ->where('status', 'Y')
            ->order_by('id_fakultas', 'ASC')
            ->get('prodi')
            ->result();

        $fakultasMap = [
            '1001' => 'Fakultas Ekonomi',
            '1002' => 'Fakultas Hukum',
            '1003' => 'Fakultas Ilmu Komputer',
            '1004' => 'Fakultas Keguruan dan Ilmu Pendidikan',
            '1005' => 'Fakultas Ilmu Kesehatan',
            '1006' => 'Fakultas Teknik',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // ── Sheet 1: Template Data ────────────────────────────────────────
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Template Data');

        $headers = [
            'A' => ['label' => 'Nomor Ujian',               'field' => 'no_ujian'],
            'B' => ['label' => 'Nama Lengkap',               'field' => 'nama'],
            'C' => ['label' => 'Tempat Lahir',               'field' => 'tempat'],
            'D' => ['label' => 'Tanggal Lahir (YYYY-MM-DD)', 'field' => 'tanggal'],
            'E' => ['label' => 'Jenis Kelamin (L/P)',        'field' => 'jenkel'],
            'F' => ['label' => 'Email',                      'field' => 'email'],
            'G' => ['label' => 'No. HP',                     'field' => 'hp'],
            'H' => ['label' => 'NIK (No. Identitas)',        'field' => 'no_identitas'],
            'I' => ['label' => 'Asal Sekolah',               'field' => 'asal_sekolah'],
            'J' => ['label' => 'Agama',                      'field' => 'agama'],
            'K' => ['label' => 'Alamat',                     'field' => 'alamat'],
            'L' => ['label' => 'Desa',                       'field' => 'alamat_desa'],
            'M' => ['label' => 'Kecamatan',                  'field' => 'alamat_kec'],
            'N' => ['label' => 'Kota/Kabupaten',             'field' => 'alamat_kota'],
            'O' => ['label' => 'Provinsi',                   'field' => 'alamat_prov'],
            'P' => ['label' => 'Kode Program Studi',         'field' => 'prodi'],
        ];

        // Style header — biru
        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        foreach ($headers as $colLetter => $info) {
            $sheet1->setCellValue($colLetter . '1', $info['label']);
            $sheet1->getStyle($colLetter . '1')->applyFromArray($headerStyle);
            $sheet1->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Freeze header row
        $sheet1->freezePane('A2');

        // ── Sheet 2: Referensi Prodi ──────────────────────────────────────
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Referensi Prodi');

        // Judul
        $sheet2->mergeCells('A1:C1');
        $sheet2->setCellValue('A1', 'REFERENSI KODE PROGRAM STUDI');
        $sheet2->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ED7D31']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Header kolom
        $refHeaders = ['A2' => 'Kode Prodi', 'B2' => 'Nama Program Studi', 'C2' => 'Fakultas'];
        foreach ($refHeaders as $cell => $label) {
            $sheet2->setCellValue($cell, $label);
            $sheet2->getStyle($cell)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
            ]);
        }

        $row = 3;
        foreach ($prodiList as $prodi) {
            $namaFakultas = $fakultasMap[$prodi->id_fakultas] ?? $prodi->id_fakultas;
            $sheet2->setCellValue("A$row", $prodi->id_prodi);
            $sheet2->setCellValue("B$row", $prodi->nama_prodi);
            $sheet2->setCellValue("C$row", $namaFakultas);
            $sheet2->getStyle("A$row")->getFont()->setBold(true);
            $row++;
        }

        $sheet2->getColumnDimension('A')->setWidth(14);
        $sheet2->getColumnDimension('B')->setAutoSize(true);
        $sheet2->getColumnDimension('C')->setAutoSize(true);

        // Kembali ke sheet pertama
        $spreadsheet->setActiveSheetIndex(0);

        // Output XLSX
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_peserta.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function importPeserta()
    {
        is_logged_in();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['file_csv']['tmp_name'])) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Tidak ada file yang diupload.</div>');
            redirect('admin/viewpeserta');
            return;
        }

        require_once FCPATH . 'vendor/autoload.php';

        $file = $_FILES['file_csv'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Format file harus <strong>.xlsx</strong>, .xls, atau .csv.</div>');
            redirect('admin/viewpeserta');
            return;
        }

        try {
            $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file['tmp_name']);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file['tmp_name']);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, false);
        } catch (\Exception $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal membaca file: ' . htmlspecialchars($e->getMessage()) . '</div>');
            redirect('admin/viewpeserta');
            return;
        }

        $row      = 0;
        $inserted = 0;
        $skipped  = 0;
        $errors   = [];

        foreach ($rows as $line) {
            $row++;

            // Lewati baris header (baris pertama)
            if ($row === 1) continue;

            // Lewati baris kosong
            if (empty(array_filter($line, fn($v) => $v !== null && $v !== ''))) continue;

            $noUjian   = trim((string)($line[0]  ?? ''));
            $nama      = trim((string)($line[1]  ?? ''));
            $tempat    = trim((string)($line[2]  ?? ''));
            $tanggal   = trim((string)($line[3]  ?? ''));
            $jenkel    = strtoupper(trim((string)($line[4]  ?? '')));
            $email     = trim((string)($line[5]  ?? ''));
            $hp        = trim((string)($line[6]  ?? ''));
            $nik       = trim((string)($line[7]  ?? ''));
            $sekolah   = trim((string)($line[8]  ?? ''));
            $agama     = trim((string)($line[9]  ?? ''));
            $alamat    = trim((string)($line[10] ?? ''));
            $desa      = trim((string)($line[11] ?? ''));
            $kec       = trim((string)($line[12] ?? ''));
            $kota      = trim((string)($line[13] ?? ''));
            $prov      = trim((string)($line[14] ?? ''));
            // index 15 = kode prodi, diabaikan sementara

            if (empty($noUjian) || empty($nama)) {
                $errors[] = "Baris $row: no_ujian atau nama kosong, dilewati.";
                $skipped++;
                continue;
            }

            if (!in_array($jenkel, ['L', 'P', ''])) {
                $errors[] = "Baris $row ($noUjian): jenis kelamin harus L atau P, dilewati.";
                $skipped++;
                continue;
            }

            // Cek duplikat no_ujian
            if ($this->db->get_where('pendaftar', ['no_ujian' => $noUjian])->row()) {
                $errors[] = "Baris $row: no_ujian '$noUjian' sudah ada, dilewati.";
                $skipped++;
                continue;
            }

            // Cek duplikat email (hanya jika diisi)
            if ($email !== '' && $this->db->get_where('pendaftar', ['email' => $email])->row()) {
                $errors[] = "Baris $row ($noUjian): email '$email' sudah terdaftar, dilewati.";
                $skipped++;
                continue;
            }

            // Cek duplikat no HP (hanya jika diisi)
            if ($hp !== '' && $this->db->get_where('pendaftar', ['hp' => $hp])->row()) {
                $errors[] = "Baris $row ($noUjian): no HP '$hp' sudah terdaftar, dilewati.";
                $skipped++;
                continue;
            }

            // Generate password acak 5 karakter (huruf besar + angka)
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $pass  = '';
            for ($i = 0; $i < 5; $i++) {
                $pass .= $chars[random_int(0, strlen($chars) - 1)];
            }

            $data = [
                'no_ujian'     => $noUjian,
                'nama'         => $nama,
                'tempat'       => $tempat,
                'tanggal'      => ($tanggal !== '') ? $tanggal : null,
                'jenkel'       => $jenkel,
                'email'        => $email,
                'hp'           => $hp,
                'no_identitas' => $nik,
                'asal_sekolah' => $sekolah,
                'agama'        => $agama,
                'alamat'       => $alamat,
                'alamat_desa'  => $desa,
                'alamat_kec'   => $kec,
                'alamat_kota'  => $kota,
                'alamat_prov'  => $prov,
                'pass'         => $pass,
                'tgl_daftar'   => date('Y-m-d'),
                'hadir_tulis'  => 'N',
                'tes_tulis'    => 'N',
            ];

            $this->db->insert('pendaftar', $data);
            $inserted++;
        }

        $type = ($inserted > 0) ? 'success' : 'warning';
        $msg  = "Berhasil import <strong>$inserted</strong> data peserta.";
        if ($skipped > 0) {
            $msg .= " <strong>$skipped</strong> baris dilewati.";
        }
        if (!empty($errors)) {
            $msg .= '<ul class="mt-2 mb-0 small">';
            foreach (array_slice($errors, 0, 10) as $e) {
                $msg .= '<li>' . htmlspecialchars($e) . '</li>';
            }
            if (count($errors) > 10) {
                $msg .= '<li>... dan ' . (count($errors) - 10) . ' lainnya</li>';
            }
            $msg .= '</ul>';
        }

        $this->session->set_userdata('import_msg', "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>{$msg}<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
        redirect('admin/viewpeserta');
    }

    public function viewsoal()
    {
        $this->load->model('my_model');
        $data['title'] = 'Bank Soal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilsoal = $this->my_model->tampil("m_soal");
        $data['soal'] = $tampilsoal->result();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/soal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function tambahsoal()
    {
        $this->load->model('my_model');
        $data['title'] = 'Form Input Soal Test';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/inputsoal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function hapussoal()
    {
        $this->load->model('my_model');
        $IDSET = $this->uri->segment(3);
        $where = array('id' => $IDSET);
        $hapussoal = $this->my_model->hapus("m_soal", $where);
        if ($hapussoal) {
            $this->session->set_userdata("soal_msg", "<div class='alert alert-success alert-dismissible fade show' role='alert'>Data berhasil dihapus.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_userdata("soal_msg", "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Data gagal dihapus.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function editsoal()
    {
        $this->load->model('my_model');
        $data['title'] = 'Edit Pertanyaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $IDSET = $this->uri->segment(3);
        $whereid = array('id' => $IDSET);
        $tampilsoal = $this->my_model->cek_data("m_soal", $whereid);
        $data['datasoal'] = $tampilsoal->result();
        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/editsoal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function detailsoal()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Detail Pertanyaan';
        $IDSET = $this->uri->segment(3);
        $whereid = array('id' => $IDSET);
        $tampilsoal = $this->my_model->cek_data("m_soal", $whereid);
        $data['detailsoal'] = $tampilsoal->result();
        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/detailsoal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function detailmember()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Detail Peserta';
        $IDSET = $this->uri->segment(3);
        $whereid = array('id' => $IDSET);
        $tampilsoal = $this->my_model->cek_data("pendaftar", $whereid);
        $data['detailmember'] = $tampilsoal->result();
        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/detailmember_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function jadwal()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Manajemen Tes';

        $tampiljadwal = $this->my_model->tampil("jadwal");
        $data['jadwaltes'] = $tampiljadwal->result();

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/jadwal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function tambahjadwal()
    {
        $gelombang = trim($this->security->xss_clean($this->input->post('gelombang')));
        $tglujian = trim($this->security->xss_clean($this->input->post('tglujian')));
        $wktujian = trim($this->security->xss_clean($this->input->post('wktujian')));
        $aktifkan = trim($this->security->xss_clean($this->input->post('aktifkan')));

        // $tgltes = strtotime($tglujian + $wktujian);
        $tgltes = strtotime($tglujian . ' ' . $wktujian);


        $where = array('gelombang' => $gelombang, 'tgl_tes' => $tgltes, 'active' => $aktifkan, 'created' => date('Y-m-d'));
        $cekinput = $this->my_model->tambahdata("jadwal", $where);
        if ($cekinput === TRUE) {
            $this->session->set_userdata("jadwal_msg", "<div class='alert alert-success alert-dismissible fade show' role='alert'>Jadwal berhasil disimpan.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect('admin/jadwal');
        } else {
            $this->session->set_userdata("jadwal_msg", "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Jadwal gagal disimpan.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect('admin/jadwal');
        }
    }

    public function hapusjdw()
    {
        $this->load->model('my_model');
        $IDSET = $this->uri->segment(3);
        $where = array('id' => $IDSET);
        $hapussoal = $this->my_model->hapus("jadwal", $where);
        if ($hapussoal) {
            $this->session->set_userdata("jadwal_msg", "<div class='alert alert-success alert-dismissible fade show' role='alert'>Jadwal berhasil dihapus.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_userdata("jadwal_msg", "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Jadwal gagal dihapus.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function editjdw()
    {
        $this->load->model('my_model');
        $data['title'] = 'Edit Jadwal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $IDSET = $this->uri->segment(3);
        $whereid = array('id' => $IDSET);
        $tampiljadwal = $this->my_model->cek_data("jadwal", $whereid);
        $data['datajadwal'] = $tampiljadwal->result();
        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/editjadwal_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function aturpeserta()
    {
        $this->load->model('my_model');
        $data['title'] = 'Atur Peserta';
        $data['gel'] = $this->uri->segment(3);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $jadwalData = $this->my_model->cek_data('jadwal', ['gelombang' => $data['gel']])->row();

        $this->db->order_by('id', 'DESC');
        $data['pesertates'] = $this->my_model->cek_data('pendaftar', ['sesi' => $data['gel']])->result();

        $this->db->order_by('id', 'DESC');
        $this->db->where('sesi IS NULL');
        $data['pesetasaja'] = $this->db->get('pendaftar')->result();

        $data['jadwalInfo'] = $jadwalData;

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/aturpeserta_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function setpeserta()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sesigel = $this->input->post('sesigel');
        $gel = $this->input->post('gel');

        if (!empty($gel)) {
            foreach ($gel as $value) {
                $data = array('sesi' => $sesigel);
                $where = array('id' => $value);
                $ceksql = $this->db->update('pendaftar', $data, $where);
            }
            if ($ceksql) {
                $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-success alert-dismissible fade show' role='alert'>Peserta berhasil ditambahkan ke gelombang.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
                redirect('admin/aturpeserta/' . $sesigel);
            } else {
                $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Peserta gagal ditambahkan ke gelombang.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
                redirect('admin/aturpeserta/' . $sesigel);
            }
        } else {
            $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Tidak ada peserta yang dipilih.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect('admin/aturpeserta/' . $sesigel);
        }
    }

    public function hapusset()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sesigel = $this->input->post('sesigel');
        $gel = $this->input->post('gel');

        if (!empty($gel)) {
            foreach ($gel as $value) {
                $data = array('sesi' => NULL);
                $where = array('id' => $value);
                $ceksql = $this->db->update('pendaftar', $data, $where);
            }

            if ($this->db->affected_rows() > 0) {
                $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-success alert-dismissible fade show' role='alert'>Peserta berhasil dihapus dari gelombang.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            } else {
                $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Peserta gagal dihapus dari gelombang.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            }
            redirect('admin/aturpeserta/' . $sesigel);
        } else {
            $this->session->set_userdata('aturpeserta_msg', "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Tidak ada peserta yang dipilih.<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>");
            redirect('admin/aturpeserta/' . $sesigel);
        }
    }

    public function setlulus()
    {
        $no_reg = array('no_ujian' => $this->uri->segment(3));
        $setstat = array('status' => $this->uri->segment(4));
        $setlulus = array('tes_tulis' => $this->uri->segment(4));
        $this->my_model->update("nilaites", $no_reg, $setstat);
        $this->my_model->update("pendaftar", $no_reg, $setlulus);

        redirect('admin/lamanhasiltes');
    }

    public function lamanhasiltes()
    {
        $data['title'] = 'Manajemen Hasil Ujian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get all available gelombang (batches) for the filter dropdown
        $this->db->distinct();
        $this->db->select('gelombang');
        $this->db->where('gelombang IS NOT NULL');
        $this->db->order_by('gelombang', 'ASC');
        $gelombangData = $this->my_model->tampil("jadwal")->result();
        $data['gelombang_list'] = $gelombangData;

        // Get the selected gelombang from the form submission or URL
        $selected_gelombang = $this->input->get('gelombang');
        $data['selected_gelombang'] = $selected_gelombang;

        // Base query to join nilaites with pendaftar
        $this->db->join('pendaftar b', 'b.no_ujian = a.no_ujian');
        $this->db->order_by('a.id', 'DESC');

        // Apply gelombang filter if selected
        if (!empty($selected_gelombang)) {
            $this->db->where('b.sesi', $selected_gelombang);
        }

        $ceknilaisiswa = $this->my_model->tampil("nilaites a")->result();

        $hasilSummary = [
            'lulus' => 0,
            'tidak_lulus' => 0,
            'pending' => 0,
        ];

        foreach ($ceknilaisiswa as $hasil) {
            $benar = (int) $hasil->jwb_b;
            $salah = (int) $hasil->jwb_s;
            $total = $benar + $salah;
            $hasil->nilai = $total > 0 ? (int) round(($benar / $total) * 100) : 0;

            if ($hasil->status === 'Y') {
                $hasilSummary['lulus']++;
            } elseif ($hasil->status === 'N') {
                $hasilSummary['tidak_lulus']++;
            } else {
                $hasilSummary['pending']++;
            }
        }

        $data['nilaitessiswa'] = $ceknilaisiswa;
        $data['hasilSummary'] = $hasilSummary;

        $this->load->view('templates_v2/header', $data);
        $this->load->view('templates_v2/sidebar', $data);
        $this->load->view('templates_v2/topbar', $data);
        $this->load->view('admin/viewhasil_v2', $data);
        $this->load->view('templates_v2/footer');
    }

    public function hasiltes()
    {
        $data['title'] = 'Manajemen Hasil Ujian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Use a more specific query to avoid GROUP BY issues
        $this->db->select('no_ujian');
        $this->db->group_by('no_ujian');
        $cekPeserta = $this->my_model->tampil("hasil_tes")->result();

        foreach ($cekPeserta as $cp) {
            $PesertaTes = $cp->no_ujian;
            $hasilBenar = 0;
            $hasilSalah = 0;
            $totalSoal = 0;

            // Get all answers for this student
            $where = array('b.no_ujian' => $PesertaTes);
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

            // Calculate score (if needed)
            $score = 0;
            if ($totalSoal > 0) {
                $score = round(($hasilBenar / $totalSoal) * 100);
            }

            // Update or insert results
            $whereid = array('no_ujian' => $PesertaTes);
            $ceknilaites = $this->my_model->cek_data("nilaites", $whereid)->num_rows();

            if ($ceknilaites < 1) {
                // Insert new record
                $datasink = array(
                    'no_ujian' => $PesertaTes,
                    'jwb_b' => $hasilBenar,
                    'jwb_s' => $hasilSalah,
                    'status' => 'X'
                );
                $this->my_model->tambahdata("nilaites", $datasink);
            } else {
                // Update existing record
                $whereUpdate = array('no_ujian' => $PesertaTes);
                $dataSinkUp = array(
                    'jwb_b' => $hasilBenar,
                    'jwb_s' => $hasilSalah
                );
                $this->my_model->update("nilaites", $whereUpdate, $dataSinkUp);
            }
        }

        redirect('admin/lamanhasiltes');
    }
}
