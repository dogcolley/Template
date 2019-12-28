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

