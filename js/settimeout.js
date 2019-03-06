// echo all 10 times "10" in a 5 sec
for (var i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, 5000);
}

// echo 10 times "10" with each delay in a 2 sec
for (var i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, i * 2000);
}

// echo all 10 iterations in a 5 sec
for (let i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, 5000);
}

////////
// fixed
// echo each iteration with delay in a 2 sec

// ES6
for (let i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, i * 2000);
}

// ES5 + closure
for (var i=0; i<10; i++){
    setTimeout((function(i) {
        return function () {
            console.log(i);
        }
    })(i), i * 2000);
}

// ES5 + closure
for (var i=0; i<10; i++){
    (function(i) {
        setTimeout(function() {
            console.log(i)
        }, i * 2000);
    })(i);
}

// ES5 + bind
for (var i=0; i<10; i++){
    setTimeout((function(i) {
        console.log(i);
    }).bind(null, i), i * 2000);
}
