//getter 와 setter를 모르는 멍청한 개밥이여
class Foo {

    _value: string;

    constructor() {
        this._value = 'initial value';
    }

    set value($val) {
        this._value = $val;
    }

    get value() {
        return this._value;
    }

    echo() {
        console.log(this._value);
    }

}

(function(){
    const foo1 = new Foo();
    foo1.value = 'new value';
    //set Foo.value = 'new value2';
    Foo.prototype.value = 'new value 2 ';
    console.info(Foo);
    const foo2 = foo1;
    const foo3 = new Foo();
    
    foo1.echo();
    foo2.echo();
    foo3.echo();

    console.log(Foo.prototype.value);
})();