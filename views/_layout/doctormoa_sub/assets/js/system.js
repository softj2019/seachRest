
//뒤로가기
$(document).on("click",".left-btn",function () {
	console.log(1111,window.history.length)
	if(window.history.length > 1){
		window.history.back()
	}else{
		location.href="/"
	}
	//
})


$('.startDate').daterangepicker({

	singleDatePicker: true,
	startDate: moment().subtract(60, 'days'),
	locale:"ko",
	locale: {
		format: 'YYYY-MM-DD',
	}
});

$('.endDate').daterangepicker({
	singleDatePicker: true,
	startDate: moment().subtract(0, 'days'),
	locale:"ko",
	locale: {
		format: 'YYYY-MM-DD',
	}
});
$(".startDate").on("focus",function () {
	$(this).val("");
	$(".startDate").inputmask('9999-99-99');
})
$(".endDate").on("click",function () {
	$(this).val("");
	$(".endDate").inputmask('9999-99-99');
})

// 전체 선택
$('input[name=checkAll]').on("change",function () {
	var target = $(this).val();
	//값을 변경후 트리거 해준다
	if($(this).is(":checked")){
		$('.'+target).prop("checked",true).trigger('change');;
	}else{
		$('.'+target).prop("checked",false).trigger('change');
		$('.'+target+'_view').html()
	}

})

function callDebugToast(text) {
	$.toast({
		position: 'bottom-right',
		heading: "Debug",
		text: text,
		icon: "info",
		// hideAfter: false
		loaderBg: '#ffffff',  // Background color of the toast loader
		hideAfter: false,
	});
}
function callToast(text,icon,heading) {
	$.toast({
		position: 'bottom-right',
		heading:heading,
		text: text,
		icon: icon,
		loaderBg: '#ffffff',  // Background color of the toast loader
	});
}
function callToastMidCenter(text,icon,heading) {
	$.toast({
		position: 'mid-center',
		heading:heading,
		text: text,
		icon: icon,
		loaderBg: '#ffffff',  // Background color of the toast loader
	});
}
function callToastHideAfter(text,icon,heading,data,bsmodal){
	if(data.alerts_status=="success"){
		$.toast({
			position: 'bottom-right',
			heading: heading,
			text: text,
			icon: icon,
			// hideAfter: false
			loaderBg: '#ffffff',  // Background color of the toast loader
			hideAfter: 2000,
			afterHidden: function () {
				if(bsmodal){
					bsmodal.modal('toggle');
				}
				location.reload();
			}
		});
	}else{
		$.toast({
			position: 'bottom-right',
			heading: "알림",
			text: "요청이 실패했습니다.",
			icon: "error",
			// hideAfter: false
			loaderBg: '#ffffff',  // Background color of the toast loader
			// hideAfter: 1300,
		});
	}

}
function callToastHideFalse(text,icon,heading) {
	$.toast({
		position: 'bottom-right',
		heading:heading,
		text: text,
		icon: icon,
		loaderBg: '#ffffff',  // Background color of the toast loader
		hideAfter: false,
	});
}
//문자열 치환 배열 저장
function callSplit(StringArr) {
	return StringArr.split(",")
}

//비밀번호 초기화
$(document).on('click','.passwordChange',function () {
	$.ajax({
		type: "POST",
		url: base_url+"member/resetpasswordproc",
		// dataType:"html",
		data:$('#passwordChange').serialize(),
		// async: false
	}).done(function(data){
		console.log(data);
		if(data.alerts_title){
			// $('#modal-user').modal('toggle');
			$.each(data.alerts_title,function (key,value) {
				$('.'+key).html(value);
			});
		}
		if(data.alerts_status=="success"){
			$('#modal-user').modal('toggle');
		}
	});
})

//사용자 승인
$(document).on("click",".joinApply",function () {
	if(!$('.list_chk').is(":checked")){
		callToast('변경 대상을 선택하세요','error','알림');
	}else{
		$.ajax({
			type: "POST",
			url: base_url+"console/joinapply",
			data:$('#defaultForm').serialize(),
		}).done(function(data){
			if(data.alerts_status=="success"){
				callToastHideAfter("요청이 정상적으로 처리되었습니다","success","알림",data);
			}
			else{
				callToastHideAfter("선택한 대상 중에 관리자가 포함되어있습니다.","success","알림",data);
			}
		});
	}
})
//사용자 삭제
$(document).on("click",".deleteUser",function () {
	if(!$('.list_chk').is(":checked")){
		callToast('변경 대상을 선택하세요','error','알림');
	}else{
		$.ajax({
			type: "POST",
			url: base_url+"console/deleteUser",
			data:$('#defaultForm').serialize(),
		}).done(function(data){
			if(data.alerts_status=="success"){
				callToastHideAfter("요청이 정상적으로 처리되었습니다","success","알림",data);
			}
			else{
				callToastHideAfter("선택한 대상 중에 관리자가 포함되어있습니다.","success","알림",data);
			}
		});
	}
})

