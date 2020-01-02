


console.time('시작');
var async = require('async');
let cnt = 0;

async.waterfall([
    function(callback) {
        while(cnt < 50000000){
            let c = '변수';
            const a = true;
            cnt++;
            if(a){
                //console.log('트루');
                c = '감자';
            }else{
                //console.log('펄스');
                c = '고구마';
            }   
        }
        callback(null);
    },
    function(callback) {
        console.timeEnd('시작')
        callback(null);
    },

], function (err, result) {
    if(err){
      console.log('Error 발생');
    }else {
      console.log('result : '+ result);
    }  // 4
});


    

