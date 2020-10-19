const moduleA = require('./Module01');
const moduleB = require('./Module02');
const moduleC = require('./Module03');

console.log(moduleA);
moduleA.console2('test');
moduleA.console2(moduleA.sum(1,2));


console.log(moduleB);
moduleB.console3('test2');
moduleB.console3(moduleB.sum3(1,2));


const test = new moduleC();
console.log(moduleC);
console.log(test);
test.console4('??');
test.console4(test.sum4(1,1));
//moduleC.a.console4('test3');
