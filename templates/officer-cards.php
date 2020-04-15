
<div class="row">

<?php

$user = $this->user;
$officers = $user->getOfficers();

foreach ($officers as $officer) {
	$task = $officer->getCurrentTask();

?>
	<div class="col-lg-4 col-md-6">
		<div class="card shadow-lg mb-4">

			<h5 class="card-header">
				<span class="fancy"><?=$officer->getName()?></span>
				<br>
				<small class="text-muted">
					<span class="badge badge-<?=$officer->getBranchClass()?>"><?=$officer->getBranch()?></span>
					<span class="badge badge-secondary">level <?=$officer->level?></span>
				</small>
			</h5>

			<ul class="list-group list-group-flush">
 				<li class="list-group-item">

					<div class="media">
						<img class="mr-3" src="<?=$officer->getImage()?>" alt="">
						<div class="media-body">

							<div class="progress mb-1 mt-2">
								<div id="officer_xp_bar_<?=$officer->id?>"class="progress-bar progress-bar-striped bg-<?=$officer->getBranchClass()?>" role="progressbar" style="width: <?=$officer->getXPPercentage()?>%;"></div>
							</div>

							<small><?=($officer->getXPToNextLevel() - $officer->xp)?> XP to next level</small>
						</div>
					</div>

 				</li>
 				<li id="officer_task_<?=$officer->id?>" class="list-group-item mt-2 border-bottom-0">

					<?php if ($task) { ?>

						<h6 class="card-text">
							<?=$task->name?>
						</h6>

						<div class="progress mb-1 ">
							<div id="officer_task_progress_<?=$officer->id?>" class="progress-bar progress-bar-striped progress-bar-animated bg-<?=$officer->getBranchClass()?>" role="progressbar" style="width: <?=$officer->getXPPercentage()?>%;"></div>
						</div>

						<p class="text-right text-muted"><small>
							6 seconds remaining
						</small></p>

					<?php } else { ?>

					 	<h6 class="text-muted">No duties assigned</h6>

					<?php } ?>

				</li>
			</ul>

			<div class="card-footer text-right">
				<?php if ($task) { ?>
					<a href="#" class="btn btn-<?=$officer->getBranchClass()?>">Cancel</a>
				<?php } else { ?>
					<a href="#" class="btn btn-<?=$officer->getBranchClass()?>">Assign duty</a>
				<?php } ?>
			</div>

		</div>
	</div>

<?php } ?>

</div>