//사용자 부여
$(document).on("click",".userAccessApply",function () {
	if(!$('.list_chk').is(":checked")){
		callToast('변경 대상을 선택하세요','error','알림');
	}else{
		$.ajax({
			type: "POST",
			url: base_url+"console/userAccessApply",
			data:$('#defaultForm').serialize(),
		}).done(function(data){
			if(data.alerts_status=="success"){
				callToastHideAfter("요청이 정상적으로 처리되었습니다","success","알림",data);
			}
			else{
				callToastHideAfter("선택한 대상 중에 관리자가 포함되어있습니다.","success","알림",data);
			}
		});
	}
})
//관리자권한 부여
$(document).on("click",".adminAccessApply",function () {
	if(!$('.list_chk').is(":checked")){
		callToast('변경 대상을 선택하세요','error','알림');
	}else{
		$.ajax({
			type: "POST",
			url: base_url+"console/adminAccessApply",
			data:$('#defaultForm').serialize(),
		}).done(function(data){
			if(data.alerts_status=="success"){
				callToastHideAfter("요청이 정상적으로 처리되었습니다","success","알림",data);
			}
			else{
				callToastHideAfter("관리자는 관리자 권한 부여를 할 수 없습니다\r\n시스템 관리자에게 문의 하세요.","success","알림",data);
			}
		});
	}
})

//게시판 저장
function submitBoardFormSave(){
	var title = $('input[name=title]').val();
	var content = $('textarea[name=content]').val();
	if(title!=null && content!=null){
		$.toast({
			position: 'bottom-right',
			heading: "알림",
			text: "요청이 정상적으로 처리되었습니다",
			icon: "success",
			// hideAfter: false
			loaderBg: '#ffffff',  // Background color of the toast loader
			hideAfter: 1700,
			afterHidden: function () {
				$('#defaultForm').submit();
			}
		});
	}else{
		if(title==null) callToast("제목은 필수 입력입니다.","error","알림")
		if(content==null) callToast("내용은 필수 입력입니다.","error","알림")
	}
}
//게시물 삭제
function submitBoardDelete(br_cd){
	$.toast({
		position: 'bottom-right',
		heading: "알림",
		text: "요청이 정상적으로 처리되었습니다",
		icon: "success",
		// hideAfter: false
		loaderBg: '#ffffff',  // Background color of the toast loader
		hideAfter: 1700,
		afterHidden: function () {
			location.href='/console/boarddelete/'+br_cd;
		}
	});
}
//게시물 파일 삭제
function deleteFile(file_id) {
	$.ajax({
		type: "POST",
		url: base_url+"console/deleteBoardFile",
		data:{'file_id':file_id},
	}).done(function(data){
		callToastHideAfter("요청이 정상적으로 처리되었습니다","success","알림",data);

	});
}

// 이런 함수로 비교해야 함
//

function isSame(a, b, epsilon)

{

	if (!epsilon) epsilon = 0.000001;



	return Math.abs(a - b) < epsilon;

}
//카카오톡 로그인
$('#kko-login-btn').click(function () {
	window.open('https://kauth.kakao.com/oauth/authorize?client_id=afdfad9353a84d1efbcbe2066735437c&redirect_uri='+base_url+'oauth&response_type=code','','width=750, height=900');
});
//천단위 콤마
function comma(num){
	var len, point, str;

	num = num + "";
	point = num.length % 3 ;
	len = num.length;

	str = num.substring(0, point);
	while (point < len) {
		if (str != "") str += ",";
		str += num.substring(point, point + 3);
		point += 3;
	}

	return str;

}
$('#btnBoardChangeOrder').on("click",function () {
	var orderArr = $('.order');
	var formData = $("#defaultForm").serialize();
	var param='';
	$.each(orderArr,function (key,value) {
		if(orderArr.eq(key).val()){
			param+='&id%5B%5D='+orderArr.eq(key).attr("data-id")
				+"&orderNo%5B%5D="+orderArr.eq(key).val()
			;
		}
		// console.log($('input[name=order]').eq(key).val(),$('input[name=order]').eq(key).attr("data-id"))
	})
	formData+param
	$.ajax({
		type: "POST",
		url: base_url+'console/boardChangeOrder',
		data:formData+param,
		dataType: "json",
		success: function (data) {
			// console.log(data);
		}
	});
	location.reload();
})

//내위치찾기
$(document).ready(function($) {

	var $findMeBtn = $('.find-me');

	// Check if browser supports the Geolocation API
	if (!navigator.geolocation) {

		$findMeBtn.addClass('disabled');
		$('.no-geolocation-support').addClass('visible');

		// Check if the page is accessed over HTTPS
	} else if (location.protocol !== 'https:') {

		// Check if top-level frame
		if (window.top === window.self) {

			// Reload the page over HTTPS
			location.href = 'https:' + window.location.href.substring(window.location.protocol.length);

			// If not top-level, display a message
			// Note: CodePen does not allow an `<iframe>` to reload the top-level frame (browser window). See about the `sandbox` attribute at https://developer.mozilla.org/en-US/docs/Web/HTML/Element/iframe#Attributes.
		} else {

			$findMeBtn.addClass('disabled');
			$('.not-on-https').addClass('visible');

		};

		// Let's use the Geolocation API
	} else {

		$findMeBtn.on('click', function(e) {

			e.preventDefault();

			navigator.geolocation.getCurrentPosition(function(position) {

				// Get the location coordinates
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				console.log(lat,lng)

			});

		});

	};

});
//하단 네비게이션 사용자 아이콘클릭시 로그인 유무에 따라 페이지이동
$('.userIcon').on("click",function () {
	if($(this).attr("data-id")=="logged_in"){
		location.href=base_url+"member/mypage";
	}else{
		location.href=base_url+"member/login";
	}
})
