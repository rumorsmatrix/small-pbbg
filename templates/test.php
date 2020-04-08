<pre>

<?php

//$user = $this->user;
//$officers = $user->getOfficers();


// example tracery usage
//$tracery = new \App\Tracery('example');
//
//for ($i = 0; $i < 5; $i++) {
//	echo $tracery->parse("I have a #animal# called #name#.<br>");
//}


$traveller = (new App\Traveller)->create();
$traveller->save();


var_dump($traveller);

?>

</pre>
