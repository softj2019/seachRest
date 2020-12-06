<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<div class="content1">


    <h3 class="hidden"><?php echo ($this->input->get('skeyword')) ? '검색결과 : ' . html_escape($this->input->get('skeyword')) : '검색페이지' ?></h3>
    <div class="row hidden">
        <form action="<?php echo current_url(); ?>" onSubmit="return checkSearch(this);" class=" search_box text-center">
            <div class="group hidden">
                <select class="input" name="group_id">
                    <option value="">전체그룹</option>
                    <?php
                    if (element('grouplist', $view)) {
                        foreach (element('grouplist', $view) as $key => $value) {
                    ?>
                        <option value="<?php echo element('bgr_id', $value); ?>" <?php echo element('bgr_id', $value) === $this->input->get('group_id') ? 'selected="selected"' : ''; ?>><?php echo element('bgr_name', $value); ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="group">
                <select class="input per100" name="sfield">
                    <option value="post_both" <?php echo $this->input->get('sfield') === 'post_both' ? 'selected="selected"' : ''; ?>>제목+내용</option>
                    <option value="post_title" <?php echo $this->input->get('sfield') === 'post_title' ? 'selected="selected"' : ''; ?>>제목</option>
                    <option value="post_content" <?php echo $this->input->get('sfield') === 'post_content' ? 'selected="selected"' : ''; ?>>내용</option>
                    <option value="post_userid" <?php echo $this->input->get('sfield') === 'post_userid' ? 'selected="selected"' : ''; ?>>회원아이디</option>
                    <option value="post_nickname" <?php echo $this->input->get('sfield') === 'post_nickname' ? 'selected="selected"' : ''; ?>>회원닉네임</option>
                </select>
            </div>
            <div class="group">
                <input type="text" class="input per100" name="skeyword" placeholder="검색어" value="<?php echo html_escape($this->input->get('skeyword')); ?>" />
            </div>
            <div class="group">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> 검색</button>
            </div>
            <div class="group">
                <select class="input" name="sop">
                    <option value="OR" <?php echo strtoupper($this->input->get('sop')) !== 'AND' ? 'selected="selected"' : ''; ?>>OR</option>
                    <option value="AND" <?php echo strtoupper($this->input->get('sop')) === 'AND' ? 'selected="selected"' : ''; ?>>AND</option>
                </select>
            </div>
        </form>
    </div>
    <ul class="nav nav-tabs mt20 hidden">
    <?php
    if (element('board_rows', $view)) {
    ?>
        <li role="presentation" <?php echo ( ! $this->input->get('board_id')) ? 'class="active"' : ''; ?>><a href="<?php echo element('tab_url', $view); ?>">전체게시판 (<?php echo number_format( array_sum(element('board_rows', $view))); ?>)</a></li>
    <?php
        foreach (element('board_rows', $view) as $key => $value) {
    ?>
            <li role="presentation" <?php echo ($this->input->get('board_id') === $key) ? 'class="active"' : ''; ?>><a href="<?php echo element('tab_url', $view) . '&amp;board_id=' . $key; ?>"><?php echo html_escape(element('brd_name', element($key, element('boardlist', $view)))); ?> (<?php echo $value; ?>)</a></li>
    <?php
        }
    }
    ?>
    </ul>
    <ul class="tab-ul2 clearfix">
        <?php

        if (element('list', element('data', $view))) {
            foreach (element('list', element('data', $view)) as $result) {
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

                            <img src="<?php echo  thumb_url('post', element('pfi_filename', element('images', $result)), 0, 0); ?>" alt="<?php echo html_escape(element('title', $result)); ?>" title="<?php echo html_escape(element('title', $result)); ?>" class=" " />
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
<?php if (!element('list', element('data', $view))) {?>
    검색 결과가 없습니다
<?php
}
?>
    <div class="media-box mt20 hidden" id="searchresult">
<?php
if (element('list', element('data', $view))) {
	foreach (element('list', element('data', $view)) as $result) {
?>
	<div class="media">
<?php
		if (element('images', $result)) {
?>
		<div class="media-left">
			<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>">
				<img class="media-object" src="<?php echo thumb_url('post', element('pfi_filename', element('images', $result)), 100, 80); ?>" alt="<?php echo html_escape(element('post_title', $result)); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>" style="width:100px;height:80px;" />
			</a>
		</div>
<?php
		}
?>
		<div class="media-body">
			<h4 class="media-heading"><a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('post_title', $result)); ?>"><?php echo html_escape(element('post_title', $result)); ?></a>
				<?php if (element('post_comment_count', $result)) { ?><span class="label label-info label-xs"><?php echo element('post_comment_count', $result); ?> comments</span><?php } ?>
				<a href="<?php echo element('post_url', $result); ?>" target="_blank" title="<?php echo html_escape(element('post_title', $result)); ?>"><span class="label label-default label-xs">새창</span></a>
			</h4>
			<p><?php echo element('content', $result); ?></p>
			<p class="media-info">
				<span><?php echo element('display_name', $result); ?></span>
				<span><i class="fa fa-clock-o"></i> <?php echo element('display_datetime', $result); ?></span>
			</p>
		</div>
	</div>
<?php
	}
}
if ( ! element('list', element('data', $view))) {
?>
	<div class="media">
		<div class="media-body nopost">
			검색 결과가 없습니다
		</div>
	</div>
<?php
}
?>
</div>
    <nav><?php echo element('paging', $view); ?></nav>
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
<script type="text/javascript">
//<![CDATA[
function checkSearch(f) {
	var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
	if (skeyword.length < 2) {
		alert('2글자 이상으로 검색해 주세요');
		f.skeyword.focus();
		return false;
	}
	return true;
}
//]]>
</script>
<?php if (element('highlight_keyword', $view)) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js')); ?>
<script type="text/javascript">
//<![CDATA[
$('#searchresult').highlight([<?php echo element('highlight_keyword', $view);?>]);
//]]>
</script>
<?php } ?>
