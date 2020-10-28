/*
7장 Class

서론 : 자바스크릅트엔 class개념이 존재하지 않는다. (객체와 프로토타입만이 존재할뿐..)

*/


//7-1 스태틱 메서드, 프로토 타입 메서드

const Rectangle = function(w,h){
    this.width = w;
    this.height = h;
}

Rectangle.prototype.getArea = function(){
    return this.width * this.height  
}

//instanceof 는 생성자의 prototype 속성이 객체의 프로토타입이 존재하는지 확인하는 판별자
Rectangle.isRectangle = function (instance){
    return instance instanceof Rectangle && instance.width > 0 && instance.height > 0;
}

const react1 = new Rectangle(3,4);
console.log(react1.getArea());
//console.log(react1.isRectangle(react1)); //err Rectangle에 직접 상속하였으니 __proto__로는 상속되지 않는다.
console.log(Rectangle.isRectangle(react1));


//7-2,3 인스턴트 생성후 프로퍼티 삭제와 할당의 변화 관찰 인스턴트생성
const Grade = function (){
    const args = Array.prototype.slice.call(arguments);
    for(let i = 0; i < args.length;i++){
        this[i] = args[i];
    }
    this.length = args.length;
}

//7-2,3 생성후 이인스턴트를 삭제해보자
Grade.prototype = [];
const g = new Grade(100,80);
g.push(90);
console.log(g); // length : 3
delete g.length;
console.log(g); // length : x
g.push(70);
console.log(g); // length : 1 : 왜 1이 되는지 파악해야함 프로토타입이 빈배열을 가르키고있기 떄문이지

//7-2,3 생성후 이인스턴트를 삭제해보자
Grade.prototype = ['a','b','c','d'];
const g2 = new Grade(100,80);
g2.push(90);
console.log(g2); // length : 3
delete g2.length;
console.log(g2); // length : x
g2.push(70);
console.log(g2); // length : 5 : 5가되는 이유는 프로토 타입을 할당했기 떄문이지

//7-6,7 상속을 해볼까?  Square에 Rectangle를 상속해볼까?
const Square = function (w){
    Rectangle.call(this,w,w);
}

Square.prototype = new Rectangle();
delete Square.prototype.height; //이렇게하면 깔끔쓰 => 지나친 데이터 구조를 가진걸 안보이게 할 수 있음
delete Square.prototype.width; //이렇게하면 깔끔쓰 => 지나친 데이터 구조를 가진걸 안보이게 할 수 있음
Object.freeze(Square.prototype); // 고정하기!
const g3 = new Square(3); // 상속에 상속 ! 키야 

console.log(g3)
console.log(g3.__proto__);
console.log(g3.__proto__.__proto__);
console.log(g3.getArea());

//7-6,7 자금 클래스 상속과 추상적인 방법!
const extendClass1 = function (SuperClass,SubClass,subMethods){
    SubClass.prototype =  new SuperClass();
    for(let prop in  SubClass.prototype){
        if(SubClass.prototype.hasOwnProperty(prop)){
            delete SubClass.prototype[prop]; 
        }
    }
    if(subMethods){
        for(let method in subMethods){
            SubClass.prototype[method] = subMethods[method];
        }
    }
    Object.freeze(SubClass.prototype);
    return SubClass;
}

const Square2 = extendClass1(Rectangle,function(w){
    Rectangle.call(this,w,w);
});
const g4 = new Square2(5);

console.log(g4);
console.log(g4.__proto__);
console.log(g4.__proto__.__proto__);
console.log(g4.getArea());

//7-6,7 좀더 간단한 소스코드로 봐볼까?

const KoreaName = function(a,b){
    this.firstName = a;
    this.lastName = b;
}

KoreaName.prototype.sayName = function(){
    console.log('성은 : '+this.firstName+', 이름은 : '+this.lastName);
}

const AmericasName = function(a,b){
    KoreaName.call(this,b,a);
}

const SetName = function(){}

