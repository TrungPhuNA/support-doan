// import Echo from "laravel-echo";
import Pusher from 'pusher-js';

var Notification = {
	init : function ()
	{
		this.usePusher();
	},
	usePusher()
	{
		// Pusher.logToConsole = true;

		var pusher = new Pusher('3c7ca79cb22c745bee4b', {
			encrypted: true,
			cluster: "ap1"
		});

		var channel = pusher.subscribe('NotificationRegisterEvent');
		channel.bind('send-message', function(data) {
			console.log(data)
			$('body').attr('data-name', data)
		});
	}
}

export default Notification;