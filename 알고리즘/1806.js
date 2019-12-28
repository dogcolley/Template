//process.stdin.setEncoding('utf8');

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


const readline = require('readline');
let set_N = null;
let set_S = null;
let set_lines = new Array;

const algorit = (set_N, set_S, set_lines) =>{
    let MinNumber = 0;
    let counter = 1;
    let sum = 0;
    for(let i in set_lines){
        sum += set_lines[i]; 
        for (let j =0 ;j < (set_lines.length - i); j++){
            sum += set_lines[parseInt(i) + parseInt(j) + 1];
            counter++;
            if(sum >= set_S && (MinNumber > counter || MinNumber == 0)){
                MinNumber = counter;
                counter = 1;
                sum = 0;
                break;
            }
        }
    }

    return MinNumber;
}

const r = readline.createInterface({
    input:process.stdin,    
    output:process.stdout
});

r.setPrompt('>');
r.prompt();
r.on('line',function(answer){
    if(answer =='exit'){
        r.close();
    }
    if(set_N == null){
        const arr = answer.split(' ')
        set_N = parseInt(arr[0]),
        set_S = parseInt(arr[1]);
    }
    else if(set_lines.length == 0){
        const arr = answer.split(' ');
        for(let i in arr){
            set_lines.push(parseInt(arr[i]));
        } 
        console.log(algorit(set_N, set_S, set_lines));
    }
    r.prompt('>');  
});

r.on('close',function(){
    process.exit();
});

