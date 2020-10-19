class Rectangle {
    constructor(height, width) {
      this.height = height;
      this.width = width;
      this.num = 1;
    }
    // Getter
    get area() {
      return this.calcArea();
    }
    // Method
    calcArea() {
      return this.height * this.width * this.num;
    }

    add(value) {
        this.num = value;
    }

}

class Rectangle2 extends Rectangle{
    set add(value) {
        this.zindex = value
    }

}

const square = new Rectangle(10, 10);

console.log(square.area); // 100
square.add(5) // this.num = 5; 
console.log(square.area); // 500



class GetterSetterClass{

    constructor(num){
        this.normal = num;
        this.big = num * 2 ;
        this.small = num / 2 ;
    }
    
    set baseSetting(value){
        this.big   = value * 2;
        this.small = value / 2;
    }

    echo(){
        console.log(this.small);
        console.log(this.normal);
        console.log(this.big);
    }
}


const test = new GetterSetterClass(1);
console.dir(test);
test.echo();


const user = {
    get name() {
      return this._name;
    },
  
    set name(value) {
      if (value.length < 4) {
        console.log("입력하신 값이 너무 짧습니다. 네 글자 이상으로 구성된 이름을 입력하세요.");
        return;
      }
      this._name = value;
    }
};

user.name = "Pete";
console.log(user);
console.log(user.name);