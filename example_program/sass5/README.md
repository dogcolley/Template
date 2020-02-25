/* 패치노트

1.0.0 테스트 버전 PC / M / TAB 에 맞춘 방응형 모델 활성화
1.0.5 유저 정의 스타일 U 추가
1.1.0 자식 태그 전용 스타일 _cd , C 추가 및 퍼센트제어 P 추가
2.0.0 Import 형식 변경 , width 와 height 등을 퍼센트로 변경하여 용량 및 최적화를 위한 패치 하위버전 적용 안됌 (진행중)


*/

/* J-style and scss style (add Grass)
	guide : 가이드 해당스타일은 부트스트랩과같은 공통클래스와 사용자 정의 css를 합친 스타일입니다.  
            (The corresponding style in the Guide is a combination of common classes such as bootstrap and custom css.)

		1.첫번째 이니셜 (디바이스)
			T = 테마 (Theme style) : 모든 디바이스에서
			U = 사용자 지정 (user style)
			J = 자바스크립트용 (javascript class)
			PC = 피시버전용 (class for PC)
			Tab = 테블릿전용  (class for Tab)
			M = 모바일 전용(class for Mobile)
			PT = 피시 and 테블릿 (class for PC , Tab )
			TM = 모바일 and 테블릿 (class for Tab , mobile )
			IM = 무조건 (!important)

		2.두번째 단축어 (속성)
			ft = 폰트(font)
			bg = 백그라운드(background)
			fm = 폰트 패밀리(font-family)
			mg = 마진 (margin)    
			pd = 패딩 (padding)    
			cl = 컬러 (color)
			sz = 사이즈 (size)
			lh = 라인하이트 (line-height)
			fl = 플롯 (float)
			ps = 포지션 (position)
			wd = 넓이 (width)
			ht = 높이 (ht)
			gd = 가이드 (guide) 
			ly = 레이아웃(layout) 가로사이즈 제어
			bx = 박스(box)
		
		3.세번째 단축어(옵션)
			lf = 레드프(left)
			rt = 라이트(right) 
			top = 탑 (top)
			btm = 바텀(btm)
			wd = 좌우(left, right)
			ht = 상하(height, width)
			rem = rem(rem)

		4.네번째 단축어(보조)
			cd = 자식(chard)
			tagName = 부모의 자식 특정 태그를 지정
			hf = 반(Half)
*/

/* 
SCSS base Data 

!default : 값이 없으면 초기값을 할당 시켜준다.
#'에'{} : 문자 보간
!global (전역 설정)
중첩 안에서 & 키워드는 상위(부모) 선택자를 참조하여 치환합니다.
@at-root (중첩 벗어나기)
@mixin @inlclude : 믹스인은 해당 선언 사용후 그걸 인크루도 재활용한다. $mixin test-style ($매개변수){}
@extend 
@function($x, $y)
@return
@each $변수 in 데이터 {}
@while 조건 {}
@if [and],[or],[not] : ex @if ($a > 0) and ($b > 0){}  +@else if , @else
@import 다른 파일 가져오기
@for $i from 1 through 3 { @for $i from 1 to 3 {

색상(RGB / HSL / Opacity) 함수
mix($color1, $color2) : 두 개의 색을 섞습니다.
lighten($color, $amount) : 더 밝은색을 만듭니다.
darken($color, $amount) : 더 어두운색을 만듭니다.
saturate($color, $amount) : 색상의 채도를 올립니다.
desaturate($color, $amount) : 색상의 채도를 낮춥니다.
grayscale($color) : 색상을 회색으로 변환합니다.
invert($color) : 색상을 반전시킵니다.
rgba($color, $alpha) : 색상의 투명도를 변경합니다.
opacify($color, $amount) / fade-in($color, $amount) : 색상을 더 불투명하게 만듭니다.
transparentize($color, $amount) / fade-out($color, $amount) : 색상을 더 투명하게 만듭니다.

문자(String) 함수
unquote($string) : 문자에서 따옴표를 제거합니다.
quote($string) : 문자에 따옴표를 추가합니다.
str-insert($string, $insert, $index) : 문자의 index번째에 특정 문자를 삽입합니다.
str-index($string, $substring) : 문자에서 특정 문자의 첫 index를 반환합니다.
str-slice($string, $start-at, [$end-at]) : 문자에서 특정 문자(몇 번째 글자부터 몇 번째 글자까지)를 추출합니다.
to-upper-case($string) : 문자를 대문자를 변환합니다.
to-lower-case($string) : 문자를 소문자로 변환합니다.

숫자(Number) 함수
percentage($number) : 숫자(단위 무시)를 백분율로 변환합니다.
round($number) : 정수로 반올림합니다.
ceil($number) : 정수로 올림합니다.
floor($number) : 정수로 내림(버림)합니다.
abs($number) : 숫자의 절대 값을 반환합니다.
min($numbers…) : 숫자 중 최소 값을 찾습니다.
max($numbers…) : 숫자 중 최대 값을 찾습니다.
random() : 0 부터 1 사이의 난수를 반환합니다.

List 함수
모든 List 내장 함수는 기존 List 데이터를 갱신하지 않고 새 List 데이터를 반환합니다.
모든 List 내장 함수는 Map 데이터에서도 사용할 수 있습니다.

length($list) : List의 개수를 반환합니다.
nth($list, $n) : List에서 n번째 값을 반환합니다.
set-nth($list, $n, $value) : List에서 n번째 값을 다른 값으로 변경합니다.
join($list1, $list2, [$separator]) : 두 개의 List를 하나로 결합합니다.
zip($lists…) : 여러 List들을 하나의 다차원 List로 결합합니다.
index($list, $value) : List에서 특정 값의 index를 반환합니다.

Map 함수
모든 Map 내장 함수는 기존 Map 데이터를 갱신하지 않고 새 Map 데이터를 반환합니다.
map-get($map, $key) : Map에서 특정 key의 value를 반환합니다.
map-merge($map1, $map2) : 두 개의 Map을 병합하여 새로운 Map를 만듭니다.
map-keys($map) : Map에서 모든 key를 List로 반환합니다.
map-values($map) : Map에서 모든 value를 List로 반환합니다.

관리(Introspection) 함수
variable-exists(name) : 변수가 현재 범위에 존재하는지 여부를 반환합니다.(인수는 $없이 변수의 이름만 사용합니다.)
unit($number) : 숫자의 단위를 반환합니다.
unitless($number) : 숫자에 단위가 있는지 여부를 반환합니다.
comparable($number1, $number2) : 두 개의 숫자가 연산 가능한지 여부를 반환합니다.
*/

/*sass 변수 모음*/
//$j_device : ('.T_','.TAB_','.M_','.TM_','.PC_','.PM_','.PT_'); 