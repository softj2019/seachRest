
$(document).on('click', '.ham-btn', function(e){
    e.preventDefault();
    $('.right-tab').addClass('on');
    $('.tab-bg').addClass('on'); 
    $('body').css('overflow', 'hidden');
 });
 $(document).on('click', '.closebox', function(){
    $('.right-tab').removeClass('on'); 
    $('.tab-bg').removeClass('on');
    $('body').css('overflow', 'auto');
 });
 
// 위아래버튼
 $(".scroll-t").click(function() {
     $('html, body').animate({
     scrollTop : 0
     }, 400);
     return false;
 });
 $(".scroll-d").click(function(){
     $('html, body').animate({
     scrollTop:($('body').height())
     }, 400);
     return false;
 });

 var floatPosition = parseInt($(".scroll-b").css('top'));
 $(window).scroll(function() {
     var scrollTop = $(window).scrollTop();
     var newPosition = scrollTop + floatPosition + "px";
     $(".scroll-b").stop().animate({
         "top" : newPosition
     }, 500);

 }).scroll();
 // 슬라이더
 $(window).load( function(){
    $('.m-slider').slick({
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        infinite: true,
        arrows: false,
        });
    $(".slide2 .swiper-wrapper").slick({
        dots: false,
        vertical: true,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed:2000,
        infinite: true,
        arrows: false,
        verticalSwiping: true,
    });

 });
 //탭
 $('.tab-box ul li').click(function(){
    var tab_id = $(this).attr('data-id');

    $(this).siblings('li').removeClass('on');
    $(this).closest('.tab-box').next('.content-in').children('.tab-con').removeClass('on');
    $(this).addClass('on');
    $("#"+tab_id).addClass('on');
});
// 모달
$(".review-btn").click(function(e){
    e.preventDefault();
    $("#review-mo").addClass('on');
});
$(".qt-btn").click(function(e){
    e.preventDefault();
    $("#qt-mo").addClass('on');
});
$(".qt-an-btn").click(function(e){
    e.preventDefault();
    $("#qt-an").addClass('on');
});
$(".ham-i").click(function(e){
    e.preventDefault();
    $("#ham-mo").addClass('on');
});
$(".doc-mo-btn").click(function(e){
    e.preventDefault();
    $("#doc-mo").addClass('on');
});
$(".modalClose").click(function(){
    $(this).parents(".modal").removeClass('on');
    $('body').css('overflow', 'auto');
});
$(".review-btn-t").click(function(e){//201027 추가
    e.preventDefault();
    $("#review-mo-t").addClass('on');
});//~


$("textarea.autosize").on('keydown keyup', function () {
    $(this).height(1).height( $(this).prop('scrollHeight')-20 );	
});
$(document).on('click','.remove-btn','.re-com-btn', function () {
    $(this).parent().parent().parent().remove();
});
$('.re-com-btn').click(function(){
        $(this).parent().parent().parent().children('.com-rcom').addClass('on');
        $('.com-rcom textarea').focus();
    })
$('.re-com-rebtn').click(function(){
    $(this).parent().parent().removeClass('on');
})
 
$(".menu-box-tree,.menu-box-tree2").hide();
$(".menu-box-tree > li > a,.select-p").click(function(e){
    e.preventDefault();
    $(this).next().slideToggle(300);
});
// 201102 추가
var uploadFile = $('.fileBox .uploadBtn');

uploadFile.on('change', function(){
    if(window.FileReader){
        var filename = $(this)[0].files[0].name;
    } else {
        var filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $(this).siblings('.fileName').val(filename);
});
var uploadFile2 = $('.fileBox .uploadBtn2');
    uploadFile2.on('change', function(){
        if(window.FileReader){
            var filename = $(this)[0].files[0].name;
        } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }
        $(this).siblings('.fileName2').val(filename);
    });