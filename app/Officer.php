<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
		'current_task_start' => 'datetime',
		'current_task_end' => 'datetime',
	];

	protected $ranks = [
		'Cadet, grade I',
		'Cadet, grade II',
		'Cadet, grade III',
		'Ensign, junior grade',
		'Ensign, grade I',
		'Ensign, grade II',
		'Ensign, grade III',
		'Ensign, grade IV',
		'Ensign, grade V',
		'Lieutenant, junior grade',
		'Lieutenant, grade I',
		'Lieutenant, grade II',
		'Lieutenant, grade III',
		'Lieutenant, grade IV',
		'Lieutenant, grade V',
		'Lieutenant commander, grade I',
		'Lieutenant commander, grade II',
		'Lieutenant commander, grade III',
		'Lieutenant commander, grade IV',
		'Lieutenant commander, grade V',
		'Commander, grade I',
		'Commander, grade II',
		'Commander, grade III',
		'Commander, grade IV',
		'Commander, grade V',
		'Captain, grade I',
		'Captain, grade II',
		'Captain, grade III',
		'Captain, grade IV',
		'Captain, grade V',
	];

    public function getUser()
    {
        return $this->belongsTo('App\User')->get();
    }

	protected function getRankEntry()
	{
		$rank_index = min($this->level, count($this->ranks)) - 1;
		return $this->ranks[$rank_index];
	}

	public function getFullRank()
	{
		return $this->getRankEntry();
	}

	public function getRankGrade()
	{
		return ucfirst(explode(', ', $this->getRankEntry())[1])	;
	}

	public function getRank()
	{
		return explode(', ', $this->getRankEntry())[0];
	}

	public function getBranch()
	{
		return $this->branch;
	}

	public function getBranchClass()
	{
		switch ($this->getBranch()) {

			case 'command':
				return 'danger';
			case 'operations':
				return 'warning';
			case 'science':
				return 'primary';
		}
	}

	public function getName()
	{
		return $this->getRank() . ' ' . $this->name;
	}

	public function getImage()
	{
		return 'images/officers/' . $this->image . ".png";
	}

	public function getCurrentTask()
	{
		$task = $this->belongsTo('App\Task', 'current_task')->get()->first();
		if ($task === null) return null;

		$task->start_time = $this->current_task_start;
		$task->finish_time = $this->current_task_end;
		return $task;
	}

	public function startTask(\App\Task $task)
	{
		if (!is_null($this->current_task)) {
			throw new \Exception("Officer is already assigned to task ID: " . $this->current_task);
		}

		$this->current_task = $task->id;
		$this->current_task_start = new \DateTime();
		$this->current_task_end = $this->current_task_start->add(\DateInterval::createFromDateString($task->duration . ' seconds'));
		$this->save();

		return $this;
	}

	public function getXPPercentage()
	{
		return ($this->xp / $this->getXPToNextLevel()) * 100;
	}

	public function getXPToNextLevel()
	{
		return ($this->level * 100) * 1.67;
	}

}
