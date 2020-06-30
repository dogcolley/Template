//변수선언

//블리언
const isTypeScriptAwesome : boolean = true;
const doesjavascriptHasTypes : boolean = false;

//숫자
const userScore : number = 100;
const ieee754IsAwesome : number = 0.1 + 0.2;

//널
const nullVlaue : null = null;
const undefinedValue : undefined = undefined;
//const numberVlaue : number = null; 이경우는 기본옶션인 strictNullChecks 옵션이 켜져있어야지 실행이가능하다.

//any, void, never : 어느것이나, 빈곳, 어떠한값도 없게
let bool:any = true;
bool = 3;
bool = 'test';
bool = {};

function nothing():void{}

function alwaysThrow(): never {
    throw new Error(`I'm a wicked function!`);    
}

//array tuplue : 함수도 마찬가지로 어떤 타입인지선언, 튜플의 경우엔 안에 혼종 허락
const pibonacci : number[] = [0,1,2,3,4,5,6,7,8];
const myFavoriteBeers: string[] = ['a','b','c'];
const nameAndHeight : [string,number] = ['이름',5];

//객체선언
const user : {name:string; height:number} = {name:'이름',height:5} 
const userWithUnknownHeight: {name: string; height?: number} = {name:'이름'}
const user2 : {
    readonly name : string;
    height: number;
} = { name:"변경불가능한이름",height:176}
//user2.name = '다른이름' 으로 할경우엔 에러가 발생한다.


//타입 별칭정의
type UUID = string;
type Height = number;
type AnotherUUID = UUID;
type User = {
    name : string;
    height: number;
}
function getUser(uuid:UUID){
    console.log(uuid);
}
getUser('test');

// 함수선언
function sum(a: number, b: number){
    return a + b;
}

function LogGreetings(name: string): void{ //return 이 없을떄 사용하는것은 void
    console.log(`hello, ${name}`);
}

function notReallyVoid():void{
    console.log(1);
    //if you use return ts comfile err
}


//화살표 변수 지정
const yetAnotherSum: (a:number,b:number) => number = sum;
const onePlusOne: () => number = () => 2;
const arrowSum: (a:number,b:number) => number = (a,b) => a+b;

//타입 지정
type SumFunction = (a:number, b:number) => number;
const definitelySum: SumFunction = ( a , b )=> a + b;

//선택 매개 : 이경우 선택 매개는 필수 매개 이후에 정의 해준다.
function fetcgVideo(url: string,  subtitleLanguage?: string ){
    const option:any =  {url};
    if(subtitleLanguage){
        option.subtitleLanguage = true;
    }    

    console.log(option);
}

//함수 오버로딩 : 여러쌍의 매개변수 반환 타입 쌍으로 갖는 경우 정의를 내려준다.

function doubleString(str:string): string{
    return `${str}, ${str}`;
}

function doubleNumber(num:number): number{
    return num * num;
}

function doubleBooleanArray(arr: boolean[]): boolean[]{
        return arr.concat(arr);
}

//위와같은 형태를 타입으로 정의해서 생략한다

function double(str: string): string;
function double(num:number): number;
function double(arr: boolean[]): boolean[];

function double(arg:any){
    if(typeof arg === 'string'){
        return `${arg}${arg}`;
    }else if(typeof arg === 'number'){
        return arg * 2;
    }else if(Array.isArray(arg)){
        return arg.concat(arg);
    }
}

//this. type
interface HTMLElement {
    tagName: string;
}

interface Handler { 
    (this: HTMLElement, event: Event, callback: () =>void):void;
}

let cd:any;

const onClick: Handler = function(event,cb){
    console.log(this.tagName);
    cb();
}

//제네릭
//: 규칙을 갖은 타입을 손쉽고 우아하..개?..??

//일반 동기 부여 소스코드
function getFristName(arr:string[]){
    if(!Array.isArray(arr)){
       throw new Error ('getFirstNameNull: Argument is not array'); 
    }
    if(arr.length === 0){
       throw new Error ('getFirstNameNull: Argument is not array'); 
    }
    return arr[0] ? arr[0] : null;
}

function GetFirstName(arr: string[]): string;
function GetFirstName(arr: number[]): number;
function GetFirstName(arr: any){
    if(!Array.isArray(arr)){
        throw new Error('없다고');
    }
    if(arr.length===0){
        throw new Error('없다고');
    } 
    return arr[0] ? arr[0] : null;
}
GetFirstName(['장']);




//console.log(LogGreetings('??'));
//console.log(sum(1,2));
//console.log(arrowSum(1,2))
//fetcgVideo('www.test.com');
//function echoTest():void{console.log('test');}

