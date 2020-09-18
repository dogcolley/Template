

var num = num1 = 3;

//console.log(num);
//console.log(num1);
//console.log(num1 === num);
num = 2;
//console.log(num);
//console.log(num1);
//console.log(num1 === num);
num1 = 2;
//console.log(num);
//console.log(num1);
//console.log(num1 === num);


var ob1 = {
    a : 1
}


var ob2 = {
    a : 1
}

//console.log('ob1',ob1);
//console.log('ob2',ob2);
//console.log('ob1과 ob2의 a는 같다',ob1.a === ob1.a);
//console.log('ob1과 ob2는 다른 주소의 객체이다.',ob1 === ob2);



    var test= 1;

    function a (){
        console.log('a함수',this); //node GLOBAL이 찍힘
    }
    //a();

    const b = function(){
        console.log('b함수',this); //node GLOBAL이 찍힘
    }
    //b();

    const c = () =>{
        this.test = 3;
        console.log('c함수',this);
    }
    c();

    const classD = class{
        constructor() {}
        test = () => {
            console.log('d Class test1',this);
        }

        test2 (){
            console.log('d Class test2',this)
        }

    }

    const classF = class{
        constructor() {
            this.var_1 = '1'
            this.var_2 = '2'
        }

        test (){
            console.log('d Class test2',this)
        }

        test2 (){
            console.log('d Class test3',this)
        }

    }

    const testing_1 = new Object({
        test : a,
        test2 : b,
        test3 : c,
    })

    const testing_2 = new classD();
    const testing_3 = new classF();

    //testing_1.test;
    //testing_1.test2;
    //testing_1.test3;
    testing_2.test();
    testing_2.test2();
    testing_3.test();
    //console.log(testing_2.test)