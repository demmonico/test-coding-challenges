function bind(cb, context) {
    return function() {
        return cb.apply(context, arguments);
    }
}

function fn(a, b) {
    console.log(a, b, this);
    return a + b;
}

var magicFn = bind(fn, {});

magicFn(2, 3);

// console.log 2,3,{}
// return 5
