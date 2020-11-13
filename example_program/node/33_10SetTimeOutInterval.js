/*
//유즈 셋타임
function sayHi(){ console.log('Hello');}
setTimeout(() => {sayHi();}, 1000);
*/

/*
//클리어 셋타임
let timer01 = setTimeout(() => {sayHi();}, 1000);
clearTimeout(timer01);
*/

/*
//인터벌 가이드
let cnt = 0;
let timer02 = setInterval(()=> {
    console.log(`hi cnt : ${cnt}`)
    cnt++;
    if(cnt == 10) 
        clearInterval(timer02);
},1000);
*/

/*
//중첩 time문에서 발생하는 이벤트 실행순서
let timer03 = setTimeout(() => {
    console.log('One Pass Time');
    setTimeout(() => {
        console.log('Tow Pass Time');
    }, 1000);
}, 1000);
*/

/*
//코드의 지연시간측정 비교 A, B
function func(){console.log('move!')}

let i = 1;
setInterval(function() {
  func(i++);
}, 100);

i = 1;
setTimeout(function run() {
  func(i++);
  setTimeout(run, 100);
}, 100);
*/

/*
//제로 지연(즉시실행, 브라우저에선 약간의 시간이 소요될 수 있음)
setTimeout(() => console.log("World"));
console.log("Hello");
*/

/*
//why people don't use setInterval 
const fakeCallToServer = function() {
    setTimeout(function() {
        console.log('returning from server', new Date().toLocaleTimeString());
    }, 4000);
}

setInterval(function(){ 

    let insideSetInterval = new Date().toLocaleTimeString();

    console.log('insideSetInterval', insideSetInterval);

    fakeCallToServer();
}, 2000);
*/

/*
//so we make good awit code 
const delayReport = deplayMs => new Promise((resolve) => {
    setTimeout(resolve, deplayMs);
});
const setIntervalAsync = (fn, ms) => {
    fn().then(() => {
      setTimeout(() => setIntervalAsync(fn, ms), ms);
    });
  };
setIntervalAsync(async () => { console.log(new Date()); await delayReport(1000); }, 1000);
*/


// and we meching the settime out end setintervel
// we know front dev how better window load? => window.onload Best 
// end we can make setintever in settimeout

let cnt2 = 0;
function clockA(){
    setTimeout(() => {
        console.log('CLICK! +'+cnt2);
        cnt2 ++;
        if(cnt2 ==11)
            clearTimeout(clockA);
        clockA();
    }, 1000);
}

clockA();