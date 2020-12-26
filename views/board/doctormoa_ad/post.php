<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php	$this->managelayout->add_js(base_url('plugin/zeroclipboard/ZeroClipboard.js')); ?>

<?php
if (element('syntax_highlighter', element('board', $view)) OR element('comment_syntax_highlighter', element('board', $view))) {
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shCore.css'));
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shThemeMidnight.css'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shCore.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushJScript.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushPhp.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushCss.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushXml.js'));
?>
	<script type="text/javascript">
	SyntaxHighlighter.config.clipboardSwf = '<?php echo base_url('assets/js/syntaxhighlighter/scripts/clipboard.swf'); ?>';
	var is_SyntaxHighlighter = true;
	SyntaxHighlighter.all();
	</script>
<?php } ?>

<?php echo element('headercontent', element('board', $view)); ?>

<div class="content1 board">
	<?php echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>'); ?>
    <p class="sub2-tit"><?php echo html_escape(element('post_title', element('post', $view))); ?></p>
    <div class="map  clearfix" id="map"></div>
    <div class="info-sub-con clearfix">
        <div class="info-sub1">
            <ul class="ul2-ul">
                <li><?=$view["extra_content"][9]["output"]?></li>
                <li class="ul2-name"><h3><?=$view["extra_content"][0]["output"]?></h3><span><?=$view["extra_content"][1]["output"]?></span></li>
                <li>
                    <div class="star-i top flexcenter">
                        <i class="<?=round(element('post_review_average', element('post', $view)))>=1?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', element('post', $view)))>=2?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', element('post', $view)))>=3?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', element('post', $view)))>=4?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', element('post', $view)))>=5?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <p class="rev-s"><?=round(element('post_review_average', element('post', $view)))?> <span>(리뷰 <?=element('post_review_count', element('post', $view))?> )</span></p>
                    </div>
                </li>
            </ul>
            <!--해시태그-->
            <?php if (element('tag', element('post', $view))) { ?>
            <ul class="flexcenter info-t">

            <?php foreach (element('tag', element('post', $view)) as $key => $value) { ?>
                <li><a href="<?php echo site_url('tags/?tag=' . html_escape(element('pta_tag', $value))); ?>" title="<?php echo html_escape(element('pta_tag', $value)); ?> 태그 목록"><?php echo html_escape(element('pta_tag', $value)); ?></a></li>
            <?php	} ?>
            </ul>
            <?php } ?>
            <ul class="flexcenter info-nav">
                <li><a href="">즐겨찾기</a></li>
                <li><a href="javascript:void(0);" onclick="moveKakaoMap()">주소찾기</a></li>
                <li class="review-btn-t"><a>리뷰작성</a></li><!--201027 수정-->
<!--                <li class="qt-btn"><a href="">질문하기</a></li>-->
                <li class="call-btn"><a href="tel:<?=$view["extra_content"][10]["output"]?>">전화하기</a></li>
            </ul>
        </div>
        <div class="info-sub2">
            <ul class="flexcenter info-nav2">
                <li class="on">상세정보</li>
                <li>리뷰</li>
                <li>Q&A</li>
            </ul>
            <div class="info-in1">
                <h3 class="info-tit flexcenter">의사약력</h3>
                    <ul class="in-content">
                        <?= nl2br(html_escape(($view["extra_content"][2]["output"])))?>
                    </ul>
                    <h3 class="info-tit flexcenter">위치 · 진료시간</h3>
                    <ul class="in-content2">
                        <li class="con-time">평일 - <?=$view["extra_content"][3]["output"]?></li>
                        <li class="con-time">점심시간 - <?=$view["extra_content"][5]["output"]?></li>
                        <li class="con-time blue">토요일 - <?=$view["extra_content"][4]["output"]?></li>
                        <li class="con-time red">일요일·공휴일 - <?=$view["extra_content"][6]["output"]?></li>
                        <li class="con-loc">
                            <div>
