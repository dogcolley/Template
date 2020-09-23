# JAVASCRIPT 수집

## [정리한 저장소](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT) [dogcolley's Template]

### 목차 
1. [데이터타입](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/01.데이터타입)

2. [실행컨텍스트](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/02.실행컨텍스트)

3. [This](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/03.This)

4. [콜백함수](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/04.콜백함수)

5. [클로저](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/05.클로저)

6. [프로토타입](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/06.프로토타입)

7. [클래스](https://github.com/dogcolley/Template/tree/master/document/JAVASCRIPT/07.클래스)


<br>
<br>
<br>
<br>


# 데이터타입

> **서술**
:스크릅트 언어들은 다양한 목적에 비슷한시기에 많은언어가 형성 되어 있다. 이중 웹 서버스크립트로 사옹중인 JAVA,C(ASP,PHP)계열,파이썬,JAVASCIPT등이 있다. 그래도 어느정도 언어의 특성만 파악하면 모두 비슷한 원리와 개념으로 돌아가기에 이번기회에 하나만 깊게 파서 공부해보자

<br>

----------
<br>

### 기본형의 종류 (Primitive Type)
> 값을 담은 주소값을 복사한다.

```
var a = 1
var b = '1'
var c = true
var d = null
var e 

```
----------
<br>

### 참조형변수의 종류 (Reference Type)
> 값을 담긴 묶음을 가르키는 주소값을 복제한다.

```
var obj = new Object();
function a () {}
var obj2 = new a();
var date = new Date();
var arr = new Array();
var RexExps =  test.RexExp();

```
----------
<br>

### 변수선언 과정 

<br>
1.변수할당

```
var a;  

```

2.데이터 할당

```
a = 'abc'; 
```

3.변수와 데이터를 동시에 할당

```
var a = 'abc' 
```
----------
<br>

### 참조형변수의 종류 (Reference Type)
> 할당이 되는 과정을 표로 확인해봅시다!

```
var a = 1
var b = {
    c : 1,
    d : 2,
}
```

| 1003 | 1004 | 1005 |
|---|:---:|---:|
| 이름 : a , 값은 5005|이름 : b, 값은 5005||
                  
| 5002 | 5005 | 5007 |
|---|:---:|---:|
|1|@7103~|2|

| 7103 | 7104 | 7105 |
|---|:---:|---:|
|@5002|@5007||

----------
<br>

### 객체의 가변성
> 아래의 코드를 보면 코드를 복사시 
같은 주소를 바라보는 두 오브젝트의 값은 변경해도 서로 영향을 미친다.

```
var user = {
     name : 'Jaenam',
     gender: 'male'
}

var chageName = function(user,newName){
     var newUser = user;
     newUser.name = newName;
     return newUser;
}

var user2 = chageName(user,'Jang');

if(user !== user2)
    console.log('유저 정보가 바뀌었습니다.'); // 동작하지않음

console.log(user.name, user2.name); //jang , jang
console.log(user.name === user); // ture;

```
----------
<br>

### 
> 가변성 해결을 위한 얕은 복사
```
var copyObject = function (target){
    var result = {};
    for (var prop in target){
        result[prop] = target[prop];
    }
    return result
}

var user = {
    name : 'jang',
    age : 26
}

var user2 = copyObject(user);
user2.name = 'dogcolley';

if(user !== user2)
    console.log('유저 정보가 바뀌었습니다.');

console.log(user.name , user2.name); // jang, dogcolley
console.log(user === user2); // false

```
----------
<br>

### 깊은 복사 
> 복제한 오브젝트들 또한 새롭게 생성해줍니다!
```
var copyObjectDeep = function (target){
    var result = {};
    if(typeof target === 'object' && target !== null){
        for(var prop in target){
            result[prop] = copyObjectDeep(target[prop]);
        }
    }else{
        result = target;
    }
    return result;
}

var user = {
    name : 'jang',
    skill : {
        main1 : 'html',
        main2 : 'js',
        main3 : 'css',
        sub1 : 'php',
        sub2 : 'sql',
        sub3 : 'apache'
    },
    arr : ['1','2','3']
}

var user2 = copyObjectDeep(user);

user2.name = 'dogcolley';
user2.skill.main1 = 'board';
user2.arr[0] = '0';
console.log(user.name === user2.name);
console.log(user === user2);
console.log(user.arr === user2.arr);

```
----------

