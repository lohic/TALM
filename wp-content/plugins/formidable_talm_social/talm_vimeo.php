<?php

/*

Client ID (Also known as Consumer Key or API Key) 				668770108035087e6fb60c933bf856a36229b2d0
Client Secret (Also known as Consumer Secret or API Secret) 	20ca51b8583fd56b6b796148b9bde8129270b174
Request Token URL												https://vimeo.com/oauth/request_token
Authorize URL													https://vimeo.com/oauth/authorize
Access Token URL												https://vimeo.com/oauth/access_token
Your Callback URL (edit)										http://client.syclo.fr/talm/wp-content/plugins/formidable_talm_social/talm_vimeo.php


Access token													a1fe158abf2e73c8d30e5a9b7450eddf
Access token secret												d61ef98886d69fd1ea766b88394fed8582c9588b
Permissions														Read, write, delete
*/



//echo "<!-- VIMEO SOCIAL YOUPI -->";


include_once('lib/vimeo.php');


$vimeo = new phpVimeo('668770108035087e6fb60c933bf856a36229b2d0','20ca51b8583fd56b6b796148b9bde8129270b174');
$vimeo->setToken('a1fe158abf2e73c8d30e5a9b7450eddf','d61ef98886d69fd1ea766b88394fed8582c9588b');

$result = $vimeo->call('vimeo.videos.getAll',array('user_id'=>'esbatalm','per_page'=>15,'full_response'=>true));

//var_dump($result);
$videos = $result->videos->video;

echo '<ul>'."\n";
foreach($videos as $video){
	echo '<li class="social_item vimeo">'."\n";
	echo '<p class="image"><a href="'.$video->urls->url[0]->_content.'" target="_blank"><img src="'.$video->thumbnails->thumbnail[0]->_content.'" /></a></p>'."\n";
	echo '<p class="titre">'.$video->title.'</p>'."\n";
	echo '<p class="auteur">par '.$video->owner->display_name.'</p>'."\n";
	echo '</li>'."\n";	
}
echo '</ul>'."\n";

//echo $videos;