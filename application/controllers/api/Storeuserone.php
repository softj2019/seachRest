<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Storeuserone extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Member_meta', 'Member_group', 'Member_group_member', 'Member_nickname', 'Member_extra_vars', 'Member_userid', 'Social_meta','Member_register');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Member_model';

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'chkstring');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('pagination', 'querystring'));
    }
    /**
     * 목록을 가져오는 메소드입니다
     */
    public function index()
    {

        $this->output->set_content_type('application/json', 'utf-8');
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_member_members_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
        요청자의 보유포인트 조회
         */

        $req_mem =$this->Member_model->get_one($this->input->get("mem_id"),true);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $view['view']['sort'] = array(
            'mem_id' => $param->sort('mem_id', 'asc'),
            'mem_userid' => $param->sort('mem_userid', 'asc'),
            'mem_username' => $param->sort('mem_username', 'asc'),
            'mem_nickname' => $param->sort('mem_nickname', 'asc'),
            'mem_email' => $param->sort('mem_email', 'asc'),
            'mem_point' => $param->sort('mem_point', 'asc'),
            'mem_register_datetime' => $param->sort('mem_register_datetime', 'asc'),
            'mem_lastlogin_datetime' => $param->sort('mem_lastlogin_datetime', 'asc'),
            'mem_level' => $param->sort('mem_level', 'asc'),
        );
        $findex = $this->input->get('findex', null, 'member.mem_id');
        $forder = $this->input->get('forder', null, 'desc');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');
//        $skeyword =str_replace('-','',$this->input->get('skeyword', null, ''));
//        $skeyword - str_replace('-','',$this->input->get('skeyword', null, ''));

        /**
         * 번호 검증은 -문자를 제거
       */
        $like=array();
        if($sfield=='mem_phone'){
            if($skeyword){
                $skeyword = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $skeyword);
                $like = array(
                    'REGEXP_REPLACE(mem_phone,\'[가-힣a-zA[:space:]()-.,/!@#$%^&*]\',\'\')'=>$skeyword
                );
            }
        }
        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $this->{$this->modelname}->allow_search_field = array('mem_id', 'mem_userid', 'mem_email', 'mem_username', 'mem_nickname', 'mem_level', 'mem_homepage', 'mem_register_datetime', 'mem_register_ip', 'mem_lastlogin_datetime', 'mem_lastlogin_ip', 'mem_is_admin'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array('mem_id', 'mem_level', 'mem_is_admin'); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('member.mem_id', 'mem_userid', 'mem_username', 'mem_nickname', 'mem_email', 'mem_point', 'mem_register_datetime', 'mem_lastlogin_datetime', 'mem_level'); // 정렬이 가능한 필드

        $where = array();
        if ($this->input->get('mem_is_admin')) {
            $where['mem_is_admin'] = 1;
        }
        if ($this->input->get('mem_denied')) {
            $where['mem_denied'] = 1;
        }
        if ($mgr_id = (int) $this->input->get('mgr_id')) {
            if ($mgr_id > 0) {
                $where['mgr_id'] = $mgr_id;
            }
        }

        /**
         * 전화번호 없는 사용자는 빼고
        */
        $where['mem_phone !='] = null;
        $where['mem_phone !='] = "";
        $result = $this->{$this->modelname}
            ->get_admin_list($per_page, $offset, $where,$like, $findex, $forder, $sfield, $skeyword);
        $result['queryLog']=$this->db->last_query();
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {

                $where = array(
                    'mem_id' => element('mem_id', $val),
                );
                $result['list'][$key]['member_group_member'] = $this->Member_group_member_model->get('', '', $where, '', 0, 'mgm_id', 'ASC');
                //연락처 소유자
                $member_register =  $this->Member_register_model->get('', '', $where, '', 0, 'mrg_recommend_mem_id', 'ASC');
                $member_register_nickname= $this->Member_nickname_model->get('', '', array('mem_id'=>$member_register[0]['mrg_recommend_mem_id']), '1', 0, 'mni_id', 'DESC');
                //연락처 소유자 닉테임(업소명)
                $result['list'][$key]['member_register_nickname'] =$member_register_nickname[0]['mni_nickname'];
                $mgroup = array();
                if ($result['list'][$key]['member_group_member']) {
                    foreach ($result['list'][$key]['member_group_member'] as $mk => $mv) {
                        if (element('mgr_id', $mv)) {
                            $mgroup[] = $this->Member_group_model->item(element('mgr_id', $mv));
                        }
                    }
                }
                $result['list'][$key]['member_group'] = '';
                if ($mgroup) {
                    foreach ($mgroup as $mk => $mv) {
                        if ($result['list'][$key]['member_group']) {
                            $result['list'][$key]['member_group'] .= ', ';
                        }
                        $result['list'][$key]['member_group'] .= element('mgr_title', $mv);
                    }
                }
//                $result['list'][$key]['display_name'] = display_username(
//                    element('mem_userid', $val),
//                    element('mem_nickname', $val),
//                    element('mem_icon', $val)
//                );
                $result['list'][$key]['meta'] = $this->Member_meta_model->get_all_meta(element('mem_id', $val));
                $result['list'][$key]['social'] = $this->Social_meta_model->get_all_meta(element('mem_id', $val));
                $result['list'][$key]['register']=$this->Social_meta_model->get_all_meta(element('mem_id', $val));
                $result['list'][$key]['num'] = $list_num--;
            }
        }

        $view['view']['data'] = $result;
        $result['req_mem_point']=element("mem_point",$req_mem);

        echo json_encode($result);
    }

}