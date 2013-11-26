<ul>
<?php
/*
Access level 							Read-only
About the application permission model
Consumer key 							iQysfyQJutw2AOVrY601w
Consumer secret 						qRpDjFZkeU8qDdo9mnty2KK5DHBIEm3DrCQlmeNdYo
Request token URL 						https://api.twitter.com/oauth/request_token
Authorize URL 							https://api.twitter.com/oauth/authorize
Access token URL 						https://api.twitter.com/oauth/access_token
Callback URL 							http://client.syclo.fr/talm/wp-content/plugins/formidable_talm_social/talm_twitter.php

Access token							859331623-e4uVcGQdQYuRlLXbcT44usrSQYemB4GBKDxNKc1f
Access token secret						mkkXobWibTSL7NPu9By42JZTOoLbJTWbnrGvdVwdrQ
*/

//// REF
// https://github.com/dg/twitter-php
// https://dev.twitter.com/docs/platform-objects/users
// http://phpfashion.com/twitter-for-php

include('lib/twitter.class.php');

$twitter = new Twitter('iQysfyQJutw2AOVrY601w', 'qRpDjFZkeU8qDdo9mnty2KK5DHBIEm3DrCQlmeNdYo', '859331623-e4uVcGQdQYuRlLXbcT44usrSQYemB4GBKDxNKc1f', 'mkkXobWibTSL7NPu9By42JZTOoLbJTWbnrGvdVwdrQ');
$channel = $twitter->load(Twitter::ME);


foreach ($channel as $status) {
	setlocale(LC_TIME, "fr_FR");
	echo '<li class="social_item tweet">'."\n";
	//echo '<p class="date">le '.date("j F Y à H\hi", strtotime($status->created_at)).'</p>'."\n";
	echo '<p class="date">le '.strftime("%d %B %Y à %Hh%M", strtotime($status->created_at)).'</p>'."\n";
	//echo '<p class="date">'.format_twitter_date($status->created_at).'</p>'."\n";
    echo '<p class="auteur"><a href="http://twitter.com/'.$status->user->screen_name.'" target="_blank">@'.htmlspecialchars($status->user->screen_name).'</a></p>'."\n";
    echo '<p class="texte">'.Twitter::clickable($status).'</p>'."\n";
    echo '</li>'."\n";
}


?>

</ul>