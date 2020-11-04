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

//Best Content: https://gist.github.com/jesstelford/9a35d20a2aa044df8bf241e00d7bc2d0

