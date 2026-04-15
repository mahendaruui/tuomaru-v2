<?php
class My_model extends CI_Model
{

	public function get_mhs()
	{
		$this->db->order_by('IDMAHASISWA', 'DESC');
		$query = $this->db->get('absen_mhs');
		return $query->result();
	}
	public function cek_data($tabel, $where)
	{
		//$this->db->escape_like_str($search);
		return $this->db->get_where($tabel, $where);
	}
	public function tampil($tabel)
	{
		return $this->db->get($tabel);
	}
	public function total($tabel, $where)
	{
		if ($where != null) {
			$this->db->where($where);
		}
		return $this->db->get($tabel)->num_rows();
	}
	public function tambahdata($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	public function hapus($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table, $where);
	}

	public function update($table, $where, $data)
	{
		if ($where != null) {
			$this->db->where($where);
		}
		return $this->db->update($table, $data);
	}
	public function tampil_page($number, $offset)
	{
		return $this->db->get('atur_bahan_ajar a', $number, $offset);
	}

	public function fetchUrl($url)
	{
		$allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
		if ($allowUrlFopen) {
			return file_get_contents($url);
		} elseif (function_exists('curl_init')) {
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			$contents = curl_exec($c);
			curl_close($c);
			if (is_string($contents)) {
				return $contents;
			}
		}
		return false;
	}
	 public function getLulus()
    {
        $query = "SELECT *,
        FROM `nilaitesaipt`
        WHERE `status`= y
    ";
        return $this->db->query($query)->row_array();
    }
}
