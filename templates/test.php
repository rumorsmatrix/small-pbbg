<pre>

<?php

//$user = $this->user;
//$officers = $user->getOfficers();

//$traveller = (new App\Traveller)->create();
//$traveller->save();
//var_dump($traveller);


/*





*/


// example tracery usage
$grammar = [



];


$tracery = new \App\Tracery($grammar);

for ($i = 0; $i < 5; $i++) {
	echo $tracery->parse("I have a #animal# called #name#.<br>");
}



?>

</pre>
