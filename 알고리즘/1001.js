process.stdin.setEncoding('utf8');
var input;
process.stdin.on('readable', function() {
    input = process.stdin.read();

    if (input !== null) {
       var arr = input.split(' '),
         a = parseInt(arr[0]),
         b = parseInt(arr[1]);

       console.log(a-b);
    }
});