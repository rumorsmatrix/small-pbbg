

    </main>


    <script src="vendor/jquery-3.4.1.min.js"></script>
    <script src="vendor/popper.min.js"></script>
    <script src="vendor/bootstrap-4.4.1.min.js"></script>
    <script src="vendor/simplewebsocket.min.js"></script>
    <script src="js/WSClient.js"></script>
    <script src="js/Timers.js"></script>
	<script>

		let app = {
			'client': new WSClient(),
			'timers': new TimerManager(),
		};

		let new_timer = new Timer((new Date()), 20);
		new_timer.onTickCallback = function() {
			// console.log(this.uuid);
		};

		app.timers.addTimer(new_timer);

		// add SPA AJAX links
        $(document).on('click', 'a', function(e) {
            e.preventDefault();

            if (e.target.dataset.target && e.target.attributes.href.textContent) {
                $('#' + e.target.dataset.target).load('ajax/' + e.target.attributes.href.textContent);
            }

            e.default();
        });



	</script>
</body>
</html>
