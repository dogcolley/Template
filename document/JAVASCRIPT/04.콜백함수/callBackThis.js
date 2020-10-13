



function inner(){
    var a = 1;
    console.log(a) // 1
    function outer(){
        console.log(a); //1 scop 
        a = 2; 
    }
    outer();
    console.log(a); //1 scop 
}

inner();