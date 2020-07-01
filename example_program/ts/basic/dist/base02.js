"use strict";
//interface Type같은 것이지만 좀더 넓은 의미로 그형태를가지게 하는 제약과같다
var author = { name: '안희종', height: 176 }; // ok
function getCounter() {
    var counter = function (start) {
    };
    counter.interval = 124;
    counter.reset = function () { };
    return counter;
}
var c = getCounter();
c(10);
c.reset;
c.interval = 5.0;
var macbook15 = { voltage: 20, width: 15, height: 4, color: 'glod' };
//class 문법
var NotingImportant = /** @class */ (function () {
    function NotingImportant() {
    }
    return NotingImportant;
}());
var notingImportant = new NotingImportant();
var Dog = /** @class */ (function () {
    function Dog() {
        console.log('constructing!!');
    }
    return Dog;
}());
var dog = new Dog();
var dogfood = /** @class */ (function () {
    function dogfood(dogSay) {
        console.log(dogSay + " !!!");
    }
    return dogfood;
}());
var colley0326 = new dogfood('개소리');
var Triagle = /** @class */ (function () {
    function Triagle() {
        this.vertices2 = 5;
        this.vertices = 2;
    }
    return Triagle;
}());
var triagle = new Triagle();
console.log(triagle.vertices, '//', triagle.vertices2);
