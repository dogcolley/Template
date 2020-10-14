const { time } = require("console");
const readline = require("readline");
const INPUT = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const Celsius = new Array(2);

let INPUTCOUNT = 0;
let INPUTACTION = true;

const CONSOLETEXT = new Array(
    '현재 온도를 셋팅해주세요!',
    '끓일 온도를 셋팅해주세요!'
);

const CheckNumber = (matchData) => {
    matchData = Number(matchData);
    if(isNaN(matchData)){
        console.log('입력값은 숫자로만 입력하셔야 합니다.');
        process.exit();
    }
    return matchData;
}

const bubblingC = (num)=>{
    return new Promise(function(resolve, reject){
        setTimeout( () => {
            //목표값을 설정하고 계산한다.
            num++; 
            console.log(num);
            resolve(num);
        }, timeMatch(num));
    });
}

const timeMatch = (num) =>{
    let time = 0;
    switch(true){
        case (num < 20) :
            time = 1000;
        break
        case (num < 50) :
            time = 500;
        break
        case (num < 70) :
            time = 300;
        break
        case (num < 100) :
            time = 100;
        break
    }
    return time;
}

const excessCheck = (num) =>{
    if(num > 120){
        console.log('STOP : Already reached');
        process.exit();
    }
} 


async function bubbling  (ResultNum,maxNum){
    //DATA DISPLAY
    console.log("NOW C' : ",ResultNum," // GOAL C' : ", maxNum);

    //RESULTE
    if(maxNum > 100){
        console.log(' RESULTE : BUBBLE ')
    }else{
        console.log(' RESULTE : DON"T BUBBLE')
    }
    
    //CHECK OVER CELSIUS
    excessCheck(ResultNum);

    //ACTION UP TO CELSIUS
    for(let i = ResultNum; i < maxNum; i++){
         await bubblingC(ResultNum).then(data=>{
            ResultNum = data;
            excessCheck(ResultNum);
        });
    }

    console.log('====END====');
    process.exit();
}

function produce (){
    console.log('작업이 끝나고 실행될 부분');
}

function count(setNum,maxNum) {
    let ResultNum = setNum;
    bubbling(ResultNum,maxNum);
}

console.log(CONSOLETEXT[INPUTCOUNT]);
INPUTCOUNT++;

INPUT.on("line", (line) => {
    Celsius[INPUTCOUNT-1] = CheckNumber(line);
    if(INPUTCOUNT >= Celsius.length && INPUTACTION){
        count(Celsius[0],Celsius[1]);
        INPUTACTION = false;
    }
    console.log(CONSOLETEXT[INPUTCOUNT]);
    INPUTCOUNT++
}).on("close", () => {
    process.exit();
})
