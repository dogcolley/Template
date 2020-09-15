/*
시작하기전
: 화이팅 아자아자 보드 타고 싶다.

서술
: 스크립트 언어들은 배경도 비슷하고 다른언어지만 개념도 많이 닮아있습니다.
약간의 방식의 차이만 잘 수직하면 하나만 깊게 파면 다른언어도 쉽게 습득 할 수있습니다.

학습에서 제일 중심으로 두어야하는건
01. 모든언어의 공통적인 정의
02. 그언어 (우리는 자바스크립트)의 특징

#1장 가장 기초적인 변수를 선언 하고 이 변수가 어떻게 할당이 되는지 알아가는 과정입니다.

서술
: 컴퓨터는 ON/OFF, 0,1 의 언어이고 이루어진 bite > byte > MB > KB > GB 의 단위로 구성 되어있다만 알고있으세용!

(인간)            (운영체제 / 컴파일)           (하드웨어)
스크립트 언어       => 컴파일 =>               010101010 기계어

*/

// 할당의 변화
console.log('할당의 변화 ==start==');
var a = 'abc'; // a라는 변수는 @1002 에 할당 , 'abc'는 @5003에 저장 
console.log(a); // @1002 는 @5003을 가르킴
var c = a;  // @1003은 @5003을가르킴
a += 'def'; // 'abcdef' 라는 값은 @5004에 저장됨
console.log(a); // @1002는 @5004를 가르킴
var b = a; // @1004은 @5004를 가르킴
console.log(a===b); // true @1003은 @5004 , @1004은 @5004 
console.log(a===c); // flase @1002은 @5003 , @1004은 @5004
c += 'def';  //@1002은 @5004를 가르킴
console.log(a===c); // flase @1002은 @5004 , @1004은 @5004
console.log(c===b); // flase @1003은 @5004 , @1004은 @5004
console.log('할당의 변화 ==end==');



//참조변수
//var d = 10; php의 경우엔 참조를 이렇게한다.
//var e =& d; php의 경우엔 참조를 이렇게한다.
//js의 참조는 object 이다. 
console.log('\n 참조변수 ==start==');
var d = new Object(); //@1005 가 가르키는 @7001 
var e = d; //@1006 이 가르키는 @7001
d.test = 3; // @9001은 3이다.
console.log(e);
console.log(d);
console.log(e===d); // @1005와 @1006은 가르키고 있는게 같다.


function test(){ // 이것이 클로저  
    d.test = 4;
}



test();
console.log(e);
console.log(d);

var f = new Object(); //@1007은 @7003을 가르킨다.
f.test = 4;  //@1101은 4다!

console.log(f);
console.log(d);
console.log(d === f); //두 변수가 가르키는 주소는 다르다.

const testing = () =>{ //이역시 크로저 당한다.
    d.test = 7;
}

testing();

console.log(d);
console.log(e);

//리턴으로 줄경우 데이터와 주소를 다른걸로 복사한다면 깊은복사
// = 으로 상속을 시킬경우 복사한대상의 주소까지 카피하므로 상속복사

function test2(){
    return '1'
}

var num1 = 1;
var num2 = test2();

console.log(num1)
console.log(num2)
console.log(num1 === num2); 


var arr= [0];
var arr2= [0];

//배열 변수의 값의 할당은 같은것을 확인하면 같은 주소를 바라보고 있는걸 알수있다.
console.log(arr===arr2); 
console.log(arr[0]===arr2[0]);
console.log(arr[0]==arr2[0]);

console.log('\n 참조변수 ==end==');

