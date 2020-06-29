"use strict";
class Psrson {
    constructor(name) {
        this.name = name;
    }
    sayHello() {
        return "hello," + this.name;
    }
}
const person = new Psrson('Lee');
console.log(person.sayHello());
