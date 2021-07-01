//main_notice
var main_notice = $("#main_notice").bxSlider({
mode:'horizontal',
speed:200,
pager:false,
moveSlides:1,
minSlides:1,
maxSlides:1,
slideWidth:220,
auto:true,
controls:false,
onSlideAfter: counter2,
onSliderLoad: init2,
});
$("#noti_prev").on('click',function(){
main_notice.goToPrevSlide();
return false;
});
$("#noti_next").on('click',function(){
main_notice.goToNextSlide();
return false;
});
function init2() {
$('.main_card_homemain').append('<span style="color:#fff; font-size:12px; font-weight: lighter; display: inline-block;"><b class="main_promotion_current" id="event_current" style="display: inline-block;">1</b> / <b class="main_promotion_total" id="event_total">6</b></span>');
}
function counter2() {
$('#event_current').text(mySlider.getCurrentSlide() + 1);
$('#event_total').text(mySlider.getSlideCount());
}

/**
<div class="main_card">
    <ul id="main_notice">
        <li><a href="#"><img src="image/card_event_01.jpg"></a></li>
        <li><a href="#"><img src="image/card_event_01.jpg"></a></li>
        <li><a href="#"><img src="image/card_event_01.jpg"></a></li>
        <li><a href="#"><img src="image/card_event_01.jpg"></a></li>
    </ul>
</div>
<div class="main_card_pagination">
    <a href="#" class="btn_prev" id="noti_prev"></a>
    <div class="main_card_homemain" style="cursor: none;">

    </div>
    <a href="#" class="btn_next" id="noti_next"></a>
</div>
*/
