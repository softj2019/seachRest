<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends CB_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	# 파일 업로드 수행
	public function index()
	{
		self::init_file_upload();
		self::proc_file_upload();
	}

	public function do_upload()
	{
		header('Content-type: application/json');
//		$config['upload_path']          = $this->config->item("editor_path");
		$config['upload_path']          = 'uploads/editor/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 1000000;
		$config['max_width']            = 10240000;
		$config['max_height']           = 7680000;
		$config['encrypt_name']         = true;
		$config['overwrite']         	= true;


		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		$files_name = $_FILES['file']['name'];
		$files = $_FILES['file'];

		# 파일 변수명이 배열 형태인지 구분하여 처리
		if ( !is_array($files_name) )
		{
			echo json_encode(self::_do_upload_one());
		}
		else if ( count($files_name) > 0 )
		{
			foreach ( $files_name as $key => $val )
			{
				$_FILES['file'] = array(
					'name' => $files['name'][$key],
					'type' => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error' => $files['error'][$key],
					'size' => $files['size'][$key]
				);
				echo json_encode(self::_do_upload_one());
			}
		}

	}

	# 파일 업로드 하나씩 처리
	private function _do_upload_one ()
	{
		if ( ! $this->upload->do_upload('file'))
		{
			$data['error'] =  $this->upload->display_errors();
//			$this->load->view('upload_form', $error);
		}
		else
		{
			$data['imgData'] = $this->upload->data();
		}
		return $data;
	}

}
