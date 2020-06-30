"use strict";
//getter 와 setter를 모르는 멍청한 개밥이여
var Foo = /** @class */ (function () {
    function Foo() {
        this._value = 'initial value';
    }
    Object.defineProperty(Foo.prototype, "value", {
        get: function () {
            return this._value;
        },
        set: function ($val) {
            this._value = $val;
        },
        enumerable: false,
        configurable: true
    });
    Foo.prototype.echo = function () {
        console.log(this._value);
    };
    return Foo;
}());
(function () {
    var foo1 = new Foo();
    foo1.value = 'new value';
    //set Foo.value = 'new value2';
    Foo.prototype.value = 'new value 2 ';
    console.info(Foo);
    var foo2 = foo1;
    var foo3 = new Foo();
    foo1.echo();
    foo2.echo();
    foo3.echo();
    console.log(Foo.prototype.value);
})();
