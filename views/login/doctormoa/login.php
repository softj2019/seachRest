<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<header class="m-header">
    <div class="in-hd sub-hd">
        <div class="logo-box">
            <button type="button" class="left-btn">이전</button>
            <h1 class="logo"><a href="/">닥터모아</a></h1>
        </div>
        <div class="src-out">
            <p class="blue-txt">로그인</p>
            <button type="button" class="ham-btn"></button>
        </div>
    </div>
</header>
<div class="in-box">
    <h1 class="logo-box"><a href="/">닥터모아</a></h1>
    <div class="login-box">
    <?php
    echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
    echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
    echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
    $attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
    echo form_open(current_full_url(), $attributes);
    ?>
        <input type="hidden" name="url" value="<?php echo html_escape($this->input->get_post('url')); ?>" />
        <input name="mem_userid" type="text" class="input-1 w100 mb10" placeholder="아이디">
        <input name="mem_password" type="password" class="input-1 w100" placeholder="비밀번호">
        <input type="checkbox" name="autologin"  id="autologin" value="1">
        <label for="autologin" class="check-b">자동로그인</label>

        <button type="submit" class="login-btn">로그인</button>
        <ul class="for-ul">
            <li><a href="<?php echo site_url('findaccount'); ?>">아이디찾기</a></li>
            <li><a href="<?php echo site_url('findaccount'); ?>">비밀번호찾기</a></li>
            <li><a href="<?php echo site_url('register'); ?>">회원가입</a></li>
        </ul>
        <div class="hr"></div>
    <?php echo form_close(); ?>
    <?php
    if ($this->cbconfig->item('use_sociallogin')) {
    $this->managelayout->add_js(base_url('assets/js/social_login.js'));
    ?>
        <button type="button" class="kakao-lo-btn sns-lo" onClick="social_connect_on('kakao');">카카오톡 로그인</button>
        <button type="button" class="naver-lo-btn sns-lo" onClick="social_connect_on('naver');">네이버 로그인</button>
        <button type="button" class="google-lo-btn sns-lo" onClick="social_connect_on('google');">구글 로그인</button>
    <?php } ?>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#flogin').validate({
		rules: {
			mem_userid : { required:true, minlength:3 },
			mem_password : { required:true, minlength:4 }
		}
	});
});
$(document).on('change', "input:checkbox[name='autologin']", function() {
	if (this.checked) {
		$('.autologinalert').show(300);
	} else {
		$('.autologinalert').hide(300);
	}
});
//]]>
</script>