<!--                                <p>서울특별시 중구 남대문로 66-1 명덕빌딩 3,4층</p>-->
                                <p><span class="selectAddress"><?=$view["extra_content"][7]["output"]?></span><button type="button" class="add-btn">[주소복사]</button></p>
                            </div>
                        </li>
                        <li><a href="<?=$view["extra_content"][8]["output"]?>" class="con-btn">홈페이지 바로가기</a></li>
                    </ul>
            </div>
            <ul class="flexcenter info-nav2 mt10">
                <li>상세정보</li>
                <li class="on">리뷰</li>
                <li>Q&A</li>
            </ul>
            <div class="info-in2 ">
                <div class="info-in2 ">
                    <h3 class="info-tit flexcenter">리뷰 모아보기</h3>
                    <div>
                        <div class="star-box">
                            <p>별점평균</p>
                            <div class="flexwrap">
                                <div class="star-i top2 flexcenter">
                                    <i class="<?=round(element('post_review_average', element('post', $view)))>=1?"ri-star-fill":"ri-star-line"?> yell"></i>
                                    <i class="<?=round(element('post_review_average', element('post', $view)))>=2?"ri-star-fill":"ri-star-line"?> yell"></i>
                                    <i class="<?=round(element('post_review_average', element('post', $view)))>=3?"ri-star-fill":"ri-star-line"?> yell"></i>
                                    <i class="<?=round(element('post_review_average', element('post', $view)))>=4?"ri-star-fill":"ri-star-line"?> yell"></i>
                                    <i class="<?=round(element('post_review_average', element('post', $view)))>=5?"ri-star-fill":"ri-star-line"?> yell"></i>
                                    <p class="rev-s"><span><?=round(element('post_review_average', element('post', $view)))?>  </span> / 5</p>
                                </div>

                                <div class="g-icon flexcenter">
                                    <p class="sm-icon" id="btn-post-like" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');"><span><?php echo number_format(element('post_like', element('post', $view))); ?></span></p>
                                    <p class="bad-icon" id="btn-post-dislike" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '2', 'post-dislike');"><span><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></p>
                                </div>
                            </div>
                        </div>
                        <div id="viewitemreview"></div>
                    </div>
                </div>
            </div>
            <ul class="flexcenter info-nav2 mt10">
                <li>상세정보</li>
                <li>리뷰</li>
                <li class="on">Q&A</li>
            </ul>

            <div class="info-in2 box-sd">
                <h3 class="info-tit flexcenter">Q&A<span></span></h3>
                <?php
                if ( ! element('post_hide_comment', element('post', $view))) {
                    $this->load->view(element('view_skin_path', $layout) . '/comment_write');
                    ?>
                    <ul class="qt-ul" id="viewcomment">

                    </ul>
                    <?php

                }
                ?>

            </div>
        </div>
    </div>
    <div class="modal " id="review-mo-t"><!--201027 수정-->
        <div class="modal-bg"></div>
        <div class="modalContent md">
            <header class="modalHd">
                <h3>리뷰작성</h3>
                <button class="modalClose"></button>
            </header>
            <div class="modalBody">
                <?php
                echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
                echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
                $attributes = array('class' => 'form-horizontal', 'name' => 'postReivewWrite', 'id' => 'postReivewWrite');
                echo form_open(my_base_url('cmall/post_review_write/'.element('post_id',element('post',$view))), $attributes);
                ?>
                <ul class="modal-ul">
                    <li class="flexcenter mo-star">
                        <p>별점등록</p>
                        <div class="star-i flexcenter">
                            <i class="ri-star-line yell"></i>
                            <i class="ri-star-line yell"></i>
                            <i class="ri-star-line yell"></i>
                            <i class="ri-star-line yell"></i>
                            <i class="ri-star-line yell"></i>
                            <p class="rev-s">0</p>
                        </div>
                        <input type="hidden" name="cre_score" value="">
                    </li>
                    <li class="mo-tit">
                        <input name="cre_title" id="cre_title" type="text" placeholder="제목">
                    </li>
                    <li class="mo-con">
                        <textarea id="cre_content" name="cre_content" cols="30" rows="10"></textarea>
                    </li>
                </ul>
                <div class="mo-btn-box">
