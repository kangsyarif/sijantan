<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aduan_model extends CI_Model{
    public $table 	= 'aduan_laporan';
    public $id 		= 'kode_aduan';
	public $status	= 'status_aduan';
    public $order 	= 'DESC';

    function __construct(){
        parent::__construct();
    }

    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function total_rows($q = NULL) {
        $this->db->like('kode_aduan', $q);
		$this->db->or_like('nama_pengadu', $q);
		$this->db->or_like('kontak_pengadu', $q);
		$this->db->or_like('isi_aduan', $q);
		$this->db->or_like('bukti_aduan', $q);
		$this->db->or_like('waktu_aduan', $q);
		$this->db->or_like('status_aduan', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_aduan', $q);
		$this->db->or_like('nama_pengadu', $q);
		$this->db->or_like('kontak_pengadu', $q);
		$this->db->or_like('isi_aduan', $q);
		$this->db->or_like('bukti_aduan', $q);
		$this->db->or_like('waktu_aduan', $q);
		$this->db->or_like('status_aduan', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
	
	function get_belum_dibaca($limit, $start = 0, $q = NULL) {
        $this->db->where($this->status, 'Belum Dibaca');
		$this->db->order_by($this->id, $this->order);
		$this->db->like('nama_pengadu', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table);
    }
	
	function get_sudah_dibaca($limit, $start = 0, $q = NULL) {
        $this->db->where($this->status, 'Sudah Dibaca');
		$this->db->order_by($this->id, $this->order);
		$this->db->like('nama_pengadu', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table);
    }
	
	function user_limit($limit, $start = 0) {
        $this->db->order_by($this->id, 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table);
    }
    function insert($data){
        $this->db->insert($this->table, $data);
    }

    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}