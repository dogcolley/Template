class Psrson{
    private name : string

    constructor(name : string){
        this.name = name;
    }

    sayHello(){
        return "hello," + this.name;        
    }
    
}

const person = new Psrson('Lee');

console.log(person.sayHello());