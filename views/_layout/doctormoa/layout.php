<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>
    <?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
    <?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
    <?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
    <?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
    <?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>
    <link href="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/css/reset.css" rel="stylesheet" type="text/css">
    <link href="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/css/common.css" rel="stylesheet" type="text/css">
    <link href="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/css/system.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400&display=swap&subset=korean" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.3.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet" type="text/css">
    <link href="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/plugins/slick-theme.css" rel="stylesheet" type="text/css">

    <?php echo $this->managelayout->display_css(); ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
<!--    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>-->
    <script type="text/javascript">
    // 자바스크립트에서 사용하는 전역변수 선언
    var cb_url = "<?php echo trim(site_url(), '/'); ?>";
    var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
    var cb_charset = "<?php echo config_item('charset'); ?>";
    var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
    var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
    var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
    var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
    var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
    var is_admin = "<?php echo $this->member->is_admin(); ?>";
    var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
    var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
    var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
    var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
    var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
    var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";
    </script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/html5shiv.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/respond.min.js'); ?>"></script>
    <![endif]-->
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/common.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/sideview.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo my_base_url('assets/js/js.cookie.js'); ?>"></script>
    <?php echo $this->managelayout->display_js(); ?>
</head>
<body>
<div class="wrap">
    <header class="m-header">
        <div class="hd-in flexwrap">
            <h1 class="logo"><a href="/">닥터모아</a></h1>
            <div class="src-out">
                <div class="src-form">
                    <form name="mobile_header_search" id="mobile_header_search" action="<?php echo site_url('search'); ?>" onSubmit="return headerSearch(this);" class="flexwrap">
                        <input type="text" class="src-inp" name="skeyword" accesskey="s" />
                        <button type="submit" class="src-btn"></button>
                    </form>
                </div>
                <button type="button" class="ham-btn"></button>
            </div>
        </div>
    </header>
        <!-- 본문 시작 -->
        <?php if (isset($yield))echo $yield; ?>
        <!-- 본문 끝 -->
    <div class="tab-bg"></div>
    <div class="right-tab">
        <div class="tab-hd flexwrap">
            <button type="button" class="closebox"></button>
            <ul class="main-tab-ul flexcenter">
                <li>
                    <?php if ($this->member->is_admin() === 'super') { ?>
                        <i class="fa fa-cog"></i><a href="<?php echo site_url(config_item('uri_segment_admin')); ?>" title="관리자 페이지로 이동">관리자</a> &nbsp;|&nbsp;
                    <?php } ?>
                    <?php
                    if ($this->member->is_member()) {
                        ?>
                        &nbsp;<a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>">로그아웃</a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>">로그인</a>
                        &nbsp;|&nbsp;<a href="<?php echo site_url('register'); ?>">회원가입</a>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        <ul class="tab-lo">
            <?php
            if ($this->member->is_member()) {
                ?>
                <li><a href="<?php echo site_url('mypage'); ?>">마이페이지</a></li>
            <?php }?>
            <li><a href="/main/category">진료선택</a></li>
            <li><a href="/board/b-a-2">방문후기</a></li>
            <li><a href="/board/b-a-3">자유게시판</a></li>
            <li><a href="/board/b-c-1">질문과 답변</a></li>
            <li><a href="/board/b-b-1">제품판매</a></li>
            <li><a href="/board/b-b-2">구인구직</a></li>
            <li><a href="/board/b-a-3">공지사항</a></li>
            <li><a href="/write/b-a-1">의사/병원 등록하기</a></li>
        </ul>

    </div>

    <!-- main start -->
	<div class="main hidden">
		<div class="container">
			<?php if (element('use_sidebar', $layout)) {?>
				<div class="left">
			<?php } ?>

			<!-- 본문 시작 -->
			<?php if (isset($yield))echo $yield; ?>
			<!-- 본문 끝 -->

			<?php if (element('use_sidebar', $layout)) {?>

				</div>
				<div class="sidebar">
					<?php $this->load->view(element('layout_skin_path', $layout) . '/sidebar'); ?>
				</div>

			<?php } ?>

		</div>
	</div>
	<!-- main end -->
    <div class="modal" id="ham-mo">
        <div class="modal-bg"></div>
        <div class="modalContent md ham-con">
            <header class="modalHd">
                <h3>더보기</h3>
                <button class="modalClose"></button>
            </header>
            <div class="modalBody pt0 ham-body">
                <ul class="cont-ul">
                    <li><a href="/board/b-a-2">방문후기</a></li>
                    <li><a href="/board/b-a-3">자유게시판</a></li>
                    <li><a href="/board/b-c-1">질문과 답변</a></li>
                    <li><a href="/board/b-b-1">제품판매</a></li>
                    <li><a href="/board/b-b-2">구인구직</a></li>
                    <li><a href="/board/b-a-3">공지사항</a></li>
                    <li><a href="/write/b-a-1">의사/병원 등록하기</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- footer start -->
	<footer class="footer">
        <ul class="foot-ul flexcenter">
            <li><a href="/board/b-c-2">입점문의</a>ㅣ</li>
            <li><a href="<?php echo document_url('provision'); ?>">이용약관</a>ㅣ</li>
            <li><a href="<?php echo document_url('privacy'); ?>" class="bold">개인정보방침</a>ㅣ</li>
            <li><a href="<?php echo document_url('aboutus'); ?>">이용안내</a></li>
        </ul>
        <ul class="foot-ul foot-sns flexcenter">
            <li><a href="https://www.facebook.com/%EB%8B%A5%ED%84%B0%EB%AA%A8%EC%95%84-112086317327626/?modal=admin_todo_tour" class="facebook-i"></a></li>
            <li><a href="https://www.instagram.com/doctor__moa/" class="insta-i"></a></li>
            <li><a href="https://pf.kakao.com/_mHCdK" class="kakao-i"></a></li>
            <li><a href="https://twitter.com/FVWNS1qp9IMUvw0" class="twitter-i"></a></li>
            <li><a href="https://www.youtube.com/channel/UCl6MwKYM27exMNGsSJxCO9A/featured?view_as=subscriber" class="youtube-i"></a></li>
        </ul>
        <ul class="foot-inf">
            <li>상호명 : 닥터모아 ㅣ 사업자등록번호 : 000-00-00000</li>
            <li>대표 : 대표님 ㅣ 대표번호 : 000-0000-0000</li>
            <li>
                <?php if ($this->cbconfig->item('company_owner')) { ?>대표 : <?php echo $this->cbconfig->item('company_owner'); ?> <?php } ?>
                <?php if ($this->cbconfig->item('company_phone')) { ?> | 대표번호 <?php echo $this->cbconfig->item('company_phone'); ?> <?php } ?>
                <?php if ($this->cbconfig->item('company_fax')) { ?>| 팩스 <?php echo $this->cbconfig->item('company_fax'); ?><?php } ?>
            </li>
            <li>
                <?php if ($this->cbconfig->item('company_address')) { ?>
                    <span><?php echo $this->cbconfig->item('company_address'); ?>
                        <?php if ($this->cbconfig->item('company_zipcode')) { ?>(우편 <?php echo $this->cbconfig->item('company_zipcode'); ?>)<?php } ?>
					</span>
                <?php } ?>
            </li>
        </ul>
		<div class="container hidden">

			<div class="copyright">
				<?php if ($this->cbconfig->item('company_address')) { ?>
					<span><?php echo $this->cbconfig->item('company_address'); ?>
						<?php if ($this->cbconfig->item('company_zipcode')) { ?>(우편 <?php echo $this->cbconfig->item('company_zipcode'); ?>)<?php } ?>
					</span>
				<?php } ?>
				<?php if ($this->cbconfig->item('company_owner')) { ?><span><b>대표</b> <?php echo $this->cbconfig->item('company_owner'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_phone')) { ?><span><b>전화</b> <?php echo $this->cbconfig->item('company_phone'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_fax')) { ?><span><b>팩스</b> <?php echo $this->cbconfig->item('company_fax'); ?></span><?php } ?>
			</div>
			<div class="copyright">
				<?php if ($this->cbconfig->item('company_reg_no')) { ?><span><b>사업자</b> <?php echo $this->cbconfig->item('company_reg_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_retail_sale_no')) { ?><span><b>통신판매</b> <?php echo $this->cbconfig->item('company_retail_sale_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_added_sale_no')) { ?><span><b>부가통신</b> <?php echo $this->cbconfig->item('company_added_sale_no'); ?></span><?php } ?>
				<?php if ($this->cbconfig->item('company_admin_name')) { ?><span><b>정보관리책임자명</b> <?php echo $this->cbconfig->item('company_admin_name'); ?></span><?php } ?>
				<span>Copyright&copy; <?php echo $this->cbconfig->item('site_title'); ?>. All Rights Reserved.</span>
			</div>
			<?php
			if ($this->cbconfig->get_device_view_type() === 'mobile') {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-xs viewpcversion">PC 버전으로 보기</a></div>
			<?php
			} else {
				if ($this->cbconfig->get_device_type() === 'mobile') {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-lg viewmobileversion" style="width:100%;font-size:5em;">모바일 버전으로 보기</a></div>
			<?php
				} else {
			?>
				<div class="see_mobile"><a href="<?php echo current_full_url(); ?>" class="btn btn-primary btn-xs viewmobileversion">모바일 버전으로 보기</a></div>
			<?php
				}
			}
			?>
		</div>
	</footer>
	<!-- footer end -->
    <nav class="f-nav">
        <ul class="flexwrap">
            <li class=""><a href=""><i class="ham-i"></i></a></li>
<!--            <li><a href=""><i class="location-i"></i></a></li>-->
            <li><a href="board/b-a-1"><i class="search-i"></i></a></li>
            <li><a href="/"><i class="home-i"></i></a></li>
            <li><a id="mobileMyPage"><i class="mypage-i"></i></a></li>
        </ul>
    </nav>
</div>
<script type="text/javascript" src="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/plugins/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/plugins/moment/locale/ko.js"></script>
<script type="text/javascript" src="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/js/common.js"></script>
<script src="<?php echo my_base_url(element('layout_skin_url', $layout)); ?>/assets/js/system.js"></script>
<script type="text/javascript">
$(document).on('click', '.viewpcversion', function(){
	Cookies.set('device_view_type', 'desktop', { expires: 1 });
});
$(document).on('click', '.viewmobileversion', function(){
	Cookies.set('device_view_type', 'mobile', { expires: 1 });
});
$('#mobileMyPage').click(function () {
    var login_url = "<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>";
    var mypage_url= "<?php echo site_url('mypage'); ?>";
    if(is_member==="1"){
        location.href=mypage_url;
    }else{
        location.href=login_url;
    }
})
</script>
<?php echo element('popup', $layout); ?>
<?php echo $this->cbconfig->item('footer_script'); ?>

<!--
Layout Directory : <?php echo element('layout_skin_path', $layout); ?>,
Layout URL : <?php echo element('layout_skin_url', $layout); ?>,
Skin Directory : <?php echo element('view_skin_path', $layout); ?>,
Skin URL : <?php echo element('view_skin_url', $layout); ?>,
-->

</body>
</html>
