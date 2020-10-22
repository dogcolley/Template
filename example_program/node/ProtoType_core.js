/*
ProtoType

서론 : JS는 프로토 타입 기반언어! 어떤객체를 복사! 클래스 기반의 상속과 비슷함!

이구간을 통과 해야지 진정한 JS를 깨달을수 있다!

*/

/*
01 프로토 타입의 이해!

서론 : var instance = new Constructor(); 

Constructor * protortype
    ㅡㅡㅡㅡ 
    :    .
    :   .
new :  . 
    : .
    :.
    ▼

instance.__proto__

※꿀팁
: es5에서 __proto__ 가 아니라 [[prototype]] 으로 명칭됨
__proto__는 원래 브라우저에서 못해야했는데 대부분 브라우저가 사용합니다. ㅠㅠ
원래는 Object.getPrototypeof(instance) / Refelect.getProtypeOf(instance) 통해 적근해야합니다.
Object.getPrototypeOf() / Object.create() 를 권장합니다.

우리는 간단한 학습을 위해 __proto__ 를 사용합니다! 
*/

console.log('===========01.프로토타입의 이해==========');
const Person = function(name){
    this._name = name;
}

Person.prototype.getName = function(){
    return this._name;
}

Person.prototype.thisHow = function(){
    console.log(this);
}

const suzi = new Person('Suzi');
//왜 그럼 suzi는 undefined를 출력을 하는걸까?
suzi.thisHow(); // 아 수지라는걸 바라보는게 아니라 Person을 바라보고 있구나!
console.log(suzi.getName()); //나는 잘찾는다!;
console.log(suzi.__proto__.getName()); //둘다 undefined;
console.log(suzi.__proto__ === Person.prototype ); // 둘은 상속과 같은 같은 프로토 타입을 바라보고 있습니다.
//JS는 찾고자하는 식별자가 없을경우 undefind를 출력합니당!
suzi.__proto__._name = "Suzi__proto"; // 프로토타입은 직접 이렇게 넣으면 됩니다!
console.log(suzi.__proto__.getName());  // Person의 값에 접근해서 바꿔준거야!
const suzi2 = new Person('Suzi');
console.log(suzi2.__proto__.getName()); // 그러니깐 Person을 새로상속한 suzi2도 Suzi__proto 지!
//__proto__를 넣으면 무조건 상속해준 프로토 좌표를 바라본다. 생략두 가능하다~

const Constructor = function(name){
    this.name = name;
}

Constructor.prototype.mothod1 = function (){}
Constructor.prototype.propety1 = 'Cunstructor Prototype Property';

const instance = new Constructor('Instance');
console.dir(Constructor); //이친구한테는 prototype이 들어가유
console.dir(instance); //이친구의 __proto__는 Constructor가 들어가즁

const arr = [1,2];
console.dir(arr); // 나는 Array의 prototype의 값을 __proto__해유!
console.dir(Array); // 나는 원본이지! 내가 최고야 하하하
Array.isArray(arr);
arr.forEach((e)=>{console.log(e)})
//arr.isArray // err!

//constructor 프로포티란 자기자신을 가르키는 내부 프로포티!
console.log(Array.prototype.constructor === Array); // 맞아!
console.log(arr.__proto__.constructor === Array); // 맞아!
console.log(arr.constructor === Array); // 맞아!

const arr2 = new arr.constructor(3,4);
console.dir(arr2); // 나는 Array의 prototype의 값을 __proto__해유!

/*
자그럼 배열의 프로토타입의 구조를 확인하자!

            from()
            inArray()
            of()
            arguments
            length
            name
    Array-- prototype --- push
    :      .
    :    .
new :  .
    :.   (__proto__)
    ▼
  [1,2]
  
*/


//자그럼 이제 컨스터럭쳐를 바꿔볼까!?
const newConstructor = function () {
    console.log('this is new Constructor!');
}

const dataTypes = [
    1,
    'test',
    true,
    {},
    [],
    function(){},
    /test/,
    new Number(),
    new String(),
    new Boolean(),
    new Array(),
    new Function(),
    new RegExp(),
    new Date(),
    new Error(),
];

dataTypes.forEach(function(d){
    d.constructor = newConstructor;
    console.log(d.constructor.name,"&", d instanceof newConstructor)
});

//다양한 컨스럭쳐 접근법

const aseConstructor = function(name){
    this.name = name;
}

const p1 = new aseConstructor('접근1');
const p1Porto = Object.getPrototypeOf(p1);
const p2 = new aseConstructor.prototype.constructor('접근2');
const p3 = new p1Porto.constructor('접근1_1');
const p4 = new p1.__proto__.constructor('접근1_2');
const p5 = new p1.constructor('접근1_3');


console.log(p1Porto);
console.log(p1);
console.log(p2);
console.log(p3);
console.log(p4);
console.log(p5);


//자 arr를 찾아 올라가면 obejct를 찾을수있다구!
arr.push(3); // arr.__proto__.psuh()
console.log(arr.hasOwnProperty(2)); // arr.__proto__.__proto__.hasOwnProperty()
console.log(Array.prototype.toString.call(arr));
console.log(Object.prototype.toString.call(arr));

arr.toString = function(){
    return this.join('_');
}
console.log(Array.prototype.toString.call(arr));
console.log(arr.toString());

console.log('===========01. 끝  =====================');
