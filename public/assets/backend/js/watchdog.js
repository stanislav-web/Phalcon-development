function Watchdog(user, socket) {
	this.user = user;
	this.flag = this.LOGIN;
	this.timer = {
		start : this.getDateTime(),
		end : 0
	};
}

Watchdog.prototype.addHandlers = function(socket) {
	var watchdog = this;
	socket.on('watchdog_sleep', function(data) {
		watchdog.user.setSocketSleep(this.id, true);
		global.cl.log('@@@@@@@@@@@@@@@@@@@@-socket_sleep');
		if (watchdog.user.checkAllSocketsSleep() && watchdog.user.checkFree()) {
			global.cl.log('%%%%%%%%%%%%%%%%%%%%-All_Sleep');
			if (watchdog.timer['start'].length > 0) {
				global.cl.log('************************-Start_time > 0');
				watchdog.timer['end'] = watchdog.getDateTime();
				watchdog.saveTime();
			}
		}
	});

	socket.on('watchdog_wakeup', function(data){
		global.cl.log('$$$$$$$$$$$$$$$$$$$$$$$$-watchdog_wakeup');
		watchdog.user.setSocketSleep(this.id, false);
		watchdog.timer.start = watchdog.getDateTime();
	});
};

Watchdog.prototype.saveTime = function() {
	var watchdog = this;
	global.connection.query(
		"INSERT INTO `watchdog_timer` " +
		" SET `user_id` = ?, `start` = ?, `end` = ?, `flag` = ?",
		[this.user.id, this.timer.start, this.timer.end, this.flag],
		function(err, result) {
			if (err) {
				global.cl.log('While watchdog log was saveing, an error occurred!!!');
				global.cl.log(err);
			} else {
				global.cl.log('&&&&&&&&&&&&&watchdog log was saveing successful.');
			}
			watchdog.setDefault();
		});
};

Watchdog.prototype.setDefault = function() {
	this.timer.start = 0;
	this.timer.end = 0;
	this.flag = this.DEFAULT;
};

Watchdog.prototype.getDateTime = function() {
	return new global.UtilFunc().getDateTime();
}

Watchdog.prototype.DEFAULT = 0;
Watchdog.prototype.LOGIN = 1;
Watchdog.prototype.LOGOUT = 2;


exports.Watchdog = Watchdog;