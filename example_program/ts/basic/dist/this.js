//this의 개념을 모르는 멍청한 개밥이여..

var foo = function () {
    console.log(this);
}

foo();// Node Global;

var obj = {foo:foo};
obj.foo(); // object's foo

var instance = new foo();// instance
instance.a = 2;
console.log('this의 a늰?'+ instance.a);
console.log(instance);

var bar = {name:'bar'};
foo.call(bar); // foo 함수에
var bar = {name:'bar',age:26};
foo.apply(bar); // foo 함수에
foo.bind(bar)(); // foo 함수에
    
var obj2 = {foo:foo} // 바인및 영향 x 
obj.foo();

function range(){
    this.value = 2;
    console.log(this) // global
    console.log(this.value);
    function range2(){
        this.value = 4;
        console.log(this) // global
        console.log(this.value);
    }
    range2();
}

range();