<!--                    <button type="button" class="bor-g-btn mr10">취소</button>-->
                    <button type="button" class="bor-b-btn saveReview">저장</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="modal " id="qt-mo">
        <div class="modal-bg"></div>
        <div class="modalContent md">
            <header class="modalHd">
                <h3>질문하기</h3>
                <button class="modalClose"></button>
            </header>
            <div class="modalBody">
                <ul class="modal-ul">
                    <li></li>
                    <li class="mo-con">
                        <textarea name="" id="" cols="30" rows="10" placeholder="질문하기"></textarea>
                    </li>
                </ul>
                <div class="mo-btn-box">
                    <button type="button" class="bor-g-btn mr10">취소</button>
                    <button type="button" class="bor-b-btn">저장</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " id="qt-an">
        <div class="modal-bg"></div>
        <div class="modalContent md">
            <header class="modalHd">
                <h3>답변하기</h3>
                <button class="modalClose"></button>
            </header>
            <div class="modalBody">
                <ul class="modal-ul">
                    <li>Q. 질문내용입니다.</li>
                    <li class="mo-con">
                        <textarea name="" id="" cols="30" rows="10" placeholder="답변하기"></textarea>
                    </li>
                </ul>
                <div class="mo-btn-box">
                    <button type="button" class="bor-g-btn mr10">취소</button>
                    <button type="button" class="bor-b-btn">저장</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="review-mo"><!--201027 추가-->
        <div class="modal-bg"></div>
        <div class="modalContent md">
            <header class="modalHd">
                <h3>리뷰</h3>
                <button class="modalClose"></button>
            </header>
            <div class="modalBody">

                <ul class="modal-ul">
                    <li class="flexcenter mo-star flexwrap">
                        <p>아이디</p>
                        <div class="star-i flexcenter">
                            <i class="ri-star-fill yell"></i><p class="rev-s">5.0</p>
                        </div>
                    </li>
                    <li class="mo-tit flexwrap">
                        <span>리뷰제목</span>
                        <p class="tab2-date">등록일<span class="flexcenter">20.09.07</span></p>
                    </li>
                    <li class="mo-con ">
                        <p class="rv-con">리뷰내용</p>
                    </li>
                </ul>
                <div class="mo-btn-box">
                    <button type="button" class="bor-b-btn">확인</button>
                </div>

            </div>
        </div>
    </div><!--~-->


    <!--게시물상단 정보-->
	<ul class="information mb20 hidden">
		<li><?php echo element('display_name', element('post', $view)); ?></li>
		<li><i class="fa fa-comments"></i> <?php echo number_format(element('post_comment_count', element('post', $view))); ?></li>
		<li><i class="fa fa-eye"></i> <?php echo number_format(element('post_hit', element('post', $view))); ?></li>
		<?php if (element('use_post_like', element('board', $view))) { ?>
			<li><i class="fa fa-thumbs-up"></i> <span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span></li>
		<?php } ?>
		<?php	if (element('use_post_dislike', element('board', $view))) { ?>
			<li><i class="fa fa-thumbs-down"></i> <span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></li>
		<?php	} ?>
		<?php if (element('use_print', element('board', $view))) { ?>
			<li><a href="javascript:;" id="btn-print" onClick="post_print('<?php echo element('post_id', element('post', $view)); ?>', 'post-print');" title="이 글을 프린트하기"><i class="fa fa-print"></i> <span class="post-print">Print</span></a></li>
		<?php } ?>
		<li class="copy_post_url" data-clipboard-text="<?php echo element('short_url', $view); ?>"><span><i class="fa fa-link"></i> 글주소</span></li>
		<?php if (element('show_url_qrcode', element('board', $view))) { ?>
			<li class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('short_url', $view)); ?>"><i class="fa fa-qrcode"></i></li>
		<?php } ?>
		<li class="pull-right time"><i class="fa fa-clock-o"></i> <?php echo element('display_datetime', element('post', $view)); ?></li>
		<?php if (element('display_ip', element('post', $view))) { ?>
			<li class="pull-right time"><i class="fa fa-map-marker"></i> <?php echo element('display_ip', element('post', $view)); ?></li>
		<?php } ?>
		<?php if (element('is_mobile', element('post', $view))) { ?>
			<li class="pull-right time"><i class="fa fa-wifi"></i></li>
		<?php } ?>
	</ul>
    <!--파일다운로드 카운트-->
	<?php if (element('link_count', $view) > 0 OR element('file_download_count', $view) > 0) { ?>
		<div class="table-box">
			<table class="table-body">
				<tbody>
				<?php
				if (element('file_download_count', $view) > 0) {
					foreach (element('file_download', $view) as $key => $value) {
				?>
					<tr>
						<td><i class="fa fa-download"></i> <a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo byte_format(element('pfi_filesize', $value)); ?>)</a> <span class="time"><i class="fa fa-clock-o"></i> <?php echo display_datetime(element('pfi_datetime', $value), 'full'); ?></span><span class="badge"><?php echo number_format(element('pfi_download', $value)); ?></span></td>
					</tr>
				<?php
					}
				}
				if (element('link_count', $view) > 0) {
					foreach (element('link', $view) as $key => $value) {
				?>
					<tr>
						<td><i class="fa fa-link"></i> <a href="<?php echo element('link_link', $value); ?>" target="_blank"><?php echo html_escape(element('pln_url', $value)); ?></a><span class="badge"><?php echo number_format(element('pln_hit', $value)); ?></span>
							<?php if (element('show_url_qrcode', element('board', $view))) { ?>
								<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $value)); ?>"><i class="fa fa-qrcode"></i></span>
							<?php } ?>
						</td>
					</tr>
				<?php
					}
				}
				?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<script type="text/javascript">
	//<![CDATA[
	function file_download(link) {
		<?php if (element('point_filedownload', element('board', $view)) < 0) { ?>if ( ! confirm("파일을 다운로드 하시면 포인트가 차감(<?php echo number_format(element('point_filedownload', element('board', $view))); ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?")) { return; }<?php }?>
		document.location.href = link;
	}
	//]]>
	</script>



	<?php
	if (element('poll', $view)) {
		$poll = element('poll', $view);
		$poll_item = element('poll_item', $view);
	?>
		<div class="poll mb30 mt20">
			<div class="headline">
				<h5>[설문조사] <?php echo html_escape(element('ppo_title', $poll)); ?></h5>
			</div>
			<?php
			if (element('attended', $poll) OR element('ended_poll', $poll)) {
				if ($poll_item) {
					$i = 1;
					foreach ($poll_item as $pkey => $pval) {
			?>
				<div class="poll-result"><?php echo $i;?>. <?php echo html_escape(element('ppi_item', $pval)); ?> <div class="pull-right"><?php echo number_format(element('ppi_count', $pval)); ?>표, <?php echo element('s_rate', $pval); ?>%</div></div>
				<div class="progress" style="height:5px;">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo element('s_rate', $pval); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo element('bar', $pval); ?>%;">
						<span class="sr-only"><?php echo element('s_rate', $pval); ?>% Complete</span>
					</div>
				</div>
			<?php
					$i++;
					}
				}
			} else {
			?>
				<div id="poll_write_form">
					<?php
					$attributes = array('name' => 'fpostpoll', 'id' => 'fpostpoll');
					echo form_open('', $attributes);
						if ($poll_item) {
							foreach ($poll_item as $pkey => $pval) {
					?>
							<div class="checkbox">
								<label for="ppi_item_<?php echo html_escape(element('ppi_id', $pval)); ?>">
									<input type="checkbox" name="ppi_item[]" class="poll_item_chk" id="ppi_item_<?php echo html_escape(element('ppi_id', $pval)); ?>" value="<?php echo html_escape(element('ppi_id', $pval)); ?>" />
									<?php echo html_escape(element('ppi_item', $pval)); ?>
								</label>
							</div>
						<?php
							}
						}
						?>
						<div class="form-group mt10">
							<button type="button" class="btn btn-default btn-xs" onClick="post_poll('<?php echo element('post_id', element('post', $view)); ?>', '<?php echo element('ppo_id', element('poll', $view)); ?>');">투표하기</button>
							<button type="button" class="btn btn-default btn-xs" onClick="post_poll_result('<?php echo element('post_id', element('post', $view)); ?>', '<?php echo element('ppo_id', element('poll', $view)); ?>');">결과보기</button>
							<span class="help-block">답변 <?php echo element('ppo_choose_count', $poll); ?> 개 선택 가능, 현재 <?php echo element('ppo_count', $poll); ?>명이 참여함, 설문기간 : <?php echo html_escape(element('poll_period', $poll)); ?>
								<?php if (element('ppo_point', $poll)) { echo '참여시' . number_format(element('ppo_point', $poll)) . '포인트 지급'; } ?>
							</span>
						</div>
					<?php echo form_close(); ?>
				</div>
			<?php } ?>
			<div id="poll_result_ajax"></div>

			<script type="text/javascript">
			//<![CDATA[
			var chklimit = <?php echo element('ppo_choose_count', $poll); ?>;
			$('input.poll_item_chk').on('change', function(evt) {
			if ($('input.poll_item_chk:checked').length > chklimit) {
				this.checked = false;
				alert('답변은 ' + chklimit + '개까지만 선택이 가능합니다.');
			}
			});
			function post_poll(post_id, ppo_id) {
				var href;
				href = cb_url + '/poll/post_poll/' + post_id + '/' + ppo_id;
				var $that = $(this);
				$.ajax({
					url : href,
					type : 'post',
					data : $('#fpostpoll').serialize() + '&csrf_test_name=' + cb_csrf_hash,
					dataType : 'json',
					success : function(data) {
						if (data.error) {
							alert(data.error);
							return false;
						} else if (data.success) {
							post_poll_result(post_id, ppo_id);
							$('#poll_write_form').hide();

						}

					}
				});
			}

			function post_poll_result(post_id, ppo_id) {
				var href;
				var result = '';
				href = cb_url + '/poll/post_poll_result/' + post_id + "/" + ppo_id;
				var $that = $(this);
				$.ajax({
					url : href,
					type : 'post',
					data : {csrf_test_name : cb_csrf_hash},
					dataType : 'json',
					success : function(data) {
						if (data.error) {
							alert(data.error);
							return false;
						} else if (data.success) {
							var i = 1;
							for (var key in data.poll_item) {
								obj = data.poll_item[key];
								result += '<div class="poll-result">' + i + '. ' + obj.ppi_item + '<div class="pull-right">' + obj.ppi_count + '표, ' + obj.s_rate + '%</div></div><div class="progress" style="height:5px;"><div class="progress-bar" role="progressbar" aria-valuenow="' + obj.s_rate + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + obj.bar + '%;"></div></div>';
								i++;
							}
							$('#poll_result_ajax').html(result);
						}

					}
				});
			}
			//]]>
			</script>
		</div>
	<?php } ?>
    <!--게시물관리-->
	<div class="pull-right mt20 mb20 hidden">
		<?php if ( ! element('post_del', element('post', $view)) && element('use_scrap', element('board', $view))) { ?>
			<button type="button" class="btn btn-black" id="btn-scrap" onClick="post_scrap('<?php echo element('post_id', element('post', $view)); ?>', 'post-scrap');">스크랩 <span class="post-scrap"><?php echo element('scrap_count', element('post', $view)) ? '+' . number_format(element('scrap_count', element('post', $view))) : ''; ?></span></button>
		<?php } ?>
		<?php if ( ! element('post_del', element('post', $view)) && element('use_blame', element('board', $view)) && ( ! element('blame_blind_count', element('board', $view)) OR element('post_blame', element('post', $view)) < element('blame_blind_count', element('board', $view)))) { ?>
			<button type="button" class="btn btn-black" id="btn-blame" onClick="post_blame('<?php echo element('post_id', element('post', $view)); ?>', 'post-blame');">신고 <span class="post-blame"><?php echo element('post_blame', element('post', $view)) ? '+' . number_format(element('post_blame', element('post', $view))) : ''; ?></span></button>
		<?php } ?>

		<?php if ( ! element('post_del', element('post', $view)) && element('is_admin', $view)) { ?>
			<button type="button" class="btn btn-default btn-sm admin-manage-post"><i class="fa fa-cog big-fa"></i>관리</button>
			<div class="btn-admin-manage-layer admin-manage-post-layer">
				<?php if (element('is_admin', $view) === 'super') { ?>
					<div class="item" onClick="post_copy('copy', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-files-o"></i> 복사하기</div>
					<div class="item" onClick="post_copy('move', '<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-arrow-right"></i> 이동하기</div>
					<?php if (element('use_category', element('board', $view))) { ?>
						<div class="item" onClick="post_change_category('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-tags"></i> 카테고리변경</div>
				<?php
					}
				}
				if (element('use_post_secret', element('board', $view))) {
					if (element('post_secret', element('post', $view))) {
				?>
					<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-unlock"></i> 비밀글해제</div>
				<?php } else { ?>
					<div class="item" onClick="post_action('post_secret', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-lock"></i> 비밀글로</div>
				<?php
					}
				}
				if (element('post_hide_comment', element('post', $view))) {
				?>
					<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-comments"></i> 댓글감춤해제</div>
				<?php } else { ?>
					<div class="item" onClick="post_action('post_hide_comment', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-comments"></i> 댓글감춤</div>
				<?php } ?>
				<?php if (element('post_notice', element('post', $view))) { ?>
					<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-bullhorn"></i> 공지내림</div>
				<?php } else { ?>
					<div class="item" onClick="post_action('post_notice', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-bullhorn"></i> 공지올림</div>
				<?php } ?>
				<?php if (element('post_blame', element('post', $view)) >= element('blame_blind_count', element('board', $view))) { ?>
					<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '0');"><i class="fa fa-exclamation-circle"></i> 블라인드해제</div>
				<?php } else { ?>
					<div class="item" onClick="post_action('post_blame_blind', '<?php echo element('post_id', element('post', $view)); ?>', '1');"><i class="fa fa-exclamation-circle"></i> 블라인드처리</div>
				<?php } ?>
				<?php if (element('use_posthistory', element('board', $view))) { ?>
					<div class="item" onClick="post_history('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-history"></i> 글변경로그</div>
				<?php } ?>
				<?php if (element('use_download_log', element('board', $view))) { ?>
					<div class="item" onClick="download_log('<?php echo element('post_id', element('post', $view)); ?>');" ><i class="fa fa-download"></i> 다운로드로그</div>
				<?php } ?>
				<?php	if (element('use_link_click_log', element('board', $view))) { ?>
					<div class="item" onClick="link_click_log('<?php echo element('post_id', element('post', $view)); ?>');"><i class="fa fa-link"></i> 링크클릭로그</div>
				<?php } ?>
				<div class="item" onClick="post_action('post_trash', '<?php echo element('post_id', element('post', $view)); ?>', '', '이 글을 휴지통으로 이동하시겠습니까?');"><i class="fa fa-trash"></i> 휴지통으로</div>
			</div>
		<?php } ?>
	</div>
    <!--sns버튼-->
	<?php
	if (element('use_sns_button', $view)) {
		$this->managelayout->add_js(base_url('assets/js/sns.js'));

		if ($this->cbconfig->item('kakao_apikey')) {
			$this->managelayout->add_js('https://developers.kakao.com/sdk/js/kakao.min.js');
	?>
		<script type="text/javascript">Kakao.init('<?php echo $this->cbconfig->item('kakao_apikey'); ?>');</script>
		<?php } ?>
		<div class="sns_button">
			<a href="javascript:;" onClick="sendSns('facebook', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 페이스북으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_facebook.png" width="22" height="22" alt="이 글을 페이스북으로 퍼가기" title="이 글을 페이스북으로 퍼가기" /></a>
			<a href="javascript:;" onClick="sendSns('twitter', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 트위터로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_twitter.png" width="22" height="22" alt="이 글을 트위터로 퍼가기" title="이 글을 트위터로 퍼가기" /></a>
			<?php if ($this->cbconfig->item('kakao_apikey')) { ?>
				<a href="javascript:;" onClick="kakaolink_send('<?php echo html_escape(element('post_title', element('post', $view)));?>', '<?php echo element('short_url', $view); ?>');" title="이 글을 카카오톡으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaotalk.png" width="22" height="22" alt="이 글을 카카오톡으로 퍼가기" title="이 글을 카카오톡으로 퍼가기" /></a>
			<?php } ?>
			<a href="javascript:;" onClick="sendSns('kakaostory', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 카카오스토리로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaostory.png" width="22" height="22" alt="이 글을 카카오스토리로 퍼가기" title="이 글을 카카오스토리로 퍼가기" /></a>
			<a href="javascript:;" onClick="sendSns('band', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 밴드로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_band.png" width="22" height="22" alt="이 글을 밴드로 퍼가기" title="이 글을 밴드로 퍼가기" /></a>
		</div>
	<?php } ?>

	<div class="clearfix"></div>



    <div class="content1">
        <div class="btn-group pull-left" role="group" aria-label="...">
            <?php if (element('modify_url', $view)) { ?>
                <a href="<?php echo element('modify_url', $view); ?>" class="btn btn-default btn-sm">수정</a>
            <?php } ?>
            <?php	if (element('delete_url', $view)) { ?>
                <button type="button" class="btn btn-default btn-sm btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>">삭제</button>
            <?php } ?>
            <a href="<?php echo element('list_url', $view); ?>" class="btn btn-default btn-sm">목록</a>
            <?php if (element('search_list_url', $view)) { ?>
                <a href="<?php echo element('search_list_url', $view); ?>" class="btn btn-default btn-sm">검색목록</a>
            <?php } ?>
            <?php if (element('reply_url', $view)) { ?>
                <a href="<?php echo element('reply_url', $view); ?>" class="btn btn-default btn-sm">답변</a>
            <?php } ?>
            <?php if (element('prev_post', $view)) { ?>
                <a href="<?php echo element('url', element('prev_post', $view)); ?>" class="btn btn-default btn-sm">이전글</a>
            <?php } ?>
            <?php if (element('next_post', $view)) { ?>
                <a href="<?php echo element('url', element('next_post', $view)); ?>" class="btn btn-default btn-sm">다음글</a>
            <?php } ?>
        </div>
        <?php if (element('write_url', $view)) { ?>
            <div class="pull-right">
                <a href="<?php echo element('write_url', $view); ?>" class="btn btn-success btn-sm">글쓰기</a>
            </div>
        <?php } ?>
    </div>



