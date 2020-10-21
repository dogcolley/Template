//maker function
function Vehicle(name, speed) {
    this.name = name;
    this.speed = speed;
}

//maker prototype
Vehicle.prototype.drive = function () {
    console.log(this.name + ' runs at ' + this.speed)
};

//maker Sedan
function Sedan(name, speed, maxSpeed) {
    Vehicle.apply(this, arguments)
    this.maxSpeed = maxSpeed;
}

//extend
Sedan.prototype = Object.create(Vehicle.prototype); // Vehicle을 Extend로 가져오는부분
Sedan.prototype.constructor = Sedan; // 생성자를 다시 Vehicle => Sedan으로 넘기는부분
Sedan.prototype.boost = function () {
  console.log(this.name + ' boosts its speed at ' + this.maxSpeed);
};

//maker prototype  Sedan 엔 방영이 되지만 Vehicle엔 방영되지 않는다.
Sedan.prototype.drive = function () {
    console.log(this.name + ' runs at ' + this.speed + ': rewirte bung bung');
};

const tico = new Vehicle('tico', 50);
tico.drive(); // 'tico runs at 50'


var sonata = new Sedan('sonata', 100, 200);
sonata.drive(); // 'sonata runs at 100'
sonata.boost(); // 'sonata boosts its speed at 200'


function Truck(name, speed, capacity) {
    Vehicle.apply(this, arguments);
    this.capacity = capacity;
}
Truck.prototype = Object.create(Vehicle.prototype);
Truck.prototype.constructor = Truck;
Truck.prototype.load = function (weight) {
if (weight > this.capacity) {
    return console.error('아이고 무거워!');
}
return console.log('짐을 실었습니다!');
};
var boongboong = new Truck('boongboong', 40, 100);
boongboong.drive(); // 'boongboong runs at 40'
boongboong.load(120); // '아이고 무거워!'
   