var app = require('express')();
var http = require('http').Server(app);
var service = require('socket.io')(http);
var port = 3000 || process.env.PORT;

app.get('/', function(req, res){
	res.sendFile(__dirname + '/index.html');
})

service.on('connection', function(socket){
	socket.on('message from client', function(msg){
		service.emit('message for client', msg);
	})
})

http.listen(port, function(){
	console.log('start listener port: ' + port);
})