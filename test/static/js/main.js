// usage:
// $ time ./fibonacci.js 40
// 0.  40 :  165580141
// 0.  40 :  165580141
// 5ms 3259ms
//
// real     0m3.310s
// user     0m3.301s
// system   0m0.017s
 
//fibonacci(40)
//fibonacci2(40)
 
function fibonacci(n) {
	var res;
	if (fibonacci.stack[n]) return fibonacci.stack[n];
	if (n < 2)
		res = 1;
	else
		res = fibonacci(n - 2) + fibonacci(n - 1);
 
	return (fibonacci.stack[n] = res);
}
fibonacci.stack = {};
 
function fibonacci2(n) {
	if (n < 2) return 1;
	return fibonacci2(n - 2) + fibonacci2(n - 1);
}
 
function  fibonacci3(n) {
	n = n || 1;
	var t = 1, i = 1, n1 = 0, n2 = 1;
	for (; i <= n; i++) {
		t = n2 + n1;
		n1 = n2;
		n2 = i < 2 ? 1 : t;
	}
	return t;
}
 
var ns = process.argv.slice(2);
 
var s1 = Date.now();
 
ns.forEach(function (n, i) {
	console.log(i + '. ', n, ': ', fibonacci(n));
});
 
var s2 = Date.now();
 
var t1 = s2 - s1;
 
ns.forEach(function (n, i) {
	console.log(i + '. ', n, ': ', fibonacci3(n));
});
 
var s3 = Date.now();
 
var t2 = s3 - s2;
 
ns.forEach(function (n, i) {
	console.log(i + '. ', n, ': ', fibonacci2(n));
});
 
var s4 = Date.now();
 
var t3 = s4 - s3;
 
console.log(t1 + 'ms', t2 + 'ms', t3 + 'ms');