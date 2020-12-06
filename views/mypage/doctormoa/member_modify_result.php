<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<header class="m-header">
    <div class="in-hd sub-hd">
        <div class="logo-box">
            <button type="button" class="left-btn">이전</button>
            <h1 class="logo"><a href="/">닥터모아</a></h1>
        </div>
        <div class="src-out">
            <p class="blue-txt">내정보수정</p>
            <button type="button" class="ham-btn"></button>
        </div>
    </div>
</header>
<div class="content-box info-con">
	<ul class="nav nav-tabs">
		<li><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
		<li><a href="<?php echo site_url('mypage/post'); ?>" title="나의 작성글">나의 작성글</a></li>

		<?php if ($this->cbconfig->item('use_point')) { ?>
			<li><a href="<?php echo site_url('mypage/point'); ?>" title="포인트">포인트</a></li>
		<?php } ?>

		<li><a href="<?php echo site_url('mypage/followinglist'); ?>" title="팔로우">팔로우</a></li>
		<li><a href="<?php echo site_url('mypage/like_post'); ?>" title="내가 추천한 글">추천</a></li>
		<li><a href="<?php echo site_url('mypage/scrap'); ?>" title="나의 스크랩">스크랩</a></li>
		<li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
		<li class="active"><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
		<li><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
	</ul>

	<h3>회원 정보 수정</h3>

	<div class="final">
		<div class="table-box">
			<div class="table-heading">회원 정보 수정</div>
			<div class="table-body">
				<div class="msg_content">
					<?php echo element('result_message', $view); ?>
					<p class="btn_final mt20">
						<a href="<?php echo site_url(); ?>" class="btn btn-danger" title="<?php echo html_escape($this->cbconfig->item('site_title'));?>" title="<?php echo html_escape($this->cbconfig->item('site_title'));?>">홈페이지로 이동</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
