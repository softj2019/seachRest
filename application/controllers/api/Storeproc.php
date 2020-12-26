<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Storeproc extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Member','Member_register','Member_group_member');
    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'string');

    function __construct()
    {
        parent::__construct();

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
        //주소록을 받아와 파일로 저장한다.
        $date = cdate('YmdHis');
        file_put_contents("_calllist_".$date.".json", $this->input->post("contact"));
        $data_object = json_decode($this->input->post("contact"),true);
//        $this->db->select('mem_phone,mem_upper_id');
//        $qry = $this->db->get('cb_member');
//        $result = $qry->result_array();
//        $data['queryLog']=$this->db->last_query();



        foreach ($data_object as $key=>$value){
            $this->db->select('mem_phone,mem_upper_id');
            $this->db->where(
                array(
                    'mem_phone'=>$value['phone'],
                    'mem_upper_id'=>$value['mem_email'],

                )
            );
            $qry = $this->db->get('cb_member');
            $result = $qry->result_array();
            $data['queryLog']=$this->db->last_query();
            foreach ($result as $key=>$value){
                $data['status']['$key']=" >>>".$value["mem_phone"];
            }
            $updatedata = array(
                'mem_userid' =>$date.$key.$value['phone'],
                'mem_phone' => $value['phone'],
                'mem_adminmemo' => $value['mem_adminmemo'],
            );


            if($result.sizeof() > 0){
                $this->db
                    ->where('mem_upper_id', $value['mem_email'])
                    ->where('mem_phone', $value['phone'])
                    ->update("cb_member",  $updatedata );
            }else{

                $mem_id =  $this->Member_model->insert($updatedata);

                $member_register_data = array(
                    'mem_id' => $mem_id,
                    'mrg_recommend_mem_id' => $value['mrg_recommend_mem_id'],
                    'mem_id' => $mem_id,
                    'mrg_datetime' => cdate('Y-m-d H:i:s'),
                );
                $member_group_member = array(
                    'mem_id' => $mem_id,
                    'mgr_id' => 4,
                    'mgm_datetime' => cdate('Y-m-d H:i:s'),
                );

                $this->Member_register_model->insert($member_register_data);
                $this->Member_group_member_model->insert($member_group_member);

            }

//            $data['queryLog']=$this->db->last_query();
        }

        $this->output->set_status_header(200);
//        $data['errors']['query']=$this->db->last_query();
//        $data['errors']['msg']="데이터저장중 오류발행";
        $data['status']['msg']="fail >>>".$result[0][1];
//        $data['errors']="주소록 저장중 오류 발생";
        echo json_encode($data);
    }

}