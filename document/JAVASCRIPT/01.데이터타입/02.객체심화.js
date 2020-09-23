/*
전시간에 할당을 중심으로 한 변수와 오브젝트로 확인해보는 매칭을 보았습니당.

이번시간엔 오브젝트를 좀더 딥하게 들어가서 불변성, 딥영역카피 , 로우영역카피, 언디파인드와 널의 관계등을 알아보겠당
*/

//불변 객체

//아래의 예제는 음 불변이 안되서 문제에유 참조를 시키면 참조시킨 값도 바껴버려요!
// VUE 의 THIS와 같쥬 훗..
var user = {
    name : 'jang',
    age : 26
}

var chageName = function (user,newName){
    var newUser = user;
    newUser.name = newName;
    return newUser;
}

var user2 = chageName(user,'dogfood');

if(user !== user2){
    console.log('유저의 이름이 변경되었습니다.')
}

console.log(user.name , user2.name);
console.log(user === user2);

//불변을 유지한 함수
var user = {
    name : 'jang',
    age : 26
}

var chageName = function (user,newName){
    return {
        name : newName,
        age : user.age
    }
}

var user2 = chageName(user,'dogfood');

if(user !== user2){
    console.log('유저의 이름이 변경되었습니다.')
}

console.log(user.name , user2.name);
console.log(user === user2);

//자 그럼 얕은 복사란? 이것입니다.
var copyObject = function (target){
    var result = {};
    for (var prop in target){
        result[prop] = target[prop];
    }
    return result
}

//자 활용
var user = {
    name : 'jang',
    age : 26
}

var user2 = copyObject(user);
user2.name = 'dogcolley';

if(user !== user2)
    console.log('유저 정보가 바뀌었습니다.');

console.log(user.name , user2.name);
console.log(user === user2);

//중첩된 객체에 대한 얕은 복사
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

var user2 = copyObject(user);

user2.name = 'dogcolley';
user2.skill.main1 = 'board';
user2.arr[0] = '0';
console.log(user.name === user2.name);
console.log(user === user2);
console.log(user.arr === user2.arr);


//자 깊은 복사를 보자
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

//자 다시 아까꺼 해보자
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


//오이오이 json 함수를 사용하면 간단히 복사할수 있다구

var copObjectViaJson = function (target){
    return JSON.parse(JSON.stringify(target));
}

var obj = {
    test : {
        test : {
            test : function(){console.log('2')}
        }
    }
}

var obj2 = copObjectViaJson(obj);
var obj1 = copyObjectDeep(obj);
obj.test.test.test();
obj1.test.test.test();
console.log(obj);
console.log(obj2);
console.log(obj1);
obj1.test.test =  {
    test : function(){
        console.log('3');
    }
}
obj.test.test.test();
obj1.test.test.test();

var n = null;
var u = [];

console.log(u);
console.log(u[2]);
console.log(typeof u[2]);
console.log(n);
console.log(typeof n);
//console.log(typeof n.test); 에러
//console.log(n.test); 에러

n = 2;
console.log(n);
n = null;
console.log(n);





