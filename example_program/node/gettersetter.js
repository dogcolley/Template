
//참조 : https://velog.io/@bigbrothershin/JavaScript-%EC%A0%91%EA%B7%BC%EC%9E%90-%ED%94%84%EB%A1%9C%ED%8D%BC%ED%8B%B0-getter-setter
//01. 겟터와 셋터를 한꺼번에 

const user = {
    name: "John",
    surname: "Smith",
  
    get fullName() {
        // getter, user.fullName 실행할 때 실행되는 코드
        return `${this.name} ${this.surname}`;
    },
    set fullName(value) {
        // setter, user.fullName = value를 실행할 때 실행되는 코드
        [this.name, this.surname] = value.split(" ");
    }
};

console.log(user.fullName); // John Smith
console.log(user.name); // John
console.log(user.surname); // Smith
user.fullName = '나는 개밥'
console.log(user.fullName); // 나는 개밥
console.log(user.name); // 나는
console.log(user.surname); // 개밥
console.log(user);

//02.접근자 프로퍼티 설명자 

/*
get – 인수가 없는 함수로, 프로퍼티를 읽을 때 동작함
set – 인수가 하나인 함수로, 프로퍼티에 값을 쓸 때 호출됨
enumerable – 데이터 프로퍼티와 동일함
configurable – 데이터 프로퍼티와 동일함
*/

//겟터셋터를 셋팅해주는 obj 내장함수 Object.defineProperty(obj, prop, descriptor)
user.himent = '방가워!!';
Object.defineProperty(user, 'sayHellow', {
get() {
    return `${this.name} ${this.surname} ${this.himent}`;
},

set(value) {
    this.himent = value;
}
});

console.log(user.sayHellow);
user.sayHellow = '만나서반갑구먼!';
console.log(user.sayHellow);
  
for(let key in user) console.log(key); // name, surname


//데이터를 설정해주는 디파인 프로퍼티 Object.defineProperty(obj, prop, descriptor)
const object1 = {};

Object.defineProperty(object1, 'property1', {
  value: 42,
  writable: false
});

object1.property1 = 77; // throws an error in strict mode

console.log(object1.property1); // expected output: 42

