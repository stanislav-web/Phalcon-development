
// Подключаем конфиг
var config = require('./config');

// Подключаем модуль request
var request = require('request');

// Инициализируем сокет (для клиентской стороны)
var io = require('socket.io').listen(config.get('port'));

// Отключаем лишний вывод служебных логов
io.set('log level', 1);

// Подключаем модель watchdog
var watchdog_model = require('./modules/watchdog');

// Подключаем модуль node-mysql для доступа к б.д.
var mysql = require('mysql');

var connection = mysql.createConnection({
	host : config.get('mysql:host'),
	port: config.get('mysql:port'),
	database: config.get('mysql:database'),
	user : config.get('mysql:username'),
	password : config.get('mysql:password'),
	socketPath: config.get('mysql:socket_path')
});

// Подключаем модуль node-mysql для доступа к б.д.
var MongoClient = require('../node_modules/mongodb').MongoClient;
var format = require('util').format;

MongoClient.connect(config.get('mongodb:url'), function(err, db) {
	if(err) cl.log(err);
	global.mongoConnection = db;
});

//Create Our-selves console logger
var cl = new function() {
	this.log = function(message, required) {
		required = required || false;
		if (config.get("debug_mod") || required) {
			console.log(message);
		}
	};
};

//Set properties of Global-NodeJs-Var
global.connection = connection;
global.cl         = cl;

//Users mass
var users = {};

io.sockets.on('connection', function(socket) {

	var user;

	// Open new socket for user
	// 1. New element in users object
	// 2. Inserting into DB starting point
	socket.on('login', function(auth_user) {
		user = auth_user;
		if(users[user.id] == undefined) {
			watchdog_model[user.id] = new watchdog_model.Watchdog_model(user);
			users[user.id] = {
				id : user.id,
				sockets: {},
				state: 0,
				SIP: user.SIP,
				last_update : watchdog_model[user.id].get_date(),
				smokebreak : '0'
			};
			watchdog_model[user.id].start_timer(1);
		}
		if(users[user.id].sockets[socket.id] == undefined){
			users[user.id].sockets[socket.id] = 1;
		}
		users[user.id].last_update = watchdog_model[user.id].get_date();
		global.cl.log(users);
	});

	socket.on('update_time', function(){
		users[user.id].last_update = watchdog_model[user.id].get_date();
	});

	//Smokebreak On
	socket.on('smokebreak_on', function() {
		global.cl.log('smokebreak on' + socket.id);
		if(users[user.id].smokebreak = '0'){
			users[user.id].smokebreak = '1';
			watchdog_model[user.id].end_timer("smokebreak_on");
			watchdog_model[user.id].start_timer(2);
		}
	});

	//mokebreak Off
	socket.on('smokebreak_off', function() {
		global.cl.log('smokebreak of' + socket.id);
		if(users[user.id].smokebreak = '1'){
			users[user.id].smokebreak = '0';
			watchdog_model[user.id].end_timer("smokebreak_off");
			watchdog_model[user.id].start_timer(1);
		}
	});

	//Socket wakeup
	socket.on('watchdog_wakeup', function() {
		global.cl.log('watchdog_wakeup' + socket.id);
		if(users[user.id].smokebreak != '1'){
			watchdog_model[user.id].check_socket(users[user.id], 'up');
			/*if((watchdog_model[user.id].check_socket(users[user.id])) == '1'){
			 watchdog_model[user.id].start_timer(1);
			 }*/
		}
	});

	//Socket sleep
	socket.on('watchdog_sleep', function() {
		global.cl.log('watchdog_sleep ' + socket.id);
		if(users[user.id].smokebreak != '1'){
			watchdog_model[user.id].check_socket(users[user.id], 'end');
			/*if((watchdog_model[user.id].check_socket(users[user.id])) == '1'){
			 watchdog_model[user.id].end_timer("downtime");
			 }*/
		}
	});

	//logout
	socket.once('disconnect', function(){
		global.cl.log('disconnect socket: ' + socket.id);
		if(user){
			if(users[user.id].sockets != null){
				global.cl.log(users[user.id].sockets);
				if(users[user.id].sockets[socket.id] != undefined){
					//delete socket
					delete users[user.id].sockets[socket.id];

					setTimeout(function(){
							//if no any sockets, user logout
							var sockets = Object.keys(users[user.id].sockets).length;
							if(sockets < 1){
								global.cl.log('User logout!');
								watchdog_model[users[user.id].id].end_timer("logout");
								delete users[user.id];
							}},
						3000)
				}
			}
		}
		socket.disconnect();
	});

});

