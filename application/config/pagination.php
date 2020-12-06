<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//전체 감싸기
$config['full_tag_open'] = '';
$config['full_tag_close'] = '';
//처음으로
$config['first_link'] = '≪';
//처음으로 열기닫기
$config['first_tag_open'] = '';
$config['first_tag_close'] = '';
//처음으로 url 설정
$config['first_url'] = '';
//끝으로
$config['last_link'] = '';
$config['last_tag_open'] = '';
$config['last_tag_close'] = '';

//다음
$config['next_link'] = '＞>>>>>';
$config['next_tag_open'] = '';
$config['next_tag_close'] = '';
//이전
$config['prev_link'] = '';
$config['prev_tag_open'] = '';
$config['prev_tag_close'] = '';
//현재 페이지
$config['cur_tag_open'] = '';
$config['cur_tag_close'] = '';
//숫자링크
$config['num_tag_open'] = '';
$config['num_tag_close'] = '';
//a테그속성 추가
$config['_attributes'] = array('class' => 'page-link');