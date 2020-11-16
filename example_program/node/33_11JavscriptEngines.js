/*
11 자바스크립트 엔진이란?

우리가 아는 자바스크립트는 말그대로 '스크립트' 언어이다. 
응용프로그램에 우리가 원하는 명령어를 입력하면 동작하는 원리인데 대표적으로 자바스크립트는 'WEB' 이라는 환경에서 인지도를 얻어 널리 퍼졌다.

JavaScript 엔진은 javascript 코드를 해석하고 실행하게되는 프로세스 가상머신입니다!

web페이지를 구성하여 브라우저를 구동하는 레이아웃엔진을 해석하고 하위순위의 js엔진을 구분하며 여러 동작을 실행하게 됩니다.

ECMAScript (자바스크립트표준)을 기준으로 정의됩니다.
( ex) ie에선 es6 문법이 따로 지원이 되지 않지만 A8엔진을 채택한 크로미움 브라우저에선 버전에따라 ECMAScript 버전또한 같이 올라가므로 최신문법을 지원한다. )




//nodeJS 의 구조 
nodejs lib
nodejs soket/http/ajax
v8engin/ / /  

//nodeJS V8 Engin?
C++/ C 로 구성되어있는 컴파일 엔진

js code => Parser => Abstract Syntax Tree => Interpreter Ignition => Bytecode 
                                                    ▽                  △
                                             Compiler TurboFan    => Opiimized Machine Code





// 싱글 쓰레드와 멀티 쓰레드의 차이
https://yonghyunlee.gitlab.io/node/nodejs-structure/

//싱클 쓰레드
A=> 1번쓰레드 , B=> 2번쓰레드 


//멀티 쓰레드



// JS는 싱클 코어이다. 그런데 멀티 쓰레드와 유사하게 기능을 처리하는데 이경우는 어떻게 처리하는건가?
Thread Pool => nonblocking function을 사용하면 된다!
req => res 의 싱글 입력후 처리는 blocking io에서 처리하면 된다.

// nodejs를 사용하면 안될때
CPU 작업이 많은 어플리케이션에선 적당하지 않음
: CPU의 구조는 쓰레드,코어 (1코에어 2쓰레드로 구성됨) 쓰레드의 성능은 Hz Clock으로 결정됩니다. 좀더 좋은 성능의 CPU를 요구하게되는구조



*/