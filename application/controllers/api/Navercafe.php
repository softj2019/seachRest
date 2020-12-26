<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navercafe extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Navercafe');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Navercafe_model';

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
    public function auth()
    {
        if ($this->input->get('code')) {
            $url = 'https://nid.naver.com/oauth2.0/token';
            $url.= sprintf("?client_id=%s&client_secret=%s&grant_type=authorization_code&state=%s&code=%s",
                'IJPQuEMEEREb6OJZUnhr', '5JMA9bHkMS', $this->input->get('state', null, ''), $this->input->get('code'));

            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_SSLVERSION,1);
            curl_setopt ($ch, CURLOPT_HEADER, 0);
            curl_setopt ($ch, CURLOPT_POST, 0);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $json = json_decode($result, true);

            if (element('access_token', $json)) {

                $this->session->set_userdata(
                    'naver_access_token',
                    element('access_token', $json)
                );

               redirect('api/navercafe/write');

            } else {

                alert_close('로그인에 실패하였습니다');

            }
        }

        if ($this->input->get('state')) {
            if ($this->input->get('state') === $this->session->userdata('naver_state')) {
                return RESPONSE_SUCCESS;
            } else {
                return RESPONSE_UNAUTHORIZED;
            }
            exit;
        }

        if ( ! $this->session->userdata('naver_access_token')) {
            $this->load->helper('string');
            $state = random_string('alnum', 50);
            $this->session->set_userdata('naver_state', $state);

            $url = 'https://nid.naver.com/oauth2.0/authorize';
            $url .= sprintf("?client_id=%s&response_type=code&redirect_uri=%s&state=%s",
                'IJPQuEMEEREb6OJZUnhr', urlencode(site_url('api/navercafe/auth')), $state);

            redirect($url);
        }else{
            redirect('api/navercafe/write');
        }

    }
    public function write()
    {

        $token = $this->session->userdata('naver_access_token');
        $header = "Bearer ".$token; // Bearer 다음에 공백 추가
        $clubid = "10050146";// 카페의 고유 ID값
        $menuid = "479"; // 카페 게시판 id (상품게시판은 입력 불가)
        $url = "https://openapi.naver.com/v1/cafe/".$clubid."/menu/".$menuid."/articles";
        $subject = urlencode("cafe php 네이버 multi-part 이미지 첨부 테스트 php");
        $content = urlencode("<font color='red'>multi-part 로 첨부한 글입니다. php 이미지 첨부");

        $postvars_str = array("subject" => $subject, "content" => $content);
        $is_post = true;
        $ch = curl_init();
        // 업로드할 파일 정보
//        $cfile1 = new CURLFile('YOUR_FILE_1', '/assets/images/preload.png');
//        $cfile2 = new CURLFile('YOUR_FILE_2', 'image/jpeg');

        // blog 포스트 필수 요청 변수 image, title, contents 지정
        $postvars = array(
//            "image[0]" => $cfile1,
//            "image[1]" => $cfile2,
            "subject" => $subject,
            "content" => $content
        );
        // 요청헤더 설정
        $headers = array();
        $headers[] = "Authorization: ".$header;
        $headers[] = "Content-Type: multipart/form-data";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // 헤더 내용 출력
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        echo $headerSent;
        echo "<br>[status_code]:".$status_code."<br>";
        // 결과 출력
        curl_close ($ch);
        $data_object = json_decode($response,true);

        foreach ($data_object as $key=>$value) {

        }
        if ($status_code == 200)
        {
            echo $response;


            $updatedata = array();

            $updatedata = array(
                "clubid" => $clubid,
                "menuid" => $menuid,
                "subject" => $subject,
                "content" => $content,
                "status_code" => $status_code,
                "article_id" => $data_object["message"]["result"]["articleId"],
                "article_url" => $data_object["message"]["result"]["articleUrl"],

            );
            $this->Navercafe_model->insert($updatedata);
        }

        else {
            $updatedata = array();
            echo "Error 내용:" . $response;
                if($status_code == 403){
                if($data_object["message"]["error"]["code"]=="999"){

                    $updatedata = array(
                       "clubid" => $clubid,
                       "menuid" => $menuid,
                       "subject" => $subject,
                       "content" => $content,
                       "status_code" => $status_code,
                       "error_code" => $data_object["message"]["error"]["code"],
                       "message" => $data_object["message"]["error"]["message"],

                    );
                    $this->Navercafe_model->insert($updatedata);
                }

            }
            if($status_code == 401) {
                if ($data_object["errorCode"] == "024") {
                    //state 코드를 다시 발급한뒤 진행한다.
                    $this->load->helper('string');
                    $state = random_string('alnum', 50);
                    $this->session->set_userdata('naver_state', $state);

                    $url = 'https://nid.naver.com/oauth2.0/authorize';
                    $url .= sprintf("?client_id=%s&response_type=code&redirect_uri=%s&state=%s",
                        'IJPQuEMEEREb6OJZUnhr', urlencode(site_url('api/navercafe/auth')), $state);

                    $updatedata = array(
                        "clubid" => $clubid,
                        "menuid" => $menuid,
                        "subject" => $subject,
                        "content" => $content,
                        "status_code" => $status_code,
                        "error_code" => $data_object["errorCode"],
                        "message" => $data_object["errorMessage"],

                    );
                    $this->Navercafe_model->insert($updatedata);

                    redirect($url);
                }
            }

        }
    }

}

