const _proto = Object.create(null);

_proto.getValue = function(key){
    return this[key];
}

const obj = Object.create(_proto);
obj.a = 1;
console.log(obj.getValue('a')); 
console.log(obj); 