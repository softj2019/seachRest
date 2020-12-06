<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 로그인 페이지와 관련된 controller 입니다.
 */
class Restlogin extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'string');

	function __construct()
	{
		parent::__construct();

	}


	/**
	 * 로그인 페이지입니다
	 */
	public function index()
	{

        $this->output->set_content_type("application/json", 'utf-8');
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_index';
		$this->load->event($eventname);

//		if ($this->member->is_member() !== false && ! ($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
//			redirect();
//		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->library(array('form_validation'));

		 if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		if ($use_login_account === 'both') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디 또는 이메일',
				'rules' => 'trim|required',
			);
			$view['view']['userid_label_text'] = '아이디 또는 이메일';
		} elseif ($use_login_account === 'email') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '이메일',
				'rules' => 'trim|required|valid_email',
			);
			$view['view']['userid_label_text'] = '이메일';
		} else {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디',
				'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]',
			);
			$view['view']['userid_label_text'] = '아이디';
		}
		$config[] = array(
			'field' => 'mem_password',
			'label' => '패스워드',
			'rules' => 'trim|required|min_length[4]|callback__check_id_pw[' . $this->input->post_get('mem_userid') . ']',
		);

		$this->form_validation->set_rules($config);
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

            $this->output->set_status_header(400);
            $data["errors"]=$this->form_validation->_error();
		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			if ($use_login_account === 'both') {
				$userinfo = $this->Member_model->get_by_both($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} elseif ($use_login_account === 'email') {
				$userinfo = $this->Member_model->get_by_email($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} else {
				$userinfo = $this->Member_model->get_by_userid($this->input->post('mem_userid'), 'mem_id, mem_userid');
			}
			$this->member->update_login_log(element('mem_id', $userinfo), $this->input->post('mem_userid'), 1, '로그인 성공');

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);
            $this->output->set_status_header(400);

		}
        echo json_encode($data);
	}


	/**
	 * 로그인시 아이디와 패스워드가 일치하는지 체크합니다
	 */
	public function _check_id_pw($password, $userid)
	{
		 if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$max_login_try_count = (int) $this->cbconfig->item('max_login_try_count');
		$max_login_try_limit_second = (int) $this->cbconfig->item('max_login_try_limit_second');

		$loginfailnum = 0;
		$loginfailmessage = '';
		if ($max_login_try_count && $max_login_try_limit_second) {
			$select = 'mll_id, mll_success, mem_id, mll_ip, mll_datetime';
			$where = array(
				'mll_ip' => $this->input->ip_address(),
				'mll_datetime > ' => strtotime(ctimestamp() - 86400 * 30),
			);
			$this->load->model('Member_login_log_model');
			$logindata = $this->Member_login_log_model
				->get('', $select, $where, '', '', 'mll_id', 'DESC');

			if ($logindata && is_array($logindata)) {
				foreach ($logindata as $key => $val) {
					if ((int) $val['mll_success'] === 0) {
						$loginfailnum++;
					} elseif ((int) $val['mll_success'] === 1) {
						break;
					}
				}
			}
			if ($loginfailnum > 0 && $loginfailnum % $max_login_try_count === 0) {
				$lastlogintrydatetime = $logindata[0]['mll_datetime'];
				$next_login = strtotime($lastlogintrydatetime)
					+ $max_login_try_limit_second
					- ctimestamp();
				if ($next_login > 0) {
					$this->form_validation->set_message(
						'_check_id_pw',
						'회원님은 패스워드를 연속으로 ' . $loginfailnum . '회 잘못 입력하셨기 때문에 '
						. $next_login . '초 후에 다시 로그인 시도가 가능합니다'
					);
					return false;
				}
			}
			$loginfailmessage = '<br />회원님은 ' . ($loginfailnum + 1)
				. '회 연속으로 패스워드를 잘못입력하셨습니다. ';
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		$this->load->model(array('Member_dormant_model'));

		$userselect = 'mem_id, mem_password, mem_denied, mem_email_cert, mem_is_admin';
		$is_dormant_member = false;
		if ($use_login_account === 'both') {
			$userinfo = $this->Member_model->get_by_both($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_both($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} elseif ($use_login_account === 'email') {
			$userinfo = $this->Member_model->get_by_email($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_email($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} else {
			$userinfo = $this->Member_model->get_by_userid($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_userid($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		}
		$hash = password_hash($password, PASSWORD_BCRYPT);

		if ( ! element('mem_id', $userinfo) OR ! element('mem_password', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(0, $userid, 0, '회원 아이디가 존재하지 않습니다');
			return false;
		} elseif ( ! password_verify($password, element('mem_password', $userinfo))) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '패스워드가 올바르지 않습니다');
			return false;
		} elseif (element('mem_denied', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님의 아이디는 접근이 금지된 아이디입니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '접근이 금지된 아이디입니다');
			return false;
		} elseif ($this->cbconfig->item('use_register_email_auth') && ! element('mem_email_cert', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님은 아직 이메일 인증을 받지 않으셨습니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '이메일 인증을 받지 않은 회원아이디입니다');
			return false;
		} elseif (element('mem_is_admin', $userinfo) && $this->input->post('autologin')) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'최고관리자는 자동로그인 기능을 사용할 수 없습니다'
			);
			return false;
		}

		if ($is_dormant_member === true) {
			$this->member->recover_from_dormant(element('mem_id', $userinfo));
		}

		return true;
	}


}
