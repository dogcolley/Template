/*

출처 : 보고 배우자 https://medium.com/@pks2974/javascript%EC%99%80-iterator-cdee90b11c0f

Iterable

iterable은 객체의 맴버를 반복할 수 있는 객체이다.

Javascript 에서 객체가 iterable 하기 위해서는, object 에는 [@@iterator] 메소드가 구현되어 있어야 한다.
Javascript 에서는 object property 에 Symbol.iterator 를 추가해야 한다.
> obj[Symbol.iterator]
객체는 반드시 하나의 Symbol.iterator 만을 가질수 있다.
for of 를 이용해서 iterator의 값을 반복할 수 있다.

*/

const iterable = new Object();

iterable[Symbol.iterator] = function* () {
  yield 1;
  yield 2;
  yield 3;
};

console.log([...iterable]); // 1 2 3
for(var value of iterable) {
    console.log(value); // 1 2 3
}

/*
iterator 은 객체를 next 메서드로 순환 할 수 있는 객체다.
iterator는 next() 메소드를 가지고 있고, next 메소드는 아래의 규칙에 따라 구현되어야 한다.
1.next 메소드는 arguments 가 없다.
2.next 메소드의 반환자는 done: boolean 과 value: any 를 포함하는 object 를 반환해야 한다.
3.next 메소드의 반복이 끝날때 done 은 true 를 반환해야 한다.

*/

const iterator = '12'[Symbol.iterator]();
iterator.next(); // {value: "1", done: false}
iterator.next(); // {value: "2", done: false}
iterator.next(); // {value: undefined, done: true}

/*
Iterator2
*/

const obj = {};
const counter = (count) => (
    (i = 0) => ({
        next: () => (
            (i++ < count) ?
            { value: i, done: false } :
            { value: 0, done: true }
        )
    })
);
obj[Symbol.iterator] = counter(5);
console.log([...obj]) // [1, 2, 3]

/*
Iterator3
>객체를 반환하는 함수
*/

var arr = ['1', '2', '3'];
console.log([...arr.entries()]);
// [[0, "1"], [1, "2"], [2, "3"]];
console.log([...arr.keys()]);
// [0, 1, 2];
console.log([...arr.values()]);
// ["1", "2", "3"];

var map = new Map([[1, '1'],[2, '2'],[3, '3']])
console.log(map.entries());
// MapIterator {1 => "1", 2 => "2", 3 => "3"}
console.log(map.keys());
// MapIterator {1, 2, 3}
console.log(map.values());
// MapIterator {"1", "2", "3"}

var set = new Set([1, 2, 3]);
console.log(set.entries());
// SetIterator {1, 2, 3}
console.log(set.keys());
// SetIterator {1, 2, 3}
console.log(set.values());
// SetIterator {1, 2, 3}

var string = '1,2,3';
console.log([...string.matchAll(/[\d+]/g)]); // RegExpStringIterator
// [
// ["1", index: 0, input: "1,2,3", groups: undefined],
// ["2", index: 2, input: "1,2,3", groups: undefined],
// ["3", index: 4, input: "1,2,3", groups: undefined]
// ]

/*
결론
Javascript 에서 iterable 과 iterator 는 어떻게 구분할 수 있는가?
Object가 @@iterator 를 가지고 있다면, iterable 이다.
Object에서 next 메서드가 값을 반복하면서, {done, value} 를 반환한다면, iterator 이다.
그러므로, Javascript에서 generator object 는 규칙에 맞는 next 메서드를 가지고 있기 때문에, iterator이고, Object는 @@iterator 를 가지기 때문에 iterable 이다.
*/


/*
Generator function
Javascript에서 iterator 를 쉽게 구현할 수 있는 방법으로 generator 객체 가 있다.
그리고 이 generator 객체를 생성하는 방법은 GeneratorFunction 과 function* 이 있다.
GeneratorFuction은 global object 가 아니기 때문에, Object.getPrototypeOf 으로 정의 해야 한다.
*/

var GeneratorFunction = Object.getPrototypeOf(function*(){}).constructor
var g = new GeneratorFunction("a", "yield a * 2");
var iterator = g(10);
console.log(iterator.next().value); // 20


/*
Spread 
>Spread 문법을 이용하면 iterable 객체를 해체 할 수 있다.
*/
var text = '123';
console.log([...text]);
// ["1", "2", "3"]