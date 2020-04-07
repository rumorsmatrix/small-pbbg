class TimerManager {

	constructor()
	{
		this.timers = {};
		this.interval = false;

		this.startInterval();
	}

	startInterval()
	{
		this.interval = setInterval(() => { this.onTick(); } , 100);
	}

	stopInterval()
	{
		clearInterval(this.interval);
	}

	addTimer(timer)
	{
		this.timers[timer.uuid] = timer;
		return this;
	}

	removeTimer(timer)
	{
		delete this.timers[timer.uuid];
		return this;
	}

	onTick()
	{
		Object.keys(this.timers).forEach((uuid) => this.timers[uuid].onTick());
	}

}


class Timer {

	constructor(start_time, duration)
	{
		this.uuid = this.generateUUID();
		this.setStartTime(start_time);
		this.setDuration(duration);
		this.onTickCallback = {};
		this.onCompleteCallback = {};
	}

	generateUUID()
	{
		return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c => (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16));
	}

	getUUID()
	{
		return this.uuid;
	}

	setStartTime(parameter)
	{
		this.start_time = ((typeof parameter  === 'object' && parameter.constructor.name === 'Date')
			? parameter
			: new Date(parameter)
		);
	}

	setDuration(seconds)
	{
		this.end_time = new Date(this.start_time.getTime() + (seconds * 1000));
	}

	getDuration()
	{
		return (this.end_time.getTime() - this.start_time.getTime());
	}

	getRemainingDuration()
	{
		return this.end_time.getTime() - (new Date).getTime();
	}

	onTick()
	{
		return ((typeof this.onTickCallback === 'function')
			? this.onTickCallback()
			: true
		);
	}

	onComplete()
	{
		return ((typeof this.onCompleteCallback === 'function')
			? this.onCompleteCallback()
			: true
		);
	}

}
