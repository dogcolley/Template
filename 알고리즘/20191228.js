//알고리즘 
/*

문제
10,000 이하의 자연수로 이루어진 길이 N짜리 수열이 주어진다.
이 수열에서 연속된 수들의 부분합 중에 그 합이 S 이상이 되는 것 중,
가장 짧은 것의 길이를 구하는 프로그램을 작성하시오.

입력
첫째 줄에 N (10 ≤ N < 100,000)과 S (0 < S ≤ 100,000,000)가 주어진다.
둘째 줄에는 수열이 주어진다. 수열의 각 원소는 공백으로
 구분되어져 있으며, 10,000이하의 자연수이다.

*/
const readline = require("readline");
let SumNum;
let ArrayLength;
let Arrays;

ArrayLength = 10;
SumNum = 15;
Arrays = '5 1 3 5 10 7 4 9 2 8';


const LangJudge = ( ArrayLength , SumNum , Arrays) => {
    Numbers = Arrays.split(' ');
    for(let i in Numbers){
        Numbers[i] = Number(Numbers[i]);
    }
    let setNum = 0;
    Numbers.reduce( function (acc,cur,idx,src) { 
       if(acc + cur +src[idx-1] >= SumNum){
        if(setNum == 0)setNum = cur;
        else if(setNum > cur)setNum = cur; 
       }    
       return cur;
    });
    console.log(setNum);
}
LangJudge(ArrayLength , SumNum , Arrays);


/*
console.log(`
10,000 이하의 자연수로 이루어진 길이 N짜리 수열이 주어진다.
이 수열에서 연속된 수들의 부분합 중에 그 합이 S 이상이 되는 것 중,
가장 짧은 것의 길이를 구하는 프로그램을 작성하시오.
`);

const rl1 = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});



rl1.on("line", function(line) {
  console.log(SumNum);
  console.log(ArrayLength);
  console.log(Arrays);  
  if(SumNum === undefined)SumNum = line;
  else if(ArrayLength === undefined)ArrayLength = line;
  else if(Arrays === undefined)Arrays = line;
  else{
    console.log("시작함");

  }
}).on("close", function() {
  process.exit();
});
*/
  
