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

    var test = 1;
    console.log(test);
    const a = () =>{
        this.test = 2;
        console.log('화살표의 a this',this);
        console.log(this.test);
        var test2 = 2;
        this.test2 = 2;
        const b = () =>{
            console.log('화살표의 b this',this);
        }
        b();
        
        function c (){
            console.log('그냥함수 C this',this);
        }
        c();

    }
    a();
}

//range();

class testB {

    constructor(){
        this.a =1; 
    }

    test (){
        console.log('class 의 this는',this);
        thisConsole();
        thisConsole2();
    }

}

function thisConsole (){
    console.log('나는 최상위 this를 호출한다',this)
}

const thisConsole2 = () =>{
    console.log('나는 나 자신을 this를 호출한다.',this);
}
const tests = new testB();
tests.test();


console.log('node의 this는',this);