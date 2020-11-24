/*
11 자바스크립트 엔진이란?

우리가 아는 자바스크립트는 말그대로 '스크립트' 언어이다. 
응용프로그램에 우리가 원하는 명령어를 입력하면 동작하는 원리인데 대표적으로 자바스크립트는 'WEB' 이라는 환경에서 인지도를 얻어 널리 퍼졌다.

JavaScript 엔진은 javascript 코드를 해석하고 실행하게되는 프로세스 가상머신입니다!

web페이지를 구성하여 브라우저를 구동하는 레이아웃엔진을 해석하고 하위순위의 js엔진을 구분하며 여러 동작을 실행하게 됩니다.

ECMAScript (자바스크립트표준)을 기준으로 정의됩니다.
( ex) ie에선 es6 문법이 따로 지원이 되지 않지만 A8엔진을 채택한 크로미움 브라우저에선 버전에따라 ECMAScript 버전또한 같이 올라가므로 최신문법을 지원한다. )

//01.제일 정리가 잘된 JS 구동원리
https://velog.io/@namezin/javascript-%EB%8F%99%EC%9E%91-%EC%9B%90%EB%A6%AC

//02.추가 가끔 햇갈리는 블로킹 개념
: https://nodejs.org/ko/docs/guides/blocking-vs-non-blocking/
: 논블로킹 비동기 작업
: 블로킹  동기 작업
: 안좋은 예제
```
const fs = require('fs');
fs.readFile('/file.md', (err, data) => {
  if (err) throw err;
  console.log(data);
});
fs.unlinkSync('/file.md');
```

//03.스텍이 미친듯이 쌓인다면?
: 저번시간에 배운 스텍이 쌓여 이벤트가 계속 쌓이게 되면 
브라우저에선 SesstionStack will help you resolve crashes 
에러가 나면서 쌓여있는 스텍 싹 날려버린다.


//04.getting Hot 과 최적화 방식
Just-in-Time Compilation (JITC) 
: JS Source => Parser & IR generator => IR => Just-in-Time-compiler => Native Code
: 소스코드를 바이트로 환산후 컴파일해서 네이티브 코드로 반환
: 단점 1.변수타입이 바뀔수있다. 2. class 대신 object로 상속되는 prototype-based 방식을 사용하게 되어 문제 발생가능

Adaptive Compilation : 적응 형 최적화
: JS Source = (parser) => ASP = (Full-Codegen-JITC) => nativeCode ◀····(Deopimizer)···· (예외적인 상황발생시 예전코드로 복구)
                           ▲                     ㄴ => OpimizedNativeCode = () =>  ····:
                          RuntimeProfiler ◀······················: (함수의 호출 빈도특정)
                           ▼                       
                          CrankShaftJITC  

(CrankShaft에서 Type Specialization을 최적화를 적용하기 위한 변수의  실제 타입 정보를 저장)

※혼틈 "깨"동란tip array가 중요한데, 하나의 array에는 하나의 type만 넣어주는 것이 최고입니다! 성능에 영향을 미칩니다.
https://medium.com/dailyjs/understanding-v8s-bytecode-317d46c94775/#569b
(ex) const arr = [1,'1',{1,2,3}])


//05.nodeJS 의 구조 

JS + C/C++ 로 만들어졌습니다. (결국나중엔 컴파일언어인 C/C++를 해야한다..)


························································
:        nodejs standard lib                           :
························································
:        node bindings (socket,http,etc)               :  
························································
: V8 : Thread pool : event loop : DNS : cypto(openSSL) :
························································ 

//05_1 nodejs lib
실질적으로 V8과 연결되어 특정 기능들을 수행할 수 있도록 도와주는 자바스크립트 기본 라이브러리입니다.
자바스크립트 언어로 작성되었으며, 이를 통해 노드 바인딩과 연결됩니다.

//05_2 nodejs soket/http/ajax
C/C++로 구성된 시스템 바인딩 레이어입니다. C/C++ 로 작성된 라이브러리를 자바스크립트에서 사용할 수 있도록 결합하는 핵심 요소입니다. 
소켓, http 등의 통신 기능이 제공되지만, DOM에 관한 기능은 제공되고 있지 않습니다. 
소켓이나 http 등에 대한 노드 바인딩이 노드 표준 라이브러리와의 인터페이스 역할을 합니다. 

//05_3.JS의 이벤트루프는 싱클 쓰레드이다. 그런데 멀티 쓰레드와 유사하게 기능을 처리하는데 이경우는 어떻게 처리하는건가?
Thread Pool => nonblocking function을 사용하면 된다!
req => res 의 싱글 입력후 처리는 blocking io에서 처리하면 된다.
싱글 쓰레드와 멀티 쓰레드의 차이
https://yonghyunlee.gitlab.io/node/nodejs-structure/

//05_4 C-ares DNS
동시에 복수의 DNS 질의 요청을 비동기적으로 처리하기 위한 C 라이브러리입니다.

//05_5 cypto 
open SSL로 보안과 관련된 부분을 담당하고 있습니다.
https://www.zerocho.com/category/NodeJS/post/593a487c2ed1da0018cff95d


//06.nodeJS V8 Engin?
C++/ C 로 구성되어있는 컴파일 엔진

js code => Parser => Abstract Syntax Tree => Interpreter Ignition => Bytecode 
                                                    ▽                  △
                                             Compiler TurboFan    => Opiimized Machine Code
Parser                 : 코드를 읽어낸다.
Abstract Syntax Tree   : 쓸데 없는 구성을 버리고 필수적인 요소만 담는 과정
Interpreter Ignition   : 인터프린트 점화 => 코드를 한줄 한줄 읽기 시작한다.
Bytecode               : nodeJs의 ByteCode로 환산한다. 0x0000000
Compiler TurboFan      : 최적화된 기계어 코드(machine code)를 시간들여 생성후 => 최적화 컴파일러를 만들어줍니당 
Opiimized Machine Code : 컴파일이 완료되어 반환

//07.nodejs를 사용하면 안될때
CPU 작업이 많은 어플리케이션에선 적당하지 않음
: CPU의 구조는 쓰레드,코어 (1코에어 2쓰레드로 구성됨) 쓰레드의 성능은 Hz Clock으로 결정됩니다. 좀더 좋은 성능의 CPU를 요구하게되는구조




*/