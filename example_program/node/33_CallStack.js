// call tack = >  쌓인다.

function foo(){
    throw new Error('Opps');
}
function bar(){
    foo();
}

function baz(){
    bar();
}

//baz(); // Opps at foo at bar at baz 

//max stack 

function maxStack(){
    maxStack();
}

//maxStack(); //Maximum call tack size exceeded at maxStack

