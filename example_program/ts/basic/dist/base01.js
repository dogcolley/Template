"use strict";
//변수선언
//블리언
var isTypeScriptAwesome = true;
var doesjavascriptHasTypes = false;
//숫자
var userScore = 100;
var ieee754IsAwesome = 0.1 + 0.2;
//널
var nullVlaue = null;
var undefinedValue = undefined;
//const numberVlaue : number = null; 이경우는 기본옶션인 strictNullChecks 옵션이 켜져있어야지 실행이가능하다.
//any, void, never : 어느것이나, 빈곳, 어떠한값도 없게
var bool = true;
bool = 3;
bool = 'test';
bool = {};
function nothing() { }
function alwaysThrow() {
    throw new Error("I'm a wicked function!");
}
//array tuplue : 함수도 마찬가지로 어떤 타입인지선언, 튜플의 경우엔 안에 혼종 허락
var pibonacci = [0, 1, 2, 3, 4, 5, 6, 7, 8];
var myFavoriteBeers = ['a', 'b', 'c'];
var nameAndHeight = ['이름', 5];
//객체선언
var user = { name: '이름', height: 5 };
var userWithUnknownHeight = { name: '이름' };
var user2 = { name: "변경불가능한이름", height: 176 };
function getUser(uuid) {
    console.log(uuid);
}
getUser('test');
// 함수선언
function sum(a, b) {
    return a + b;
}
function LogGreetings(name) {
    console.log("hello, " + name);
}
function notReallyVoid() {
    console.log(1);
    //if you use return ts comfile err
}
//화살표 변수 지정
var yetAnotherSum = sum;
var onePlusOne = function () { return 2; };
var arrowSum = function (a, b) { return a + b; };
var definitelySum = function (a, b) { return a + b; };
//선택 매개 : 이경우 선택 매개는 필수 매개 이후에 정의 해준다.
function fetcgVideo(url, subtitleLanguage) {
    var option = { url: url };
    if (subtitleLanguage) {
        option.subtitleLanguage = true;
    }
    console.log(option);
}
//함수 오버로딩 : 여러쌍의 매개변수 반환 타입 쌍으로 갖는 경우 정의를 내려준다.
function doubleString(str) {
    return str + ", " + str;
}
function doubleNumber(num) {
    return num * num;
}
function doubleBooleanArray(arr) {
    return arr.concat(arr);
}
function double(arg) {
    if (typeof arg === 'string') {
        return "" + arg + arg;
    }
    else if (typeof arg === 'number') {
        return arg * 2;
    }
    else if (Array.isArray(arg)) {
        return arg.concat(arg);
    }
}
var cd;
var onClick = function (event, cb) {
    console.log(this.tagName);
    cb();
};
//제네릭
//: 규칙을 갖은 타입을 손쉽고 우아하..개?..??
//일반 동기 부여 소스코드
function getFristName(arr) {
    if (!Array.isArray(arr)) {
        throw new Error('getFirstNameNull: Argument is not array');
    }
    if (arr.length === 0) {
        throw new Error('getFirstNameNull: Argument is not array');
    }
    return arr[0] ? arr[0] : null;
}
function GetFirstName(arr) {
    if (!Array.isArray(arr)) {
        throw new Error('없다고');
    }
    if (arr.length === 0) {
        throw new Error('없다고');
    }
    return arr[0] ? arr[0] : null;
}
GetFirstName(['장']);
//console.log(LogGreetings('??'));
//console.log(sum(1,2));
//console.log(arrowSum(1,2))
//fetcgVideo('www.test.com');
//function echoTest():void{console.log('test');}
