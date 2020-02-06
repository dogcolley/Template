<?php
include_once('./_common.php');
$g5['title'] = '게시판관리';
$admin_cate_gubun = "exp";
include_once ('./admin.head.php');
?>
<h2 class="admin_heading">상가등록방법</h2>
<div class="exp_box">
	<p>1. 좌측메뉴 <span>상가</span>탭에 들어간 후 <span>글쓰기</span> 클릭<br>
	2. <span>업종구분</span> 선택 ( 카테고리 )<br>
	3. <span>상가위치</span> 선택 ( 상가위치는 하단 이미지를 참고하여 해당 상가의 위치에 맞게 선택 )<br>
	4. 점포명, 인사말 등 기본 정보 입력 ( <span>점포명과 점포소개</span>는 필수로 작성해야 등록할 수 있습니다 )<br>
	5. 등록이 완료되었다면 좌측메뉴의 <span>매장상품</span>탭에 들어간 후 <span>글쓰기</span> 클릭<br>
	6. <span>점포</span>에는 <span>상가 탭에서 등록한 해당 상가의 이름</span>을 찾아서 선택<br>
	7. <span>제목 입력</span> 후 <span>글쓰기</span> 클릭<br>
</div>
<div class="exp_img">
	<img src="<? echo G5_IMG2_URL;?>/map_guide.gif">
</div>
<?php
include_once (G5_USER_ADMIN_PATH.'/admin.tail.php');
?>
