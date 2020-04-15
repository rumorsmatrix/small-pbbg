

<div class="card shadow-lg mb-4  border-0">
    <h5 class="card-header bg-dark text-light">
        Lepton's Black Market
    </h5>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">

            <div class="row mt-3">
                <div class="col-md-9 order-2 order-md-1">

                    <img class="mr-4 mb-2 float-left" src="images/officers/trader_male.png" alt="">
                    <p class="mb-4 clearfix">
                        A <em>lepton</em> is a class of exotic particle, the quantum opposite to the <em>quark</em>, and also the name of the station's black market profiteer, which is probably some sort of weird coincidence. You can trade currency and items with Lepton to acquire various products from his stores. Lepton's stock changes regularly and can be unpredictable, so if you spot a bargain, act quickly.

                    </p>

                    <img class="mr-4 mb-2 float-left" src="images/officers/scientist_trader.png" alt="">
                    <p> Aenean interdum, mi non suscipit cursus, arcu erat porta nisl, at pretium diam neque quis neque. Cras mattis ut velit ut dapibus. Sed nec massa porta, feugiat nulla ac, tempus sapien. Vivamus a nisi ac massa finibus venenatis. Morbi vulputate ex odio, eget pretium velit iaculis eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec eget eros justo. Praesent vitae finibus mauris, nec ornare mauris. Pellentesque sit amet neque dapibus, fringilla lorem vel, commodo mauris. Aenean vulputate velit eget condimentum pharetra. Vivamus rutrum, orci eu tincidunt imperdiet, leo dui finibus libero, sed faucibus velit nulla et lectus. Nulla id imperdiet risus. Mauris eu posuere elit, id fermentum ipsum. In non nisl at urna pretium condimentum in eget libero.</p>


                </div>
                <div class="col-md-3 order-1 order-md-2 mb-4">

                    <nav class="nav nav-pills nav-justified flex-column">
                        <a class="nav-link active bg-secondary shadow-lg" href="#">Active</a>
                        <a class="nav-link" href="#">Link</a>
                        <a class="nav-link" href="#">Link</a>
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </nav>

                </div>
            </div>




        </li>
    </ul>

</div>






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
