
//화살표를 제외한 연산부호를 1개만 쓰면 비트연산이 됩니다.

1 & 2           // 01 10  = 0 
1 & undefined   // undefined
1 & null        // null
1 | 2          // 01 10 2
1 | undefined  // 1
1 | null       // 1
1 ^ 2           // 01 10 = 11 3
1 ^ 3           // 01 11 = 10 2
1 ^ 4           // 001 100 = 101 2 
~8 //~1000 =  0111 6 NOT
-8 // 0111 NEGATIVE
1 >> 1 // 0001 0000 0
1 << 1 // 0001 0010 2
5 >> 1 // 0101 0010 2  
5 << 1 // 0101 1010 10
13 >>> 1 // 1101 0110 6 

1 && 5 // 5 뒤에있는게 5
1 || 5 // 1 앞에있는게 1

//js는 0이 앞에붙인 숱자는 자동으로 16진수에서 10진수로 변경해줌
const FLAG_A = 1; // 0001
const FLAG_B = 2; // 0010
const FLAG_C = 4; // 0100
const FLAG_D = 8; // 1000

const trees = ["redwood", "bay", "cedar", "oak", "maple"];
0 in trees;        // returns true
3 in trees;        // returns true
6 in trees;        // returns false
"bay" in trees;    // returns false (you must specify the index number,


