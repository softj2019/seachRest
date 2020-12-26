<?php
//$k = 0;
//$is_open = false;
//if (element('board_list', $view)) {
//	foreach (element('board_list', $view) as $key => $board) {
//		$config = array(
//			'skin' => 'basic',
//			'brd_key' => element('brd_key', $board),
//			'limit' => 5,
//			'length' => 40,
//			'is_gallery' => '',
//			'image_width' => '',
//			'image_height' => '',
//			'cache_minute' => 1,
//		);
//		if ($k % 2 === 0) {
//			echo '<div>';
//			$is_open = true;
//		}
//		echo $this->board->latest($config);
//		if ($k % 2 === 1) {
//			echo '</div>';
//			$is_open = false;
//		}
//		$k++;
//	}
//}
//if ($is_open) {
//	echo '</div>';
//	$is_open = false;
//}
?>
<form class="navbar-form navbar-right pull-right hidden" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
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
<div class="content">
    <div class="scroll-b">
        <button type="button" class="scroll-t"></button>
        <button type="button" class="scroll-d"></button>
    </div>
    <div class="main-slider">
        <div class="m-slider slick">
            <?php echo banner_doctormoa($position = 'main_top', $type = 'rand', $limit = 3, $start_tag = '<div>', $end_tag = '</div>') ?>

        </div>

    </div>
    <div class="sub-src clearfix">
        <form action="" class="sub-src-form flexwrap">

            <select name="sido" id="sido">
                <option value="">시도</option>
                <?php

                $sido=$this->Post_extra_vars_model->get_all_sido();
                foreach ($sido as $key =>$resultSido) {

                ?>
                <option value="sigun_<?=$key?>"><?=element('sido', $resultSido)?></option>
                <?php
                }
                ?>
            </select>
            <select class="sigun">
                <option value="" class="sigun">시도</option>
            </select>
            <?php
            $sido2=$this->Post_extra_vars_model->get_all_sido();
            $sido_key2 =0;
            foreach ($sido2 as $key =>$resultSido2) {
                $sido_key2++;
                ?>

                <select id="sigun_<?=$key?>" class="sigun hidden" name="sigun">
                        <?php
                        $addressList[$key]=$this->Post_extra_vars_model->get_all_address(element('sido', $resultSido2));
                        foreach ($addressList[$key] as $result) {
                            echo '<option value="'.element('sigun', $result).'">'.element('sigun', $result).'</option>';
                        }
                        ?>
                </select>
                <?php
            }
            ?>
            <select name="search_category">
                <option value="">카테고리선택</option>
                <?php
                $category = element('category',$view);
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
            <button type="button" class="sub-src-btn">검색</button>
        </form>
    </div>
    <div class="nav-box clearfix">
<!--        <div class="i-nav clearfix">-->
<!--            <ul>-->
<!--                <li><a href="/board/b-a-1?category_id=1"><i class="nav-mo"></i>성형외과</a></li>-->
<!--                <li><a href="/board/b-a-1?category_id=2"><i class="nav-sk"></i>피부과</a></li>-->
<!--                <li><a href="/board/b-a-1?category_id=5"><i class="nav-dent"></i>치과</a></li>-->
<!--                <li><a href="/board/b-a-1?category_id=4"><i class="nav-me"></i>한의원</a></li>-->
<!--                <li><a href="/board/b-a-1?category_id=3"><i class="nav-bt"></i>뷰티샵</a></li>-->
<!--                <li><a href="/main/category"><i class="nav-more"></i>더보기</a></li>-->
<!--            </ul>-->
<!--        </div>-->
        <?php
