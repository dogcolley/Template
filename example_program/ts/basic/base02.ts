//interface Type같은 것이지만 좀더 넓은 의미로 그형태를가지게 하는 제약과같다

interface Users {
    name: string;
    readonly height: number;
    favoriteLanguage?: string;
  }
  const author: Users = { name: '안희종', height: 176 }; // ok


interface Counter {
    (start:number) : string;
    interval: number;
    reset(): void;
}  

function getCounter():Counter{
    let counter = <Counter>function (start:number){

    }
    counter.interval = 124;
    counter.reset = function (){}
    return counter;
}

let c = getCounter();
c(10);
c.reset;
c.interval = 5.0;

interface MyRsponse<data>{
    data: data;
    status: number;
    ok: boolean
}
interface UserIN {
    name : string;
    readonly height: number;
} 

//사용 예시
//const users: MyRsponse<UserIN> = await getUserApiCall (userId);


//확장 인터페이스
interface UserIn {
    name: string;
    readonly height: number;
    favoriteLanguage?: string;
  }

interface LoggedInUser extends UserIn {
  loggedInAt: Date;
}

interface ElectricDevice {
    voltage: number;
}

interface SquareShape{
    width: number;
    height: number;
}

interface Laptop extends ElectricDevice , SquareShape{
    color: string
}

const macbook15: Laptop = {voltage:20,width:15,height:4,color:'glod'}


//class 문법
class NotingImportant {}
const notingImportant: NotingImportant = new NotingImportant()

class Dog{
    constructor(){
        console.log('constructing!!');
    }
}
const dog: Dog = new Dog();

class dogfood {
    constructor (dogSay: string){
        console.log(`${dogSay} !!!`)
    }
} 

const colley0326 :dogfood = new dogfood('개소리');

class Triagle{
    
    vertices : number;
    readonly vertices2 : number = 5;
    constructor(){
        this.vertices = 2;
    }

}

const triagle : Triagle = new Triagle();
console.log(triagle.vertices, '//', triagle.vertices2);
triagle.vertices = 5;
console.log(triagle.vertices, '//', triagle.vertices2);


class Login{
    
    userName : string = 'guest';

    set user($Name){
        this.userName = $Name;
    }

    get user(){
        return this.userName;
    }

    userNameConsole(){
        console.log(`유저의 이름은 ${this.userName}`);
    }

}

const jsh:Login = new Login();
jsh.userNameConsole();
jsh.user = '장석환';
jsh.userNameConsole();

//확장 클래스
class FiledJoin extends Login {
    
    GoFiled(){
        if(this.userName = 'guest'){
            console.log('로그인 하지 않은 유저는 입장 할수 없습니다.');
        }else{
            console.log(`${this.userName}님 필드에 입장합니다.`);
        }
    }

}

const jsh2:FiledJoin = new FiledJoin();
jsh2.userNameConsole();
jsh2.GoFiled();
jsh2.user = "뽕삐리뿡뿡";
jsh2.GoFiled();