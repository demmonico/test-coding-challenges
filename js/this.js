// error
function() {
    this.name = 'test';
}


// test test
function fn() {
    this.name = 'test';
}
fn();
console.log(name, this.name);


// test
var obj = {
    fn: function() {
        this.name = 'test';
    }
};
obj.fn();
console.log(obj.name);


// test test test
function fn() {
    this.name = 'test';
}
var r = new fn(); // equal to var r = new fn;
// created new obj which became new this
// returned just created object
// setup prototype
console.log(name, this.name, r.name);
