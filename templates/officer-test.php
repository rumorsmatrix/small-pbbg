<?php

$user = $this->user;

$officers = $user->getOfficers();

foreach ($officers as $officer) {
	$task = $officer->getCurrentTask();

	echo "<li>";
	echo $officer->getName();
	echo ": ";
	echo ($task) ? $task->name : 'unassigned';
	echo "</li>";
}



$picant = App\Officer::find(1);
$new_task = App\Task::find(1);



$picant->startTask($new_task);
