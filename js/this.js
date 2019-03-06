// error
function() {
    this.name = 'test';
}

/////////////////
// 1 simple call

// test test
function fn() {
    this.name = 'test';
}
fn();
console.log(name, this.name);


/////////////////
// as a method

// test
var obj = {
    fn: function() {
        this.name = 'test';
    }
};
obj.fn();
console.log(obj.name);


/////////////////
// new

// test test test
function fn() {
    this.name = 'test';
}
var r = new fn(); // equal to var r = new fn;
// created new obj which become new this
// implicitly returns this
// setup prototype
console.log(name, this.name, r.name);

// function prototype (ES5)
function Person(nickname, email, born) {
    // this = {}

    this.nickname = nickname;
    this.email = email;
    this.born = born;

    // not optimal. Will copied into each person object
    //this.age = function() {
    //    var now = new Date();
    //    return now.getFullYear() - this.born;
    //}

    // return this;
}
Person.prototype.age = function() {
    var now = new Date();
    return now.getFullYear() - this.born;
}
var person = new Person('demmonico', 'demmonico@gmail.com', 1984);
console.log(person, person.age());
// 35
/**
 born: 1984
 email: "demmonico@gmail.com"
 nickname: "demmonico"
 __proto__:
 age: ƒ ()
 constructor: ƒ Person(nickname, email, born)
 __proto__: Object
 */

// same in ES6
class PersonClass
{
    constructor(nickname, email, born) {
        this.nickname = nickname;
        this.email = email;
        this.born = born;
    }

    age() {
        var now = new Date();
        return now.getFullYear() - this.born;
    }
}
var personFromClass = new PersonClass('demmonico', 'demmonico@gmail.com', 1984);
console.log(personFromClass, personFromClass.age());
// 35
/**
 born: 1984
 email: "demmonico@gmail.com"
 nickname: "demmonico"
 __proto__:
 age: ƒ age()
 constructor: class PersonClass
 __proto__: Object
 */