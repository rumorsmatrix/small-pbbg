<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Traveller
 *
 * @package App
 *
 * @property string $name
 *
 * @property Branch $branch
 * @property int $rank
 * @property int $terms_of_service
 *
 * @property int $strength
 * @property int $dexterity
 * @property int $endurance
 * @property int $intelligence
 * @property int $education
 * @property int $social_standing
 *
 * @property array $skills
 *
 */
class Traveller extends Model {

	protected $casts = [
		'skills' => 'array',
	];

	protected $dates = [
		'created_at',
		'updated_at',
	];

	public function create()
	{
		$this->skills = [];
		$this->rollCharacteristics();

		$branch_objects = [
			new EngineeringBranch(),
		];

		$branches = [];
		foreach ($branch_objects as $branch) $branches[$branch::name] = $branch;

		// pick a branch to attempt, using characteristics vs. bonuses
		$attempted_branch = $branches['Engineering'];

		// attempt enlistment
		if ($this->attemptEnlistment($attempted_branch)) {
			$this->branch = $attempted_branch;
			$eligible_for_commission = true;

		} else {
			echo "Failed to enlist, drafted instead!\n";

			// roll for draft...
			$this->branch = $attempted_branch;
			$eligible_for_commission = false;
		}

		// begin career!
		echo "Beginning a career in " . $this->branch::name . "\n";
		$this->terms_of_service = 0;
		$this->rank = 0;

		// start first term of service, this will recurse into future terms
		$this->attemptTermOfService($eligible_for_commission);

		// washed out (or died)
		echo "\nFinished career\n";

		// assign mustering-out rewards
		$rewards = $this->terms_of_service;
		if ($this->rank === 1 || $this->rank === 2) $rewards += 1;
		if ($this->rank === 4 || $this->rank === 2) $rewards += 2;
		if ($this->rank >= 5) $rewards += 3;

		for ($i = 0; $i < $rewards; $i++) {
			$this->gainMusteringOutReward($this->branch);
		}

		return $this;
	}


	/**
	 * @return $this
	 */
	private function rollCharacteristics()
	{
		foreach (['strength', 'dexterity', 'endurance', 'intelligence', 'education', 'social_standing'] as $characteristic) {
			$this->{$characteristic} = rand(1, 6) + rand(1, 6);
		}
		return $this;
	}


	private function attemptEnlistment(Branch $branch)
	{
		$enlistment_bonus = $branch->getRollBonus($this, $branch::enlistment);
		$roll = rand(1, 6) + rand(1, 6) + $enlistment_bonus;
		return ($roll >= $branch::enlistment['roll_needed']);
	}

	private function attemptTermOfService($eligible_for_commission = true)
	{
		echo "\nStarting a new term of service...\n";

		// roll for survival
		if (!$this->attemptTermSurvival($this->branch)) {
			echo "Died in service!\n";
			return $this;
		}

		// start a new term
		$this->terms_of_service++;
		$skills_to_roll = 0;

		// attempt commission
		if ($this->rank === 0 && $eligible_for_commission) {
			if ($this->attemptTermCommission($this->branch)) {
				echo "Achieved commission!\n";
				$this->rank = 1;
				$skills_to_roll++;
			}
		}

		// attempt promotion
		if ($this->rank > 0 && $this->attemptTermPromotion($this->branch)) {
			$this->rank++;
			$skills_to_roll++;
			echo "Awarded promotion, now rank " . $this->rank . "!\n";
		}

		// determine skills
		$skills_to_roll = (($this->terms_of_service === 1) ? $skills_to_roll + 2 : $skills_to_roll + 1);
		for ($i = 0; $i < $skills_to_roll; $i++) {
			$skill_table = $this->pickSkillTable($this->branch);
			$this->learnSkill($skill_table);
		}

		// determine aging effects
		if ($this->terms_of_service > 4) { /* ... */ }

		// roll for re-enlistment
		if ((rand(0, 6) + rand(0, 6) === 12) || ($this->terms_of_service < 7 && $this->attemptReenlistment($this->branch))) {
			$this->attemptTermOfService($eligible_for_commission);
		}

		return $this;
	}

	private function attemptTermSurvival(Branch $branch)
	{
		$survival_bonus = $branch->getRollBonus($this, $branch::survival);
		$roll = rand(1, 6) + rand(1, 6) + $survival_bonus;
		return ($roll >= $branch::survival['roll_needed']);
	}

