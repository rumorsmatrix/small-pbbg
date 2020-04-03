<?php

namespace App\Controllers\Api;

class Officer extends \App\Controllers\Controller {

	public function officer($office_id = null)
	{
		$officer = $this->getOfficer();
		if (!$officer) return ['errors' => ["No matching officer found."]];

		$officer->display_name = $officer->getName();
		$officer->full_rank = $officer->getFullRank();
		$officer->rank_grade = $officer->getRankGrade();
		$officer->short_rank = $officer->getRank();
		$officer->branch_class = $officer->getBranchClass();
		$officer->xp_to_next = $officer->getXPToNextLevel();

		if ($officer->current_task) {
			$officer->current_task = $officer->getCurrentTask()->toArray();
		}

		return $officer->toArray();
	}


	public function currentTask($officer_id = null)
	{
		$officer = $this->getOfficer($officer_id);
		if (!$officer) return ['errors' => ["No matching officer found."]];

		$task = $officer->getCurrentTask();

		if ($task) {
			$result = $task->toArray();
		} else {
			$result = [];
		}

		return $result;
	}


	protected function getOfficer($officer_id = null)
	{
		if (is_null($officer_id)) $officer_id = $this->route_parameters['officer_id'];

		$officer = (new \App\Officer)
			->where('id', $officer_id)
			->where('user_id', $this->user->id)
			->first();

		return $officer;
	}


}
