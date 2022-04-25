<?php 
	echo SITENAME;
	echo '<br>';
	echo $data['title'];
	echo '<br>';
	echo $data['name'];
	echo '<br>';
	echo 'This MVC Framework is created by '. $data['name'];
	echo '<br>';
	foreach ($data['users'] as $user) {
		echo "Information: ". $user->user_name. $user->user_email. $user->user_pass;
		echo '<br>';
	}