SetName.prototype = KoreaName.prototype;
AmericasName.prototype = new SetName();
Object.freeze(AmericasName);

const user1 = new AmericasName('Jackson','Kim');
const user2 = new KoreaName('장','석환');
const user3 = new SetName('장','석환'); //이친구는 내부 프로토 타입만 가지고있어서 변수 할당이 하나도 안되서 제대로 동작하지 않슴듕

console.log(user1);
console.log(user1.__proto__);
console.log(user1.__proto__.__proto__);
console.log(user1.sayName());

console.log(user2);
console.log(user2.__proto__);
console.log(user2.__proto__.__proto__);
console.log(user2.sayName());

console.log(user3);
console.log(user3.__proto__);
console.log(user3.__proto__.__proto__);
console.log(user3.sayName());


//7-9 위를 참고해서 빈 함수를 참고해서 사용하는걸 해보자! 그럼 delete해주는 과정이 필요 없겠찌!
const extendClass2 = (function(){
    const Bridge = function(){}
    return function(SuperClass,SubClass,subMethods){
        Bridge.prototype = SuperClass.prototype;
        SubClass.prototype = new Bridge();
        if(subMethods){
            for(let method in subMethods){
                SubClass.prototype[method] = subMethods[method];
            }
        }
        Object.freeze(Bridge);
        return SuperClass
    }
});

//7-10 Object.create를 활용하는 방법
const Square3 = function (w){
    Rectangle.call(this,w,w);
}
Square3.prototype = Object.create(Rectangle.prototype);
Object.freeze(Square3);

const g5 = new Square3(4);
console.log(g5);
console.log(g5.__proto__);
console.log(g5.__proto__.__proto__);
console.log(g5.getArea());

//7-11 constructor 복구하는 방법

const extendClass1 = function (SuperClass,SubClass,subMethods){
    SubClass.prototype =  new SuperClass();
    for(let prop in  SubClass.prototype){
        if(SubClass.prototype.hasOwnProperty(prop)){
            delete SubClass.prototype[prop]; 
        }
    }
    SubClass.prototype.consturctor = SubClass; // 7-11 constructor 복구하는 방법
    if(subMethods){
        for(let method in subMethods){
            SubClass.prototype[method] = subMethods[method];
        }
    }
    Object.freeze(SubClass.prototype);
    return SubClass;
}

const extendClass2_1 = (function(){
    const Bridge = function(){}
    return function(SuperClass,SubClass,subMethods){
        Bridge.prototype = SuperClass.prototype;
        SubClass.prototype = new Bridge(); 
        SubClass.prototype.consturctor = SubClass; // 7-11 constructor 복구하는 방법
        if(subMethods){
            for(let method in subMethods){
                SubClass.prototype[method] = subMethods[method];
            }
        }
        Object.freeze(Bridge);
        return SuperClass
    }
});


const extendClass3_1 = function (SuperClass,SubClass,subMethods){
    SubClass.prototype =  Object.create(SubClass.prototype);
    SubClass.prototype.consturctor = SubClass;  // 7-11 constructor 복구하는 방법
    if(subMethods){
        for(let method in subMethods){
            SubClass.prototype[method] = subMethods[method];
        }
    }
    Object.freeze(SubClass.prototype);
    return SubClass;
}

const extendClass = function (SuperClass,SubClass,subMethods){ //super를 감미한 상위 클래스 접근 방식
    SubClass.prototype =  Object.create(SubClass.prototype);
    SubClass.prototype.consturctor = SubClass;  // 7-11 constructor 복구하는 방법
    SubClass.prototype.super = function(propName){
        const self = this;
        if(!propName) return function(){
            SuperClass.apply(self,arguments);
        }
        const prop = SuperClass.prototype[propName];
        if(typeof prop !== 'Function')return prop;
        return function(){
            return prop.apply(self,prop);
        }
    }
    if(subMethods){
        for(let method in subMethods){
            SubClass.prototype[method] = subMethods[method];
        }
    }
    Object.freeze(SubClass.prototype);
    return SubClass;
};