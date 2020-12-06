<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<header class="m-header">
    <div class="in-hd sub-hd">
        <div class="logo-box">
            <button type="button" class="left-btn">이전</button>
            <h1 class="logo"><a href="/">닥터모아</a></h1>
        </div>
        <div class="src-out">
            <p class="blue-txt">회원 비밀번호 확인</p>
            <button type="button" class="ham-btn"></button>
        </div>
    </div>
</header>
<div class="content-box info-con">
	<ul class="nav nav-tabs hidden">
		<li><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
		<li><a href="<?php echo site_url('mypage/post'); ?>" title="나의 작성글">나의 작성글</a></li>

		<?php if ($this->cbconfig->item('use_point')) { ?>
			<li><a href="<?php echo site_url('mypage/point'); ?>" title="포인트">포인트</a></li>
		<?php } ?>

		<li><a href="<?php echo site_url('mypage/followinglist'); ?>" title="팔로우">팔로우</a></li>
		<li><a href="<?php echo site_url('mypage/like_post'); ?>" title="내가 추천한 글">추천</a></li>
		<li><a href="<?php echo site_url('mypage/scrap'); ?>" title="나의 스크랩">스크랩</a></li>
		<li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
		<li <?php if (uri_string() === 'membermodify') { ?>class="active" <?php } ?> ><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
		<li <?php if (uri_string() === 'membermodify/memberleave') { ?>class="active" <?php } ?>><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
	</ul>


	<?php
	echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
	echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	$attributes = array('name' => 'fconfirmpassword', 'id' => 'fconfirmpassword');
	echo form_open(current_url(), $attributes);
	?>
		<ol class="cont-ul info-ul">
			<li>
				<span>아이디</span>
				<div class="form-text"><strong><?php echo $this->member->item('mem_userid'); ?></strong></div>
			</li>
			<li>
				<span>비밀번호</span>
                <input type="password" class="input-3" id="mem_password" name="mem_password" />
                <button class="blue-btn" type="submit">확인</button>
			</li>
			<li>
				<span></span>
				<div>
					<span class="fa fa-exclamation-circle"></span>
					외부로부터 회원님의 정보를 안전하게 보호하기 위해 비밀번호를 확인하셔야 합니다.
				</div>
			</li>
		</ol>
	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fconfirmpassword').validate({
		rules: {
			mem_password : { required:true, minlength:4 }
		}
	});
});
//]]>
</script>
