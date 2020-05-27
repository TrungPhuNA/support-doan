@if (app()->environment() !== 'local')
	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
	<script>
		var OneSignal = window.OneSignal || [];
		OneSignal.push(function() {
			OneSignal.init({
				appId: "beacdd92-0645-433e-b412-72004ad25462",
			});
		});
	</script>
@endif