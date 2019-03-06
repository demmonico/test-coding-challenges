var obj = {
    a: 5,
    b: {
        b1: 10
    },
    d: 20
};
obj.__proto__ = {
    a: 10,
    b: {
        b1: 20,
        b2: 30
    },
    c: 40
};
console.log(obj);
/**
 a: 5
 b: {b1: 10}
 d: 20
 __proto__:
 a: 10
 b: {b1: 20, b2: 30}
 c: 40
 */


delete obj.a;
console.log(obj);
/**
 b: {b1: 10}
 d: 20
 __proto__:
 a: 10
 b: {b1: 20, b2: 30}
 c: 40
 */
console.log(obj.a);
// 10


delete obj.a;
console.log(obj.a);
// 10


delete obj.b;
console.log(obj.b);
// { b1: 20, b2: 30 }


delete obj.b.b1;
console.log(obj.b.b1);
// undefined

console.log(obj);
/**
 d: 20
 __proto__:
 a: 10
 b: {b2: 30}
 c: 40
 */