<?php echo element('footercontent', element('board', $view)); ?>

<?php if (element('target_blank', element('board', $view))) { ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	$("#post-content a[href^='http']").attr('target', '_blank');
});
//]]>
</script>
<?php } ?>

<script type="text/javascript">
//<![CDATA[
var client = new ZeroClipboard($('.copy_post_url'));
client.on('ready', function(readyEvent) {
	client.on('aftercopy', function(event) {
		alert('게시글 주소가 복사되었습니다. \'Ctrl+V\'를 눌러 붙여넣기 해주세요.');
	});
});
//]]>
</script>
<?php
if (element('highlight_keyword', $view)) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js'));
?>
	<script type="text/javascript">
	//<![CDATA[
	$('#post-content').highlight([<?php echo element('highlight_keyword', $view);?>]);
	//]]>
	</script>
<?php } ?>

<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5324d894ca2340475b80170b942a832f&libraries=services"></script>
<script>
    //평점 평균
    var average = '<?=round(element('post_review_average', element('post', $view)))?>';

    $(document).ready(function () {
        view_post_review('viewitemreview', '<?php echo element('post_id', element('post', $view)); ?>', '', '','',average);
    })
    function view_post_review(id, cit_id, page, opt, message,average) {
        if (opt) {
            $('html, body').animate({
                scrollTop: $('#' + id).offset().top - 100
            }, 0);
        }

        var cmall_review_url = cb_url + '/board_post/review_list/' + cit_id + '?average='+average+'&page=' + page;
        var hash = window.location.hash;

        $('#' + id).load(cmall_review_url, function() {
            if (message) {
                $('.alert-cmall-review-list-message-content').html(message);
                $('.alert-cmall-review-list-message').addClass('alert-success').removeClass('alert-warning').show();
            }
            if (hash) {
                var st = $(hash).offset().top;
                $('html, body').animate({ scrollTop: st }, 200); //200ms duration
            }
            if (typeof(SyntaxHighlighter) !== 'undefined') {
                SyntaxHighlighter.highlight();
            }
        });
    }
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(37.537187, 127.005476),
        map: map
    });
    // 주소로 상세 정보를 검색
    var address = '<?=$view["extra_content"][7]["output"]?>';
    var setLatLng;
    geocoder.addressSearch(address, function(results, status) {
        // 정상적으로 검색이 완료됐으면
        if (status === daum.maps.services.Status.OK) {

            var result = results[0]; //첫번째 결과의 값을 활용
            //클릭이벤트에서 사용할수있게 전달
            setLatLng =  result;
            // 해당 주소에 대한 좌표를 받아서
            var coords = new daum.maps.LatLng(result.y, result.x);
            // 지도를 보여준다.
            mapContainer.style.display = "block";
            map.relayout();
            // 지도 중심을 변경한다.
            map.setCenter(coords);
            // 마커를 결과값으로 받은 위치로 옮긴다.
            marker.setPosition(coords)
        }
    });
    //지도 이동 이벤트 핸들러
    function moveKakaoMap(){

        var center = map.getCenter(),
            lat = center.getLat(),
            lng = center.getLng();

        location.href = 'https://map.kakao.com/link/map/' + encodeURIComponent('<?=$view["extra_content"][7]["output"]?>') + ',' + lat + ',' + lng; //Kakao 지도로 보내는 링크
    }
    //주소를 클릭보드에 복사
    $('.add-btn').click(function () {
        const textArea = document.createElement('textarea');
        textArea.textContent = $('.selectAddress').text();
        document.body.append(textArea);
        textArea.select();
        document.execCommand("copy");
        textArea.remove();
    })
    //리뷰 전송
    $('.saveReview').click(function () {
        // $('#postReivewWrite').submit()
        var formData = new FormData(document.getElementById('postReivewWrite'));
        formData.append("csrf_test_name", cb_csrf_hash)
        var url = '<?=my_base_url('cmall/post_review_write/'.element('post_id',element('post',$view)))?>';
        $.ajax({
            data : formData,
            type : "POST",
            // enctype: 'multipart/form-data',
            url : url,
            contentType : false,
            processData : false,
            success : function(data) {
                if(data.view.errors){
                    $.each(data.view.errors,function (key,value) {
                        $('#review-mo-t .modalBody').append('<div class="alert alert-warning" role="alert">'+value+'</div>')
                    })
                }else{
                    $('#review-mo-t').removeClass('on');
                    $('.info-sub-con').children().append('<div class="alert alert-success" role="alert">리뷰작성 완료</div>')
                    setTimeout(function() {
                        $('.alert-success').remove();
                    }, 1000);
                }
            }
        });
    })
    //별점
    $('.star-i i').click(function(){
        /* 별점의 on 클래스 전부 제거 */
        $(this).parent().children("i").removeClass("ri-star-fill");
        $(this).parent().children("i").addClass("ri-star-line");
        /* 클릭한 별과, 그 앞 까지 별점에 on 클래스 추가 */
        $(this).addClass("ri-star-fill").prevAll("i").addClass("ri-star-fill");
        $(this).removeClass("ri-star-line").prevAll("i").removeClass("ri-star-line");
        var score = $(this).siblings('.ri-star-fill').length + 1;
        $('.rev-s').html(score)
        $('input[name=cre_score').val(score)
        return false;
    });
    //평점평균


</script>
