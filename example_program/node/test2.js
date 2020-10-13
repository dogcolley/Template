const readline = require("readline");
const INPUT = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const Celsius = new Array(2);

let INPUTCOUNT = 0;
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

const count = (setNum,maxNum) => {
    let ResultNum = setNum;
    for (ResultNum; ResultNum < maxNum; ResultNum += 1) { // 나도 내장함수다.
        const NowC = ResultNum;
        setTimeout(()=>{ 
            switch(NowC){
                case 20 :
                    console.log('NOT HOT');
                break;
                case 40 :
                    console.log('NORMAL');
                break;
                case 50 :
                    console.log('SO HOT');
                break;
                case 80 :
                    console.log('HOT');
                break;
                                
            }
            // 여기 무엇인가 넘버링 만큼의 코드가 시간에 맞춰 실행된다.
        }, 100);
    }
    //ResultNum 여기엔 for문이 끝난 결과값이 도출이 되므로 그 결과값이 돌출된 코드를 실행할수있다.
    if(ResultNum > 100){
        console.log('물이 무조건 끓게될것입니다.')
    }else{
        console.log('물이 끓지 않습니다.')
    }
}

console.log(CONSOLETEXT[INPUTCOUNT]);
INPUTCOUNT++;

INPUT.on("line", (line) => {
    
    Celsius[INPUTCOUNT-1] = CheckNumber(line);
    if(INPUTCOUNT >= Celsius.length){
        console.log(Celsius);
        count(Celsius[0],Celsius[1])
        process.exit();
    }
    console.log(CONSOLETEXT[INPUTCOUNT]);
    INPUTCOUNT++
}).on("close", () => {
    process.exit();
})