//        $config2 = array(
//            'skin' => 'doctormoa_chart',
//            'brd_key' => 'b-a-1',
//            'limit' => 30,
//            'length' => 40,
//            'is_gallery' => '1',
//            'image_width' => '',
//            'image_height' => '',
//            'cache_minute' => 1,
//            'findex'=>'post_hit', //정렬키
//            'foder'=>'DESC', //정렬방법
//        );
//        echo $this->board->latest($config2);
        ?>
    </div>
    <div class="main clearfix">
        <div class="main-l">
            <?php
                $config = array(
                    'skin' => 'doctormoa',
                    'brd_key' => 'b-a-1',
                    'limit' => 10,
                    'length' => 70,
                    'is_gallery' => '1',
                    'image_width' => '',
                    'image_height' => '',
                    'cache_minute' => 1,
                );
                echo $this->board->latest($config);
            ?>
            <div class="new-dt clearfix">
                <?php
                $config2 = array(
                    'skin' => 'doctormoa_rank',
                    'brd_key' => 'b-a-1',
                    'limit' => 30,
                    'length' => 40,
                    'is_gallery' => '1',
                    'image_width' => '',
                    'image_height' => '',
                    'cache_minute' => '',
                    'findex'=>'post_hit', //정렬키
                    'foder'=>'DESC', //정렬방법
                );
                echo $this->board->latest($config2);
                ?>
            </div>
        </div>
        <div class="main-r">
            <div class="advertisement">
                <ul>
                    <?=banner($position='', $type='rand', $limit = '19', $start_tag='<li>', $end_tag='</li>')?>
                </ul>
            </div>
            <div class="com-box">
                <div class="community">

                    <?php
                    //방문후기
                    $config_side1 = array(
                        'skin' => 'doctormoa_main',
                        'brd_key' => 'b-a-2',
                        'limit' => 5,
                        'length' => 40,
                        'is_gallery' => '',
                        'image_width' => '',
                        'image_height' => '',
                        'cache_minute' => 1,
                    );
                    echo $this->board->latest($config_side1);

                    //자유게시판
//                    $config_side2 = array(
//                        'skin' => 'doctormoa_main',
//                        'brd_key' => 'b-a-3',
//                        'limit' => 5,
//                        'length' => 40,
//                        'is_gallery' => '',
//                        'image_width' => '',
//                        'image_height' => '',
//                        'cache_minute' => 1,
//                    );
//                    echo $this->board->latest($config_side2);

                    //질문과 답변
//                    $config_side3 = array(
//                        'skin' => 'doctormoa_main',
//                        'brd_key' => 'b-c-1',
//                        'limit' => 5,
//                        'length' => 40,
//                        'is_gallery' => '',
//                        'image_width' => '',
//                        'image_height' => '',
//                        'cache_minute' => 1,
//                    );
//                    echo $this->board->latest($config_side3);
                    //제품판매
//                    $config_side4 = array(
//                        'skin' => 'doctormoa_main',
//                        'brd_key' => 'b-b-1',
//                        'limit' => 5,
//                        'length' => 40,
//                        'is_gallery' => '',
//                        'image_width' => '',
//                        'image_height' => '',
//                        'cache_minute' => 1,
//                    );
//                    echo $this->board->latest($config_side4);
                    //구인구직
//                    $config_side5 = array(
//                        'skin' => 'doctormoa_main',
//                        'brd_key' => 'b-b-2',
//                        'limit' => 5,
//                        'length' => 40,
//                        'is_gallery' => '',
//                        'image_width' => '',
//                        'image_height' => '',
//                        'cache_minute' => 1,
//                    );
//                    echo $this->board->latest($config_side5);
//                    공지사항
                    $config_side6 = array(
                        'skin' => 'doctormoa_main',
                        'brd_key' => 'b-b-3',
                        'limit' => 5,
                        'length' => 40,
                        'is_gallery' => '',
                        'image_width' => '',
                        'image_height' => '',
                        'cache_minute' => 1,
                    );
                    echo $this->board->latest($config_side6);
                    ?>

                </div>
<!--                <div class="time-o">-->
<!--                    <div class="phone-i"></div>-->
<!--                    <div class="time-t">-->
<!--                        <p class="p-num">031-778-7847</p>-->
<!--                        <p class="p-time">운영시간 : 평일 09:00 ~ 18:00</p>-->
<!--                        <p class="p-time2">(토/일/공휴일 휴무)</p>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
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
    $('#sido').on("change",function () {
        $('.sigun').removeClass('hidden');
        $('.sigun').addClass('hidden');
        $('#'+$(this).val()).removeClass('hidden');
    })
    $('.sub-src-btn').on("click",function () {
        var search_category = $('select[name=search_category]').val();
        var sido = $('select[name=sido]').val();
        var sigun = $('#'+sido).val();
        console.log(sido,search_category)
        if(sigun =="" || search_category==""){
            alert('지역명또는 검색할 카테고리를 선택해주세요')
        }else{
            location.href='/search?skeyword='+sigun+'&sfield=address&category_id='+search_category;
        }

    })
</script>