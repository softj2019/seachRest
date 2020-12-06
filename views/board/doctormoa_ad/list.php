<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<header class="m-header">
    <div class="hd-in flexwrap hidden">
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
<div class="content1">
    <div class="com-hd">
        <p><?php echo html_escape(element('board_name', element('board', element('list', $view)))); ?></p>
<!--        <a href="community-note.html" class="blue-btn">글쓰기</a>-->
        <?php if (element('write_url', element('list', $view))) { ?>
<!--            <div class="pull-right">-->
                <a href="<?php echo element('write_url', element('list', $view)); ?>" class="blue-btn">글쓰기</a>
<!--            </div>-->
        <?php } ?>
    </div>

	<div class="table-top hidden">
		<?php if ( ! element('access_list', element('board', element('list', $view))) && element('use_rss_feed', element('board', element('list', $view)))) { ?>
			<a href="<?php echo rss_url(element('brd_key', element('board', element('list', $view)))); ?>" class="btn btn-default btn-sm" title="<?php echo html_escape(element('board_name', element('board', element('list', $view)))); ?> RSS 보기"><i class="fa fa-rss"></i></a>
		<?php } ?>
		<select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape($this->input->get('categroy_id')); ?>&amp;findex=' + this.value;">
			<option value="">정렬하기</option>
			<option value="post_datetime desc" <?php echo $this->input->get('findex') === 'post_datetime desc' ? 'selected="selected"' : '';?>>날짜순</option>
			<option value="post_hit desc" <?php echo $this->input->get('findex') === 'post_hit desc' ? 'selected="selected"' : '';?>>조회수</option>
			<option value="post_comment_count desc" <?php echo $this->input->get('findex') === 'post_comment_count desc' ? 'selected="selected"' : '';?>>댓글수</option>
			<?php if (element('use_post_like', element('board', element('list', $view)))) { ?>
				<option value="post_like desc" <?php echo $this->input->get('findex') === 'post_like desc' ? 'selected="selected"' : '';?>>추천순</option>
			<?php } ?>
		</select>
		<?php if (element('use_category', element('board', element('list', $view))) && ! element('cat_display_style', element('board', element('list', $view)))) { ?>
			<select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=' + this.value;">
				<option value="">카테고리선택</option>
				<?php
				$category = element('category', element('board', element('list', $view)));
				function ca_select($p = '', $category = '', $category_id = '')
				{
					$return = '';
					if ($p && is_array($p)) {
						foreach ($p as $result) {
							$exp = explode('.', element('bca_key', $result));
							$len = (element(1, $exp)) ? strlen(element(1, $exp)) : 0;
							$space = str_repeat('-', $len);
							$return .= '<option value="' . html_escape(element('bca_key', $result)) . '"';
							if (element('bca_key', $result) === $category_id) {
								$return .= 'selected="selected"';
							}
							$return .= '>' . $space . html_escape(element('bca_value', $result)) . '</option>';
							$parent = element('bca_key', $result);
							$return .= ca_select(element($parent, $category), $category, $category_id);
						}
					}
					return $return;
				}
				echo ca_select(element(0, $category), $category, $this->input->get('category_id'));
				?>
			</select>
		<?php } ?>
		<div class="col-md-6 hidden">
			<div class=" searchbox">
				<form class="navbar-form navbar-right pull-right" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
					<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
					<input type="hidden" name="category_id" value="<?php echo html_escape($this->input->get('category_id')); ?>" />
					<div class="form-group">
						<select class="input pull-left px100" name="sfield">
							<option value="post_both" <?php echo ($this->input->get('sfield') === 'post_both') ? ' selected="selected" ' : ''; ?>>제목+내용</option>
							<option value="post_title" <?php echo ($this->input->get('sfield') === 'post_title') ? ' selected="selected" ' : ''; ?>>제목</option>
							<option value="post_content" <?php echo ($this->input->get('sfield') === 'post_content') ? ' selected="selected" ' : ''; ?>>내용</option>
							<option value="post_nickname" <?php echo ($this->input->get('sfield') === 'post_nickname') ? ' selected="selected" ' : ''; ?>>회원명</option>
							<option value="post_userid" <?php echo ($this->input->get('sfield') === 'post_userid') ? ' selected="selected" ' : ''; ?>>회원아이디</option>
						</select>
						<input type="text" class="input px150" placeholder="Search" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" />
						<button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>
			<div class="searchbuttonbox">
				<button class="btn btn-primary btn-sm pull-right" type="button" onClick="toggleSearchbox();"><i class="fa fa-search"></i></button>
			</div>
			<?php if (element('point_info', element('list', $view))) { ?>
				<div class="point-info pull-right mr10">
					<button type="button" class="btn-point-info" ><i class="fa fa-info-circle"></i></button>
					<div class="point-info-content alert alert-warning"><strong>포인트안내</strong><br /><?php echo element('point_info', element('list', $view)); ?></div>
				</div>
			<?php } ?>
		</div>
		<script type="text/javascript">
		//<![CDATA[
		function postSearch(f) {
			var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
			if (skeyword.length < 2) {
				alert('2글자 이상으로 검색해 주세요');
				f.skeyword.focus();
				return false;
			}
			return true;
		}
		function toggleSearchbox() {
			$('.searchbox').show();
			$('.searchbuttonbox').hide();
		}
		<?php
		if ($this->input->get('skeyword')) {
			echo 'toggleSearchbox();';
		}
		?>
		$(document).on('click', '.btn-point-info', function() {
			$('.point-info-content').toggle();
		});
		//]]>
		</script>
	</div>

	<?php
	if (element('use_category', element('board', element('list', $view))) && element('cat_display_style', element('board', element('list', $view))) === 'tab') {
		$category = element('category', element('board', element('list', $view)));
	?>
		<ul class="nav nav-tabs clearfix">
			<li role="presentation" <?php if ( ! $this->input->get('category_id')) { ?>class="active" <?php } ?>><a href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=">전체</a></li>
			<?php
			if (element(0, $category)) {
				foreach (element(0, $category) as $ckey => $cval) {
			?>
				<li role="presentation" <?php if ($this->input->get('category_id') === element('bca_key', $cval)) { ?>class="active" <?php } ?>><a href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?findex=<?php echo html_escape($this->input->get('findex')); ?>&category_id=<?php echo element('bca_key', $cval); ?>"><?php echo html_escape(element('bca_value', $cval)); ?></a></li>
			<?php
				}
			}
			?>
		</ul>
	<?php } ?>

	<?php
	$attributes = array('name' => 'fboardlist', 'id' => 'fboardlist');
	echo form_open('', $attributes);
	?>
    <div class="com-main">
        <ul class="com-main-ul">
            <li class="com-tit-li">
                <p class="li-num">번호</p>
                <p class="pl10">내용</p>
                <div class=""></div>
            </li>
            <?php
            if (element('notice_list', element('list', $view))) {
            foreach (element('notice_list', element('list', $view)) as $result) {
            ?>
            <li>
                <p class="li-num"><?php echo element('num', $result); ?></p>
                <div class="bor-com">
                    <p><a href="<?php echo element('post_url', $result); ?>"><?php echo html_escape(element('title', $result)); ?></a></p>
                    <div class="bor-inf">
                        <p class="com-id"><?php echo element('display_name', $result); ?></p>
                        <p class="com-day"><?php echo element('display_datetime', $result); ?></p>
                        <p>조회수 <span><?php echo number_format(element('post_hit', $result)); ?></span></p>
                    </div>
                </div>
            </li>

            <?php
				}
			}
            if (element('list', element('data', element('list', $view)))) {
                foreach (element('list', element('data', element('list', $view))) as $result) {
            ?>
                <li>
                    <p class="li-num"><?php echo element('num', $result); ?></p>
                    <div class="bor-com">
                        <p><a href="<?php echo element('post_url', $result); ?>"><?php echo html_escape(element('title', $result)); ?></a></p>
                        <div class="bor-inf">
                            <p class="com-id"><?php echo element('display_name', $result); ?></p>
                            <p class="com-day"><?php echo element('display_datetime', $result); ?></p>
                            <p>조회수 <span><?php echo number_format(element('post_hit', $result)); ?></span></p>
                        </div>
                    </div>
                </li>
            <?php
                }
            }
            if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
                ?>
                <li>
                    게시물이 없습니다
                </li>
            <?php } ?>
        </ul>
    </div>

	<?php echo form_close(); ?>

	<div class="table-bottom mt20">
		<div class="pull-left mr10">
			<a href="<?php echo element('list_url', element('list', $view)); ?>" class="btn btn-default">목록</a>
			<?php if (element('search_list_url', element('list', $view))) { ?>
				<a href="<?php echo element('search_list_url', element('list', $view)); ?>" class="btn btn-default btn-sm">검색목록</a>
			<?php } ?>
		</div>
		<?php if (element('is_admin', $view)) { ?>
			<div class="pull-left">
				<button type="button" class="btn btn-default btn-sm admin-manage-list"><i class="fa fa-cog big-fa"></i>관리</button>
				<div class="btn-admin-manage-layer admin-manage-layer-list">
					<?php if (element('is_admin', $view) === 'super') { ?>
						<div class="item" onClick="document.location.href='<?php echo admin_url('board/boards/write/' . element('brd_id', element('board', element('list', $view)))); ?>';"><i class="fa fa-cog"></i> 게시판설정</div>
						<div class="item" onClick="post_multi_copy('copy');"><i class="fa fa-files-o"></i> 복사하기</div>
						<div class="item" onClick="post_multi_copy('move');"><i class="fa fa-arrow-right"></i> 이동하기</div>
						<div class="item" onClick="post_multi_change_category();"><i class="fa fa-tags"></i> 카테고리변경</div>
					<?php } ?>
					<div class="item" onClick="post_multi_action('multi_delete', '0', '선택하신 글들을 완전삭제하시겠습니까?');"><i class="fa fa-trash-o"></i> 선택삭제하기</div>
					<div class="item" onClick="post_multi_action('post_multi_secret', '0', '선택하신 글들을 비밀글을 해제하시겠습니까?');"><i class="fa fa-unlock"></i> 비밀글해제</div>
					<div class="item" onClick="post_multi_action('post_multi_secret', '1', '선택하신 글들을 비밀글로 설정하시겠습니까?');"><i class="fa fa-lock"></i> 비밀글로</div>
					<div class="item" onClick="post_multi_action('post_multi_notice', '0', '선택하신 글들을 공지를 내리시겠습니까?');"><i class="fa fa-bullhorn"></i> 공지내림</div>
					<div class="item" onClick="post_multi_action('post_multi_notice', '1', '선택하신 글들을 공지로 등록 하시겠습니까?');"><i class="fa fa-bullhorn"></i> 공지올림</div>
					<div class="item" onClick="post_multi_action('post_multi_blame_blind', '0', '선택하신 글들을 블라인드 해제 하시겠습니까?');"><i class="fa fa-exclamation-circle"></i> 블라인드해제</div>
					<div class="item" onClick="post_multi_action('post_multi_blame_blind', '1', '선택하신 글들을 블라인드 처리 하시겠습니까?');"><i class="fa fa-exclamation-circle"></i> 블라인드처리</div>
					<div class="item" onClick="post_multi_action('post_multi_trash', '', '선택하신 글들을 휴지통으로 이동하시겠습니까?');"><i class="fa fa-trash"></i> 휴지통으로</div>
				</div>
			</div>
		<?php } ?>

	</div>
	<nav><?php echo element('paging', element('list', $view)); ?></nav>
</div>

<?php echo element('footercontent', element('board', element('list', $view))); ?>

<?php
if (element('highlight_keyword', element('list', $view))) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js')); ?>
<script type="text/javascript">
//<![CDATA[
$('#fboardlist').highlight([<?php echo element('highlight_keyword', element('list', $view));?>]);
//]]>

</script>
<?php } ?>
