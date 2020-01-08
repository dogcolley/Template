process.stdin.setEncoding('utf8');
const readline = require('readline');
const r = readline.createInterface({
  input:process.stdin,    
  output:process.stdout
});

let T = null;
let T_C = 0;
let answerData = new Array

r.setPrompt('>');
r.prompt();
r.on('line',function(answer){
    if(answer =='exit'){
        r.close();
    }
    if(T == null){
        const arr = answer.split(' ')
        T = parseInt(arr[0])
    }
    else if(T_C < T){
        let info = new Array;
        const arr = answer.split(' ')
        for(let i in arr){
          info.push(parseInt(arr[i]));
        } 
        answerData.push(algorithm(info));
        //console.log(algorithm(info));
        T_C++;
        if(T_C == T){
          for(let i in answerData){
            console.log(answerData[i]);
          }
          process.exit();
        }
    }
    r.prompt('>');  
});

r.on('close',function(){
    process.exit();
});

const algorithm = (arr) => {
  const x1 = arr[0];
  const y1 = arr[1];
  const r1 = arr[2];
  const x2 = arr[3];
  const y2 = arr[4];
  const r2 = arr[5];
  const i = Math.sqrt(Math.pow((x1 - x2), 2) + Math.pow((y1 - y2), 2));
  if(x1 == x2 && y1 == y2){
    if(r1 == r2)return -1
    else return 0 
  }else{
    if(i < (r1+r2) && i > (r1-r2) ) return 2;
    if(i == (r1+r2)) return 1;
    if(i > (r1+r2)) return 0;
  }
}