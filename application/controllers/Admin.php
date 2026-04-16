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

        for ($i = 1; $i <= $jdw; $i++) {
            $where1 = ['sesi' =>  $i];
            $jmlpesertaa = $this->my_model->cek_data('pendaftar', $where1)->result();
            foreach ($jmlpesertaa as $j) {
                $data1[] = $j->sesi;
            }
            $data['jmlpeserta'] = $data1;
        }

        // count peserta sudah ujian
        $sudahtes = array('hadir_tulis' => "Y");
        $data['jmlselesai'] = $this->my_model->cek_data('pendaftar', $sudahtes)->num_rows();

        // yang belum ikuti ujian
        $sudahtes = array('hadir_tulis' => "N");
        $data['jmlbelum'] = $this->my_model->cek_data('pendaftar', $sudahtes)->num_rows();

        // count soal
        $data['jmlsoal'] = $this->my_model->tampil('m_soal')->num_rows();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/peserta', $data);
        $this->load->view('templates/footer');
    }

    public function downloadTemplatePeserta()
    {
        is_logged_in();

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

        $filename = 'template_import_peserta.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // SpreadsheetML — support multi-sheet tanpa library eksternal
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"'
            . ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"'
            . ' xmlns:x="urn:schemas-microsoft-com:office:excel">' . "\n";

        // ── Styles ────────────────────────────────────────────────────────
        echo '<Styles>'
            . '<Style ss:ID="hdr"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#4472C4" ss:Pattern="Solid"/></Style>'
            . '<Style ss:ID="ref_title"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#ED7D31" ss:Pattern="Solid"/></Style>'
            . '<Style ss:ID="ref_hdr"><Font ss:Bold="1"/><Interior ss:Color="#FFC000" ss:Pattern="Solid"/></Style>'
            . '<Style ss:ID="bold"><Font ss:Bold="1"/></Style>'
            . '</Styles>' . "\n";

        // ── Sheet 1 : Template Data ───────────────────────────────────────
        echo '<Worksheet ss:Name="Template Data"><Table>' . "\n";

        // header row
        echo '<Row>';
        $headers = [
            'Nomor Ujian',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Jenis Kelamin (L/P)',
            'Email',
            'No. HP',
            'Kode Program Studi',
        ];
        foreach ($headers as $h) {
            echo '<Cell ss:StyleID="hdr"><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>';
        }
        echo '</Row>' . "\n";

        // 5 baris kosong untuk diisi
        for ($i = 0; $i < 5; $i++) {
            echo '<Row>';
            foreach ($headers as $h) {
                echo '<Cell><Data ss:Type="String"></Data></Cell>';
            }
            echo '</Row>' . "\n";
        }

        echo '</Table></Worksheet>' . "\n";

        // ── Sheet 2 : Referensi Kode Prodi ───────────────────────────────
        echo '<Worksheet ss:Name="Referensi Prodi"><Table>' . "\n";

        // judul
        echo '<Row>'
            . '<Cell ss:StyleID="ref_title" ss:MergeAcross="2"><Data ss:Type="String">REFERENSI KODE PROGRAM STUDI</Data></Cell>'
            . '</Row>' . "\n";

        // header kolom
        echo '<Row>'
            . '<Cell ss:StyleID="ref_hdr"><Data ss:Type="String">Kode Prodi</Data></Cell>'
            . '<Cell ss:StyleID="ref_hdr"><Data ss:Type="String">Nama Program Studi</Data></Cell>'
            . '<Cell ss:StyleID="ref_hdr"><Data ss:Type="String">Fakultas</Data></Cell>'
            . '</Row>' . "\n";

        foreach ($prodiList as $prodi) {
            $namaFakultas = isset($fakultasMap[$prodi->id_fakultas])
                ? $fakultasMap[$prodi->id_fakultas]
                : $prodi->id_fakultas;

            echo '<Row>'
                . '<Cell ss:StyleID="bold"><Data ss:Type="String">' . htmlspecialchars($prodi->id_prodi) . '</Data></Cell>'
                . '<Cell><Data ss:Type="String">' . htmlspecialchars($prodi->nama_prodi) . '</Data></Cell>'
                . '<Cell><Data ss:Type="String">' . htmlspecialchars($namaFakultas) . '</Data></Cell>'
                . '</Row>' . "\n";
        }

        echo '</Table></Worksheet>' . "\n";
        echo '</Workbook>';
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

        $file = $_FILES['file_csv'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'csv') {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Format file harus <strong>.csv</strong>. Buka template di Excel lalu simpan sebagai CSV.</div>');
            redirect('admin/viewpeserta');
            return;
        }

        $handle = fopen($file['tmp_name'], 'r');
        if (!$handle) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal membaca file.</div>');
            redirect('admin/viewpeserta');
            return;
        }

        $row      = 0;
        $inserted = 0;
        $skipped  = 0;
        $errors   = [];

        while (($line = fgetcsv($handle, 2000, ',')) !== false) {
            $row++;

            // Lewati baris header
            if ($row === 1) continue;

            // Lewati baris kosong
            if (empty(array_filter($line))) continue;

            $noUjian = isset($line[0]) ? trim($line[0]) : '';
            $nama    = isset($line[1]) ? trim($line[1]) : '';
            $tempat  = isset($line[2]) ? trim($line[2]) : '';
            $tanggal = isset($line[3]) ? trim($line[3]) : '';
            $jenkel  = isset($line[4]) ? strtoupper(trim($line[4])) : '';
            $email   = isset($line[5]) ? trim($line[5]) : '';
            $hp      = isset($line[6]) ? trim($line[6]) : '';
            // index 7 = kode prodi, diabaikan sementara

            if (empty($noUjian) || empty($nama)) {
                $errors[] = "Baris $row: no_ujian atau nama kosong, dilewati.";
                $skipped++;
                continue;
            }

            // Validasi jenkel
            if (!in_array($jenkel, ['L', 'P', ''])) {
                $errors[] = "Baris $row ($noUjian): jenis kelamin harus L atau P, dilewati.";
                $skipped++;
                continue;
            }

            // Cek duplikat no_ujian
            $cek = $this->db->get_where('pendaftar', ['no_ujian' => $noUjian])->row();
            if ($cek) {
                $errors[] = "Baris $row: no_ujian '$noUjian' sudah ada, dilewati.";
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
                'no_ujian'    => $noUjian,
                'nama'        => $nama,
                'tempat'      => $tempat,
                'tanggal'     => ($tanggal !== '') ? $tanggal : null,
                'jenkel'      => $jenkel,
                'email'       => $email,
                'hp'          => $hp,
                'pass'        => $pass,
                'tgl_daftar'  => date('Y-m-d'),
                'hadir_tulis' => 'N',
                'tes_tulis'   => 'N',
            ];

            $this->db->insert('pendaftar', $data);
            $inserted++;
        }

        fclose($handle);

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

        $this->session->set_flashdata('msg', "<div class='alert alert-$type'>$msg</div>");
        redirect('admin/viewpeserta');
    }

    public function viewsoal()
    {
        $this->load->model('my_model');
        $data['title'] = 'Bank Soal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tampilsoal = $this->my_model->tampil("m_soal");
        $data['soal'] = $tampilsoal->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/soal', $data);
        $this->load->view('templates/footer');
    }

    public function tambahsoal()
    {
        $this->load->model('my_model');
        $data['title'] = 'Form Input Soal Test';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/inputsoal', $data);
        $this->load->view('templates/footer');
    }

    public function hapussoal()
    {
        $this->load->model('my_model');
        $IDSET = $this->uri->segment(3);
        $where = array('id' => $IDSET);
        $hapussoal = $this->my_model->hapus("m_soal", $where);
        if ($hapussoal) {
            $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil Dihapus!!</div></div>");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata("msg", "<br/><div class='card bg-warning text-white shadow mb-2'><div class='card-body'>Data Gagal Dihapus!!</div></div>");
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
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editsoal', $data);
        $this->load->view('templates/footer');
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
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/detailsoal', $data);
        $this->load->view('templates/footer');
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
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/detailmember', $data);
        $this->load->view('templates/footer');
    }

    public function jadwal()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Manajemen Tes';

        $tampiljadwal = $this->my_model->tampil("jadwal");
        $data['jadwaltes'] = $tampiljadwal->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/jadwal', $data);
        $this->load->view('templates/footer');
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
            $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil Disimpan!!</div></div>");
            redirect('admin/jadwal');
        } else {
            $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Gagal Disimpan!!</div></div>");
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
            $this->session->set_flashdata("msg", "<br/><div class='card bg-success text-white shadow mb-2'><div class='card-body'>Data Berhasil Dihapus!!</div></div>");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata("msg", "<br/><div class='card bg-warning text-white shadow mb-2'><div class='card-body'>Data Gagal Dihapus!!</div></div>");
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
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editjadwal', $data);
        $this->load->view('templates/footer');
    }

    public function aturpeserta()
    {
        $this->load->model('my_model');
        $data['title'] = 'Atur Peserta';
        $data['gel'] = $this->uri->segment(3);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get the jadwal ID based on the gelombang parameter
        $whereJadwal = ['gelombang' => $data['gel']];
        $jadwalData = $this->my_model->cek_data("jadwal", $whereJadwal)->result();
        $idjadwal = $jadwalData[0]->id;

        // pilih id_jdwl urutan terakhir aja
        $this->db->order_by('id_jdwl', 'DESC');
        $lastjadwal = $this->my_model->tampil("kelola_sipenmaru")->row();
        $id_jdwl_terakhir = isset($lastjadwal->id_jdwl) ? $lastjadwal->id_jdwl : null;

        if (!empty($jadwalData)) {
            $where = ['a.sesi' => $data['gel'], 'a.id_jdwl' => $id_jdwl_terakhir];
            // Join pendaftar with kelola_pendaftar based on id_jdwl
            $this->db->join('kelola_sipenmaru b', 'a.id_jdwl = b.id_jdwl', 'left');
            $this->db->select('a.*, b.ket, b.tahun');
            $this->db->order_by("a.id", "DESC");
            $pendaftar = $this->my_model->cek_data("pendaftar a", $where);
            $data['pesertates'] = $pendaftar->result();
        }


        $wherenu = ['a.sesi' => NULL, 'a.id_jdwl' => $id_jdwl_terakhir];

        // Join pendaftar with kelola_pendaftar based on id_jdwl
        $this->db->join('kelola_sipenmaru b', 'a.id_jdwl = b.id_jdwl', 'left');
        $this->db->select('a.*, b.ket, b.tahun');
        $this->db->where('a.bayar', 'Y');
        $this->db->order_by("a.id", "DESC");
        $pendaftar = $this->my_model->cek_data("pendaftar a", $wherenu);
        $data['pesetasaja'] = $pendaftar->result();
        // Get ket and tahun for the view
        $this->db->select('ket, tahun');
        $this->db->limit(1);
        $this->db->order_by('id_jdwl', 'DESC');
        $kelolaData = $this->my_model->tampil("kelola_sipenmaru")->row();
        $data['ket'] = isset($kelolaData->ket) ? $kelolaData->ket : '';
        $data['tahun'] = isset($kelolaData->tahun) ? $kelolaData->tahun : '';


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/aturpeserta', $data);
        $this->load->view('templates/footer');
    }

    public function setpeserta()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $IDSET = $this->uri->segment(3);

        $whereadwal = ['gelombang' => $this->input->post('sesigel')];
        $cekidjadwal = $this->my_model->cek_data("jadwal", $whereadwal)->result();

        $id_jdwl = $cekidjadwal[0]->id;

        $sesigel = $this->input->post('sesigel');
        $gel = $this->input->post('gel');

        if (isset($gel)) {
            foreach ($gel as $value) {
                $data = array('sesi' => $sesigel);
                $where = array('id' => $value);
                $ceksql = $this->db->update('pendaftar', $data, $where);
            }
            if ($ceksql) {
                redirect('admin/aturpeserta/' . $sesigel);
                // echo "berhasil";
            } else {
                redirect('admin/aturpeserta' . $sesigel);
                // echo "gagal";
            }
        } else {
            echo "kesalahan teknik";
        }
    }

    public function hapusset()
    {
        $this->load->model('my_model');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sesigel = $this->input->post('sesigel');
        $gel = $this->input->post('gel');

        if (isset($gel)) {
            foreach ($gel as $value) {
                $id = substr($value, 0, -1);
                $data = array('sesi' => NULL);
                $where = array('id' => $id);
                $ceksql = $this->db->update('pendaftar', $data, $where);
            }

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menghapus peserta dari gelombang</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menghapus peserta dari gelombang</div>');
            }
            redirect('admin/aturpeserta/' . $sesigel);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada peserta yang dipilih</div>');
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

        //untuk aipt
        // count peserta sudah ujian
        $lulus2018 = array(
            'tahun' => "2018",
            'status' => "Y",
        );
        $data['jmls2018'] = $this->my_model->cek_data('nilaitesaipt', $lulus2018)->num_rows();

        // count peserta sudah ujian
        $lulus2019 = array(
            'tahun' => "2019",
            'status' => "Y",
        );
        $data['jmls2019'] = $this->my_model->cek_data('nilaitesaipt', $lulus2019)->num_rows();

        // count peserta sudah ujian
        $lulus2020 = array(
            'tahun' => "2020",
            'status' => "Y",
        );
        $data['jmls2020'] = $this->my_model->cek_data('nilaitesaipt', $lulus2020)->num_rows();

        $tlulus2018 = array(
            'tahun' => "2018",
            'status' => "N",
        );
        $data['jmtls2018'] = $this->my_model->cek_data('nilaitesaipt', $tlulus2018)->num_rows();

        // count peserta sudah ujian
        $tlulus2019 = array(
            'tahun' => "2019",
            'status' => "N",
        );
        $data['jmtls2019'] = $this->my_model->cek_data('nilaitesaipt', $tlulus2019)->num_rows();

        // count peserta sudah ujian
        $tlulus2020 = array(
            'tahun' => "2020",
            'status' => "N",
        );
        $data['jmtls2020'] = $this->my_model->cek_data('nilaitesaipt', $tlulus2020)->num_rows();


        $ceknilaisiswa2 = $this->my_model->tampil("nilaitesaipt")->result_array();
        $data['nilaitessiswa'] = $ceknilaisiswa;
        $data['nilaitessiswa2'] = $ceknilaisiswa2;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/viewhasil', $data);
        $this->load->view('templates/footer');
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
                    'nilai' => $score,
                    'status' => 'X'
                );
                $this->my_model->tambahdata("nilaites", $datasink);
            } else {
                // Update existing record
                $whereUpdate = array('no_ujian' => $PesertaTes);
                $dataSinkUp = array(
                    'jwb_b' => $hasilBenar,
                    'jwb_s' => $hasilSalah,
                    'nilai' => $score
                );
                $this->my_model->update("nilaites", $whereUpdate, $dataSinkUp);
            }
        }

        redirect('admin/lamanhasiltes');
    }
}
