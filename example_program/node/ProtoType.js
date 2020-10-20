function Person(){}

Person.prototype.test =1;
Person.prototype.getType = function (){  
    return "인간"; 
};

var joon = new Person();  
var jisoo = new Person();  

console.log(joon.test);
console.log(jisoo.test);


Person.prototype.test =2;

console.log(joon.test);
console.log(jisoo.test);

console.log('======================================');

console.log(joon.getType());   // 인간  
console.log(jisoo.getType());  // 인간  

function Person(name) {  
    this.name = name || "혁준"; 
}

Person.prototype.getName = function(){  
    return this.name;
};

function Korean(name){}  
Korean.prototype = new Person();

var kor1 = new Korean();  
console.log(kor1.getName());  // 혁준

var kor2 = new Korean("지수");  
console.log(kor2.getName());  // 혁준  

console.log('======================================');

function Person(name) {  
    this.name = name || "혁준";
}

Person.prototype.getName = function(){  
    return this.name;
};

function Korean(name){  
    Person.apply(this, arguments);
}

var kor1 = new Korean("지수");  
var kor2 = new Korean("지수2");  
console.log(kor1.name);  // 지수  
console.log(kor2.name);  // 지수  

console.log('======================================');
function Person(name) {  
    this.name = name || "혁준"; }

Person.prototype.getName = function(){  
    return this.name;
};

function Korean(name){  
    Person.apply(this, arguments);
}
Korean.prototype = new Person();

var kor1 = new Korean("지수");  
console.log(kor1.getName());  // 지수  

console.log('======================================');

function Person(name) {  
    this.name = name || "혁준";
}

Person.prototype.getName = function(){  
    return this.name;
};

function Korean(name){  
    this.name = name;
}    
Korean.prototype = Person.prototype;

var kor1 = new Korean("지수2");  
console.log(kor1.getName());  // 지수  

console.log('======================================');
var person = {  
    type : "인간",
    getType : function(){
        return this.type;
    },
    getName : function(){
        return this.name;
    }
};

var joon = Object.create(person);  
joon.name = "혁준";

console.log(joon.getType());  // 인간  
console.log(joon.getName());  // 혁준  