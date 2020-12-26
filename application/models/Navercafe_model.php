<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Banner model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Navercafe_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'naver_cafe';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'add_sn'; // 사용되는 테이블의 프라이머리키

	public $cache_time = 86400; // 캐시 저장시간

	function __construct()
	{
		parent::__construct();

		check_cache_dir('banner');
	}


    public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
        $join = array();
//        if (isset($where['mgr_id'])) {
//            $select = 'member.*';
//            $join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
//        }
        $result = $this->_get_list_common($select = '', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);

        return $result;
    }
}
