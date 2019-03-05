// echo all 10 times "10" in a 5 sec
for (var i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, 5000);
}

// echo 10 times "10" with each delay in a 2 sec
for (var i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, i*2000);
}

// echo all 10 iterations in a 5 sec
for (let i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, 5000);
}

// echo each iteration with delay in a 2 sec
for (let i=0; i<10; i++){
    setTimeout(() => {console.log(i)}, i*2000);
}