	private function attemptTermCommission(Branch $branch)
	{
		$commission_bonus = $branch->getRollBonus($this, $branch::commission);
		$roll = rand(1, 6) + rand(1, 6) + $commission_bonus;
		return ($roll >= $branch::commission['roll_needed']);
	}

	private function attemptTermPromotion(Branch $branch)
	{
		$promotion_bonus = $branch->getRollBonus($this, $branch::promotion);
		$roll = rand(1, 6) + rand(1, 6) + $promotion_bonus;
		return ($roll >= $branch::promotion['roll_needed']);
	}

	private function attemptReenlistment(Branch $branch)
	{
		return (rand(1, 6) + rand(1, 6)) >= $branch::reenlistment['roll_needed'];
	}

	private function pickSkillTable(Branch $branch)
	{
		$skill_tables = (($this->education >= 8) ? ['advanced_education'] : []);

		// get which table to roll on
		if ($this->terms_of_service >= 2) {
			$skill_tables += ['personal', 'service', 'service'];
		} else {
			$skill_tables += ['personal', 'personal', 'service'];
		}

		return $branch::skills[$skill_tables[rand(0, count($skill_tables)-1)]];
	}

	private function learnSkill($skill_table)
	{
		$skill = $skill_table[rand(0, count($skill_table)-1)];
		if (!$skill) return;

		if ($this->{$skill}) {
			// it's a characteristic
			$this->{$skill}++;

		} else {
			// it's a skill
			$skills = $this->skills;

			if (isset($skills[$skill])) {
				$skills[$skill]++;
			} else {
				$skills[$skill] = 1;
			}

			$this->skills = $skills;
		}

		echo "Gained a rank in " . $skill . "!\n";
	}

	public function getSkills()
	{
		return $this->skills;
	}

	private function gainMusteringOutReward(Branch $branch)
	{
		$this->learnSkill($branch::mustering_out_benefits);
	}

	public function getBranchAttribute($branch)
	{
		return (new $branch);
	}

}



class Branch {
	const name = '';
	const enlistment = [];
	const survival = [];
	const commission = [];
	const promotion = [];
	const skills = [];
	const reenlistment = [];
	const mustering_out_benefits = [];

	public function __toString()
	{
		return get_class($this);
	}

	public static function getRollBonus(Traveller $traveller, $type)
	{
		$roll_bonus = 0;
		foreach ($type['bonuses'] as $bonus => $requirement) {
			if ($traveller->{$requirement['characteristic']} >= $requirement['required']) {
				$roll_bonus += $bonus; // bonuses are cumulative
			}
		}

		return $roll_bonus;
	}

}


class EngineeringBranch extends Branch {

	const name = "Engineering";
	const enlistment = [
		'roll_needed' => 8,
		'bonuses' => [
			1 => ['characteristic' => 'intelligence', 'required' => 8],
			2 => ['characteristic' => 'education', 'required' => 9],
		],
	];
	const survival = [
		'roll_needed' => 5,
		'bonuses' => [
			2 => ['characteristic' => 'intelligence', 'required' => 7],
		]
	];
	const commission = [
		'roll_needed' => 10,
		'bonuses' => [
			1 => ['characteristic' => 'social', 'required' => 9],
		]
	];
	const promotion = [
		'roll_needed' => 8,
		'bonuses' => [
			1 => ['characteristic' => 'education', 'required' => 8],
		]
	];
	const reenlistment = [
		'roll_needed' => 6,
	];
	const skills = [
		'personal' => [
			'strength',
			'dexterity',
			'endurance',
			'intelligence',
			'education',
			'social_standing',
		],
		'service' => [
			'Vacc Suit',
			'Vacc Suit',
			'Mechanical',
			'Mechanical',
			'Electronics',
			'Electronics',
			'Engineering',
			'Engineering',
			'Engineering',
			'Computing',
			'Leadership'
		],
		'advanced_education' => [
			'Medical',
			'Engineering',
			'Computing',
			'Administration',
			'Leadership',
			'Mechanical'
		],
	];
	const mustering_out_benefits = [
		'intelligence',
		'Education',
		'social_standing',
		'Engineering',
		'Computing',
		null,
		null,
		null,
		null,
	];

}


