<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apiboard extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Post');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Post_model';

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
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $view['view']['sort'] = array(
//            'mem_id' => $param->sort('mem_id', 'asc'),
//            'mem_userid' => $param->sort('mem_userid', 'asc'),
//            'mem_username' => $param->sort('mem_username', 'asc'),
//            'mem_nickname' => $param->sort('mem_nickname', 'asc'),
//            'mem_email' => $param->sort('mem_email', 'asc'),
//            'mem_point' => $param->sort('mem_point', 'asc'),
//            'mem_register_datetime' => $param->sort('mem_register_datetime', 'asc'),
//            'mem_lastlogin_datetime' => $param->sort('mem_lastlogin_datetime', 'asc'),
//            'mem_level' => $param->sort('mem_level', 'asc'),
        );
        $findex = $this->input->get('findex', null, 'member.mem_id');
        $forder = $this->input->get('forder', null, 'desc');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');
//        $skeyword =str_replace('-','',$this->input->get('skeyword', null, ''));
//        $skeyword - str_replace('-','',$this->input->get('skeyword', null, ''));
        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $this->{$this->modelname}->allow_search_field = array('post_title'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('post_id'); // 정렬이 가능한 필드

        $where = array();
//        if ($this->input->get('mem_is_admin')) {
//            $where['mem_is_admin'] = 1;
//        }

        /**
         * 전화번호 없는 사용자는 빼고
        */
        $where['brd_id'] = 2;

        $result = $this->{$this->modelname}
            ->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
        $result['queryLog']=$this->db->last_query();
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;


        $view['view']['data'] = $result;

        //rest 성공시
        $this->output->set_status_header(200);
        echo json_encode($result);
    }
}