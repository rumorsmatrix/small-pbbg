

    </main>


    <script src="vendor/jquery-3.4.1.min.js"></script>
    <script src="vendor/popper.min.js"></script>
    <script src="vendor/bootstrap-4.4.1.min.js"></script>
    <script src="js/Timers.js"></script>
	<script>

		let app = {};
		app.timers = new TimerManager();

		let new_timer = new Timer((new Date()), 20);

		new_timer.onTickCallback = function() {
			// console.log(this.uuid);
		};

		app.timers.addTimer(new_timer);

	</script>
</body>
</html>
