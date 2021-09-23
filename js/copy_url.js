//copy url
function CopyUrlToClipboard() {
  var obShareUrl = "https://www.ople.com/mall5/shop/promotion_preview.php?pr_id=1244&preview=1";

  obShareUrl.value = window.document.location.href;  //URL 세팅
  obShareUrl.select();  // 해당 값이 선택되도록 select() 합니다
  document.execCommand("copy"); // 클립보드에 복사합니다.
  obShareUrl.blur(); // 선택된 것을 다시 선택안된 것으로 바꿈니다.
  alert("URL이 클립보드에 복사되었습니다");
}
