<?php //$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<?php echo element('headercontent', element('board', element('list', $view))); ?>

    <div class="content1">

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


        <div class="tab-box hidden">
            <ul>
                <li data-id="tab1" class="on">의사<span>(00)</span></li>
                <li data-id="tab2">리뷰<span>(00)</span></li>
            </ul>
        </div>
        <div class="content-in">
            <?php
            $attributes = array('name' => 'fboardlist', 'id' => 'fboardlist');
            echo form_open('', $attributes);
            ?>

            <div class="tab-con on" id="tab1">
                <ul class="tab-ul">
                    <li><button type="button" class="on">전체</button></li>
                    <?php if ( ! element('access_list', element('board', element('list', $view))) && element('use_rss_feed', element('board', element('list', $view)))) { ?>
                        <li><a href="<?php echo rss_url(element('brd_key', element('board', element('list', $view)))); ?>" class="btn btn-default btn-sm" title="<?php echo html_escape(element('board_name', element('board', element('list', $view)))); ?> RSS 보기"><i class="fa fa-rss"></i></a></li>
                    <?php } ?>
                    <li>
                        <select class="input" onchange="location.href='<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape($this->input->get('categroy_id')); ?>&amp;findex=' + this.value;">
                            <option value="">정렬하기</option>
                            <option value="post_datetime desc" <?php echo $this->input->get('findex') === 'post_datetime desc' ? 'selected="selected"' : '';?>>날짜순</option>
                            <option value="post_hit desc" <?php echo $this->input->get('findex') === 'post_hit desc' ? 'selected="selected"' : '';?>>조회수</option>
                            <option value="post_comment_count desc" <?php echo $this->input->get('findex') === 'post_comment_count desc' ? 'selected="selected"' : '';?>>댓글수</option>
                            <?php if (element('use_post_like', element('board', element('list', $view)))) { ?>
                                <option value="post_like desc" <?php echo $this->input->get('findex') === 'post_like desc' ? 'selected="selected"' : '';?>>추천순</option>
                            <?php } ?>
                        </select>
                    </li>
                    <?php if (element('use_category', element('board', element('list', $view))) && ! element('cat_display_style', element('board', element('list', $view)))) { ?>
                        <li>
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
                        </li>
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
                </ul>
                <?php if (element('is_admin', $view)) { ?>
                    <div>
                        <input id="all_boardlist_check" onclick="if (this.checked) all_boardlist_checked(true); else all_boardlist_checked(false);" type="checkbox" />
                        <label for="all_boardlist_check" class="check-b"> 전체선택</label>
                    </div>
                <?php } ?>



                <div class="new-dt mt20 tab-ul2"><!--201030 수정~-->
                    <h2 class="ml20">새로운 소식</h2>
                    <ul class="tab-ul2 clearfix">
                    <?php

                    if (element('list', element('data', element('list', $view)))) {
                        foreach (element('list', element('data', element('list', $view))) as $result) {
                    ?>
                        <li>
                            <?php if (element('is_admin', $view)) { ?><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" id="chkItem_<?php echo element('post_id', $result); ?>"/><label for="chkItem_<?php echo element('post_id', $result); ?>" class="check-b">&nbsp;</label><?php } ?>
                            <!--게시물번호-->
                            <span class="label label-default hidden"><?php echo element('num', $result); ?></span>
                            <?php if (element('is_mobile', $result)) { ?><span class="fa fa-wifi"></span><?php } ?>
                            <!--카테고리표기-->
                            <?php if (element('category', $result)) { ?><a class="hidden" href="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>?category_id=<?php echo html_escape(element('bca_key', element('category', $result))); ?>"><span class="label label-default"><?php echo html_escape(element('bca_value', element('category', $result))); ?></span></a><?php } ?>
                            <?php if (element('ppo_id', $result)) { ?><i class="fa fa-bar-chart"></i><?php } ?>
                            <!--이미지썸네일-->
                            <a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>">
                                <div class="tab-img">
                                    <img src="<?php echo element('thumb_url', $result); ?>" alt="<?php echo html_escape(element('title', $result)); ?>" title="<?php echo html_escape(element('title', $result)); ?>" class="" />
                                </div>
                                <ul class="ul2-ul">
                                    <li><a href=""><?php echo element('store_name',element('extravars', $result)); ?></a></li>
                                    <li class="ul2-name"><h3><?php echo element('doctor_name',element('extravars', $result)); ?></h3><span><?php echo element('job_title',element('extravars', $result)); ?></span></li>
                                    <li>
                                        <div class="star-i flexcenter">
                                            <i class="<?=round(element('post_review_average', $result))>=1?"ri-star-fill":"ri-star-line"?> yell"></i>
                                            <i class="<?=round(element('post_review_average', $result))>=2?"ri-star-fill":"ri-star-line"?> yell"></i>
                                            <i class="<?=round(element('post_review_average', $result))>=3?"ri-star-fill":"ri-star-line"?> yell"></i>
                                            <i class="<?=round(element('post_review_average', $result))>=4?"ri-star-fill":"ri-star-line"?> yell"></i>
                                            <i class="<?=round(element('post_review_average', $result))>=5?"ri-star-fill":"ri-star-line"?> yell"></i>
                                            <p class="rev-s"><?php echo round(element('post_review_average', $result)); ?> <span>(리뷰 <?php echo element('post_review_count', $result); ?>)</span></p>
                                        </div>
                                    </li>
<!--                                    <li class="ul2-time">-->
<!--                                        <span class="sub-time-t">진료중</span><span>18 : 00 종료</span>-->
<!--                                    </li>-->
                                    <li class="lot-li">
                                        <i></i><span class="resultDistance">주엽역 220m</span>
                                        <input type="hidden" name="address[]" class="addressData" value="<?php echo element('address',element('extravars', $result)); ?>">
                                    </li>
                                </ul>
                            </a>
                            <!--답글-->
                            <p class="hidden">
                                <?php if (element('post_reply', $result)) { ?><span class="label label-primary">Re</span><?php } ?>
                                <a href="<?php echo element('post_url', $result); ?>" style="
                                <?php
                                if (element('title_color', $result)) {
                                    echo 'color:' . element('title_color', $result) . ';';
                                }
                                if (element('title_font', $result)) {
                                    echo 'font-family:' . element('title_font', $result) . ';';
                                }
                                if (element('title_bold', $result)) {
                                    echo 'font-weight:bold;';
                                }
                                if (element('post_id', element('post', $view)) === element('post_id', $result)) {
                                    echo 'font-weight:bold;';
                                }
                                ?>
                                        " title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a>
                            </p>
                            <p class="hidden">
                                <?php echo element('display_name', $result); ?>
                                <?php //echo element('display_datetime', $result); ?>
                                <?php if (element('is_hot', $result)) { ?><span class="label label-danger">Hot</span><?php } ?>
                                <?php if (element('is_new', $result)) { ?><span class="label label-warning">New</span><?php } ?>
                                <?php if (element('post_secret', $result)) { ?><span class="fa fa-lock"></span><?php } ?>
                                <?php if (element('post_comment_count', $result)) { ?><span class="comment-count"><i class="fa fa-comments"></i><?php echo element('post_comment_count', $result); ?></span><?php } ?>
                                <span class="hit-count"><i class="fa fa-eye"></i> <?php echo number_format(element('post_hit', $result)); ?></span>
                            </p>
                        </li>



                <?php
                    }
                }
                ?>
                </ul>
                </div>
            </div>
            <div class="tab-con pb20 clearfix hidden" id="tab2">
                <p class="g-txt">등록된 리뷰가 없습니다.</p>
                <ul class="tab2-ul  clearfix"><!--201027 수정-->
                    <li>
                        <div class="tab2-tit flexwrap">
                            <p><a href="">사과나무치과</a> </p>
                            <div class="star-i flexcenter">
                                <i class="ri-star-fill yell"></i><p class="rev-s">5.0</p>
                            </div>
                        </div>
                        <div class="tab2-name flexwrap">
                            <p><a href="">고양이 집사</a></p>
                            <p class="tab2-date">등록일<span class="flexcenter">20.09.07</span></p>
                        </div>
                        <div class="tab2-re review-btn">
                            <span>[교정]</span>
                            <p>리뷰 부분입니다.리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 더보기리뷰리뷰리뷰 부분입니다</p>
                        </div>
                    </li>

                </ul><!--~-->

            </div>
            <?php echo form_close(); ?>
            <?php echo element('paging', element('list', $view)); ?>
        </div>

        <div class="border_button hidden">
            <div class="pull-left mr10">
<!--                <a href="--><?php //echo element('list_url', element('list', $view)); ?><!--" class="btn btn-default btn-sm">목록</a>-->
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
            <?php if (element('write_url', element('list', $view))) { ?>
                <div class="pull-right">
                    <a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm">글쓰기</a>
                </div>
            <?php } ?>
        </div>

    </div>
<div class="hidden" id="map"></div>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5324d894ca2340475b80170b942a832f&libraries=services"></script>
<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    /* myLocation.js */



    window.onload = getMyLocation;

    function getMyLocation() {

        // navigator.geolocation 없다면 null을 반환하고 조건식의 결과는 false
        if (navigator.geolocation) {

            //getCurrentPosition(successhandler, errorHandler, option)
            navigator.geolocation.getCurrentPosition(
                displayLocation,
                displayError);
        } else {
            alert("내 위치 정보제공 설정이 꺼져있거나, 지원하지 않는 브라우져 입니다." );
        }
    }

    function displayLocation(position) {
        //화면에 출력된 모든 병원의 주소를 가져와 거리를 구한다
        $('.addressData').each(function (key) {
            getGeoAddressPosition(key,$(this).val(),position)
        });

    }
    function getGeoAddressPosition(key,address,position) {
        // 주소로 상세 정보를 검색
        geocoder.addressSearch(address, function(results, status) {
            // 정상적으로 검색이 완료됐으면
            if (status === daum.maps.services.Status.OK) {
                var result = results[0]; //첫번째 결과의 값을 활용
                var ourCoords = { //서울 시청 좌표
                    latitude : result.y,  //위도
                    longitude : result.x  //경도
                };
                var distance = computeDistance(position.coords, ourCoords);
                console.log(result.y,key,address,distance.toFixed(1)+"km")
                $(".resultDistance").eq(key).html(distance.toFixed(1)+"km")
            }
        });

    }
    function displayError(error) {
        var errorTypes = {
            0: "알려지지 않은 에러",
            1: "사용자가 권한 거부",
            2: "위치를 찾을 수 없음",
            3: "요청 응답 시간 초과"
        };
        var errorMessage = errorTypes[error.code];
        if (error.code == 0 || error.code == 2) {
            errorMessage = errorMessage + " " + error.message;
        }
        $("#location").html(errorMessage);
    }


    // 구면 코사인 법칙(Spherical Law of Cosine) 으로 두 위도/경도 지점의 거리를 구함
    // 반환 거리 단위 (km)
    function computeDistance(startCoords, destCoords) {
        var startLatRads = degreesToRadians(startCoords.latitude);
        var startLongRads = degreesToRadians(startCoords.longitude);
        var destLatRads = degreesToRadians(destCoords.latitude);
        var destLongRads = degreesToRadians(destCoords.longitude);

        var Radius = 6371; //지구의 반경(km)
        var distance = Math.acos(Math.sin(startLatRads) * Math.sin(destLatRads) +
            Math.cos(startLatRads) * Math.cos(destLatRads) *
            Math.cos(startLongRads - destLongRads)) * Radius;

        return distance;
    }

    function degreesToRadians(degrees) {
        radians = (degrees * Math.PI)/180;
        return radians;
    }
</script>
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

