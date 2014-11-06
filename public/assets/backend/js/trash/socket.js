/**
 * WebSocket client.
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @extends jQuery, (jQuery Mobile)
 * @since Browsers Support:
 *  - Internet Explorer 8+
 *  - Mozilla Firefox 3.6+
 *  - Opera 10.5+
 *  - Safari 4+
 *  - iPhone Safari
 *  - Android Web Browser
 */
if(typeof(WebSocket) != "function") 
    alert('Your browser does not support HTML5 Web Sockets');
else
{
    // do the connection setup
    
    /**
     * SocketCommand = function(controller, action, parameters)
     * @param {type} controller
     * @param {type} action
     * @param {type} parameters
     * @returns {SocketCommand}
     */
    var SocketCommand = function(controller, action, parameters) {
	this.controller = controller;
	this.action = action;
	this.parameters = parameters || [];

	this.getParam = function(name, def) {
		if (typeof(this.parameters[name]) != 'undefined') {
			return this.parameters[name];
		} else {
			if (typeof(def) == 'undefined') {
				def = null;
			}

			return def;
		}
	}
    }

    var SocketClient = function(host, port, action) {
	this.host = host;
	this.port = port;
	this.action = action;
	this.socket = null;
	this.open = false;
	this.callbacks = {};

	this.init = function() {
		this.callbacks['onopen'] = [];
		this.callbacks['onclose'] = [];
		this.callbacks['onerror'] = [];
		this.callbacks['onmessage'] = [];
                
		this.socket = new WebSocket(this.host + ':' + this.port + this.action);

		var self = this;

		this.socket.onopen = function(event) {
                        console.log(event);
			console.log('Open: "' + event + '"');
			self.onSocketOpen.apply(self, [event]);
		}

		this.socket.onclose = function(event) {
                        console.log(event);
			console.log('Close: "' + event + '"');
			self.onSocketClose.apply(self, [event]);
		}

		this.socket.onerror = function(event) {
                        console.log(event);
			console.log('Error: "' + event + '"');
			self.onSocketError.apply(self, [event]);
		}

		this.socket.onmessage = function(message) {
                        console.log(event);
			console.log('Message: "' + message + '"');
			self.onSocketMessage.apply(self, [message]);
		}
	}

	this.addEventListener = function(type, callback) {
		this.callbacks[type].push(callback);
	}

	this.onSocketOpen = function(event) {
		this.open = true;

		for (var key in this.callbacks['onopen']) {
			if (this.callbacks['onopen'][key].apply(this.callbacks['onopen'][key], [this, event]) === false) {
				return;
			}
		}
	}

	this.onSocketClose = function(event) {
		this.open = false;

		for (var key in this.callbacks['onclose']) {
			if (this.callbacks['onclose'][key].apply(this.callbacks['onclose'][key], [this, event]) === false) {
				return;
			}
		}
	}

	this.onSocketError = function(event) {
		for (var key in this.callbacks['onerror']) {
			if (this.callbacks['onerror'][key].apply(this.callbacks['onerror'][key], [this, event]) === false) {
				return;
			}
		}
	}

	this.onSocketMessage = function(message) {
		for (var key in this.callbacks['onmessage']) {
			if (this.callbacks['onmessage'][key].apply(this.callbacks['onmessage'][key], [this, message]) === false) {
				return;
			}
		}
	}

	this.send = function(command) {
		if (!this.open) {
			throw 'Unable to send command, socket is not open';
		}

		var data = {
			controller: command.controller,
			action: command.action,
			parameters: command.parameters
		};

		var encoded = this.encode(data);

		this.socket.send(encoded);
	}

	this.encode = function(data) {
		return data;
	}

	this.init();
}

var User = function(id, color, name) {
	this.id = id;
	this.color = color;
	this.name = name || null;
}

var Connect = function(host, port, action) {
	this.socket = null;

	this.init = function() {
		this.socket = new SocketClient(host, port, action);
                
		var self = this;

		this.socket.addEventListener('onopen', function(socket, event) {
			self.onSocketOpen.apply(self, [socket, event]);
		});

		this.socket.addEventListener('onclose', function(socket, event) {
			self.onSocketClose.apply(self, [socket, event]);
		});

		this.socket.addEventListener('onerror', function(socket, event) {
			self.onSocketError.apply(self, [socket, event]);
		});

		this.socket.addEventListener('onmessage', function(socket, message) {
			self.onSocketMessage.apply(self, [socket, message]);
		});

		this.socket.encode = function(data) {
			return $.JSON.encode(data);
		}
	}

	this.setName = function(name) {
		this.name = name;

		this.socket.send(new SocketCommand('server', 'set-name', {name: name}));
	}

	this.onSocketOpen = function(socket, event) {
		$('#status').slideUp();
		$('#name-container').slideDown();

		this.socket.send(new SocketCommand('server', 'hello'));
	}

	this.onSocketClose = function(socket, event) {
		this.showError('Connection lost');
	}

	this.onSocketError = function(socket, event) {
		this.showError('Error occured');
	}

	this.onSocketMessage = function(socket, message) {
		var data = message.data.replace(/\0/, '').replace(/\255/, '');
		var request = $.parseJSON(data);

		if (typeof(request.action) == 'undefined') {
			throw 'Unable to handle message, no action given';
		}

		var actionName = request.action;

		do {
			var dashPos = actionName.indexOf('-');

			if (dashPos == -1) {
				break;
			}

			actionName = actionName.substr(0, dashPos) + actionName.substr(dashPos + 1, 1).toUpperCase() + actionName.substr(dashPos + 2);
		} while (true);

		actionName = actionName + 'Action';

		if (typeof(this[actionName]) != 'function') {
			throw 'Unsupported action "' + actionName + '" called';
		}

		var command = new SocketCommand(request.controller, request.action, request.parameters);

		this[actionName](command);
	}


	this.userConnectingAction = function(command) {
		//var userId = command.getParam('id');
	}

	this.restoreAction = function(command) {
		var lines = command.getParam('lines');

		for (var key in lines) {
			var line = lines[key];

			this.renderStrokeLine(line.color, line.x1, line.y1, line.x2, line.y2);
		}
	}

	this.userConnectedAction = function(command) {
		var userId = command.getParam('id');
		var color = command.getParam('color');
		var user = new User(userId, color);

		this.users[userId] = user;

		this.renderNewUser(user);
	}


	this.showError = function(message) {
		$('#top-container').fadeOut();
		$('#name-container').hide();
		$('#status').html(message).show();;
		$('#login-form').fadeIn();
	}

}    
}