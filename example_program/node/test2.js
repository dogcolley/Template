let num = 0 ;
const test = {
    number : 0,
    set num (value){
        this.number = value;
    },
    get num (){
        this.number;
    }
}

const test2 = {
    number : 0,
    setNum (value){
        this.number = value;
    },
    getNum (){
        this.number;
    }
}

/*
console.time('timer');
num = 0;
while(num < 10000){
    test2.num = 1;  
    test2.num;
    num++;
}
console.timeEnd('timer');
*/
console.time('timer');

while(num < 10000){
    test.num = 1; 
    test.num;
    num++;
}
console.timeEnd('timer');


