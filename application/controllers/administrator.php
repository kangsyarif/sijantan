<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
	public function is_logged_in(){
		/*
		$is_logged_in=$this->session->userdata('is_logged_in');
		if(!isset($is_logged_in)||$is_logged_in!= true) {
			redirect(base_url().'kelola/masuk/');
		} 
		*/
	}
	
    function __construct(){
        parent::__construct();
		$this->load->helper(array('url'));
        $this->load->library('form_validation');
		
    }
	
	public function index(){
		$this->is_logged_in();
        $data = array(
			'title'=>'Administrator Portal UMKM Pemerintah Desa Candigatak',
			'isi' =>'kelola/awal'
        );
		$this->load->view('kelola/layout/wrapperAdministrator',$data);
	}
	
	public function aspirasi_belum_dibaca(){
		$data = array(
			'title'=>'Aspirasi Belum Dibaca',
			'isi' =>'kelola/aspirasiBelumDibaca_view'
        );
		$this->load->view('kelola/layout/wrapper',$data);
	}
	
	public function sudah_dibaca(){
		$this->is_logged_in();
		$this->load->model('Aduan_model');
		$this->load->library('pagination');
		
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kelola/sudah_dibaca/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kelola/sudah_dibaca/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kelola/sudah_dibaca/';
            $config['first_url'] = base_url() . 'kelola/sudah_dibaca/';
        }
		
		$config['base_url'] 	= base_url().'kelola/sudah_dibaca/';
        $config['total_rows'] 	= $this->Aduan_model->total_rows($q);
		$config['per_page'] 	= 2;
        $config['uri_segment'] 	= 3;
		//Tambahan untuk styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link']='< Pertama ';
        $config['last_link']='Terakhir > ';
        $config['next_link']='> ';
        $config['prev_link']='< ';
		
		$this->pagination->initialize($config);
		$start = $this->uri->segment(3, 0);
		$laporan_masuk 			= $this->Aduan_model->get_sudah_dibaca($config['per_page'],$start, $q)->result();
        		
        $data = array(
            'laporan_masuk_data' 	=> $laporan_masuk,
            'q' 					=> $q,
            'pagination'			=> $this->pagination->create_links(),
            'total_rows' 			=> $config['total_rows'],
            'start' 				=> $start,
			'url'					=> 'kelola/sudah_dibaca',
			'section'				=> 'Data Aduan Yang Sudah Dibaca',
			'title'					=> 'Aduan Yang Sudah Dibaca',
			'isi' 					=> 'kelola/aduan_list'
        );
		$this->load->view('layout/wrapper',$data);
	}
	
	public function semua_aduan(){
		$this->is_logged_in();
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kelola/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kelola/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kelola/index.html';
            $config['first_url'] = base_url() . 'kelola/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Aduan_model->total_rows($q);
        $laporan_masuk = $this->Aduan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'laporan_masuk_data' 	=> $laporan_masuk,
            'q' 					=> $q,
            'pagination'			=> $this->pagination->create_links(),
            'total_rows' 			=> $config['total_rows'],
            'start' 				=> $start,
			'url'					=> 'kelola/semua_aduan',
			'section'				=> 'Data Semua Aduan',
			'title'					=> 'Semua Aduan Masuk',
			'isi' 					=> 'kelola/aduan_list'
        );
		$this->load->view('layout/wrapper',$data);
	}
	
	public function masuk(){
		$data = array(
				'title'=>'Login Kelola Aduan Warga',
				'isi' =>'laporan_masuk/aduan_laporan_read'
			);
		$this->load->view('kelola/login',$data);
	}
	
	public function login(){
		$this->load->model('M_login','',TRUE);
		$cek_login=$this->M_login->validasi();
		
		if($cek_login){
			foreach($cek_login as $data_login){
				$username=$data_login['username'];
				$level=$data_login['level'];
				$photo=$data_login['photo'];
				$nama_lengkap=$data_login['nama_lengkap'];
			}
			
			$data_login=array(
				'username'=>$username,
				'is_logged_in'=> true,
				'nama_lengkap'=>$nama_lengkap,
				'photo'=>$photo,
				'level'=>$level
			);
			
			$this->session->set_userdata($data_login);
			redirect(base_url().'kelola/');
		} else  {
			$this->index();
		}
	}
	public function logout(){
		$this->session->unset_userdata("is_logged_in");
		$this->session->sess_destroy();
		redirect("kelola/masuk");
	}
		
	
	public function create() 
    {
		$this->is_logged_in();
        $data = array(
            'button' => 'Create',
            'action' => site_url('laporan_masuk/create_action'),
			'kode_aduan' => set_value('kode_aduan'),
			'nama_pengadu' => set_value('nama_pengadu'),
			'kontak_pengadu' => set_value('kontak_pengadu'),
			'ip_pelapor' => set_value('ip_pelapor'),
			'mac_add_pelapor' => set_value('mac_add_pelapor'),
			'isi_aduan' => set_value('isi_aduan'),
			'bukti_aduan' => set_value('bukti_aduan'),
			'waktu_aduan' => set_value('waktu_aduan'),
			'status_aduan' => set_value('status_aduan'),
			'title'=>'Contact Us',
			'isi' =>'laporan_masuk/aduan_laporan_form'
		);
        $this->load->view('layout/wrapper',$data);
    }
    
    public function create_action() 
    {
		$this->is_logged_in();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_pengadu' => $this->input->post('nama_pengadu',TRUE),
		'kontak_pengadu' => $this->input->post('kontak_pengadu',TRUE),
		'ip_pelapor' => $this->input->post('ip_pelapor',TRUE),
		'mac_add_pelapor' => $this->input->post('mac_add_pelapor',TRUE),
		'isi_aduan' => $this->input->post('isi_aduan',TRUE),
		'bukti_aduan' => $this->input->post('bukti_aduan',TRUE),
		'waktu_aduan' => $this->input->post('waktu_aduan',TRUE),
		'status_aduan' => $this->input->post('status_aduan',TRUE),
	    );

            $this->Aduan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('laporan_masuk'));
        }
    }
    public function baca($id){		
		$this->is_logged_in();
        $row = $this->Aduan_model->get_by_id($id);
		$data = array(
				'status_aduan' => 'Sudah Dibaca',
			);
		
        if ($row) {
			$this->Aduan_model->update($id, $data);
			$this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kelola/detail/'.$id));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelola/'));
        }
    }
	
	public function detail($id){
        $row = $this->Aduan_model->get_by_id($id);
        if ($row) {
            $data = array(
				'kode_aduan' => $row->kode_aduan,
				'nama_pengadu' => $row->nama_pengadu,
				'kontak_pengadu' => $row->kontak_pengadu,
				'isi_aduan' => $row->isi_aduan,
				'bukti_aduan' => $row->bukti_aduan,
				'waktu_aduan' => $row->waktu_aduan,
				'status_aduan' => $row->status_aduan,
				'title'=>'Detail Laporan Masyarakat',
				'isi' =>'kelola/aduan_detail'
			);
            $this->load->view('layout/wrapper',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('laporan_masuk'));
        }
    }
    public function edit($id){
		$this->is_logged_in();
        $row = $this->Aduan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('laporan_masuk/do_edit'),
				'kode_aduan' => set_value('kode_aduan', $row->kode_aduan),
				'nama_pengadu' => set_value('nama_pengadu', $row->nama_pengadu),
				'kontak_pengadu' => set_value('kontak_pengadu', $row->kontak_pengadu),
				'isi_aduan' => set_value('isi_aduan', $row->isi_aduan),
				'bukti_aduan' => set_value('bukti_aduan', $row->bukti_aduan),
				'waktu_aduan' => set_value('waktu_aduan', $row->waktu_aduan),
				'status_aduan' => set_value('status_aduan', $row->status_aduan),
				'title'=>'Contact Us',
				'isi' =>'kelola/aduan_form'
			);
             $this->load->view('layout/wrapper',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('laporan_masuk'));
        }
    }
    
    public function do_edit() 
    {
		$this->is_logged_in();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_aduan', TRUE));
        } else {
            $data = array(
				'nama_pengadu' => $this->input->post('nama_pengadu',TRUE),
				'kontak_pengadu' => $this->input->post('kontak_pengadu',TRUE),
				'ip_pelapor' => $this->input->post('ip_pelapor',TRUE),
				'mac_add_pelapor' => $this->input->post('mac_add_pelapor',TRUE),
				'isi_aduan' => $this->input->post('isi_aduan',TRUE),
				'bukti_aduan' => $this->input->post('bukti_aduan',TRUE),
				'waktu_aduan' => $this->input->post('waktu_aduan',TRUE),
				'status_aduan' => $this->input->post('status_aduan',TRUE),
				
			);

            $this->Aduan_model->update($this->input->post('kode_aduan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('laporan_masuk'));
        }
    }
    
    public function hapus($id){
		$this->is_logged_in();
        $row = $this->Aduan_model->get_by_id($id);
		unlink("./assets/uploads/$row->bukti_aduan");
		unlink("./assets/hasil_resize/$row->bukti_aduan");
        if ($row) {
            $this->Aduan_model->delete($id);
            $this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success alert-dismissible\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>Berhasil hapus data Gambar dan file gambar dari folder !!</div></div>");
            redirect(site_url('laporan_masuk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('laporan_masuk'));
        }
    }
	
	public function rekap_aduan(){
		$this->is_logged_in();
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		$nama = "indah";
        		
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kelola/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kelola/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kelola/index.html';
            $config['first_url'] = base_url() . 'kelola/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Aduan_model->total_rows($q);
        $laporan_masuk = $this->Aduan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'laporan_masuk_data' 	=> $laporan_masuk,
            'q' 					=> $q,
            'pagination'			=> $this->pagination->create_links(),
            'total_rows' 			=> $config['total_rows'],
            'start' 				=> $start,
			'url'					=> 'kelola/semua_aduan',
			'section'				=> 'Data Semua Aduan',
			'title'					=> 'Semua Aduan Masuk',
			'isi' 					=> 'kelola/rekap_aduan_view'
        );
		$this->load->view('kelola/rekap_aduan_view',$data);
    }

    public function _rules(){
		$this->form_validation->set_rules('nama_pengadu', 'nama pelapor', 'trim|required');
		$this->form_validation->set_rules('kontak_pengadu', 'kontak pelapor', 'trim|required');
		$this->form_validation->set_rules('ip_pelapor', 'ip pelapor', 'trim|required');
		$this->form_validation->set_rules('mac_add_pelapor', 'mac add pelapor', 'trim|required');
		$this->form_validation->set_rules('isi_aduan', 'isi laporan', 'trim|required');
		$this->form_validation->set_rules('bukti_aduan', 'bukti laporan', 'trim|required');
		$this->form_validation->set_rules('waktu_aduan', 'waktu laporan', 'trim|required');
		$this->form_validation->set_rules('status_aduan', 'status laporan', 'trim|required');

		$this->form_validation->set_rules('kode_aduan', 'kode_aduan', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */