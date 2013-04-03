<?
$appid = '205617506231401';
$secret = '1ac74e96030d56d62370ec7b7cf9479f';
// ID SYCLO
//$pageid = '248606865242';

// ID ESBATALM
$pageid = '457169121002559';


get_facebook_feed($appid,$secret,$pageid);

//var_dump( $json->data[0] );

function get_facebook_feed($appid,$secret,$pageid){
	$token = file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$appid.'&client_secret='.$secret);
		
	$feed = file_get_contents('https://graph.facebook.com/'.$pageid.'/feed?'.$token);
		
	$json = json_decode($feed);
	
	//print_r($json);
	echo '<ul>'."\n";
	foreach($json->data as $message){
		
		format_facebook_event($message);
		
	}
	echo '</ul>'."\n";
}


function format_facebook_event($data){
	$etc = strlen($data->message)<100?'':'…';
	if($data->message !=''){
		echo '<li class="social_item facebook">'."\n";
		echo '<p class="date">'.format_facebook_date($data->created_time).'</p>'."\n";
		echo '<p class="texte">'.substr($data->message,0,100).$etc.'<p>'."\n";
		echo '<p class="auteur"><a href="'.$data->link.'">'.$data->name.'</a></p>'."\n";
		echo '</li>'."\n";
	}
}

function format_facebook_date($date){
	$temp = explode('T',$date);
	$temp = implode(' ',$temp);
	setlocale(LC_TIME, "fr_FR");
	
	$timestamp = strtotime($temp);
	
	$dif = time()-$timestamp;
	
	if($dif<3600){
		
		return 'il y a '.round($dif/60).' minutes';
		
	}else if($dif < 3600*24){
		
		return 'il y a '.round($dif/3600).' heures';
			
	}else{
		
		//return 'le '.utf8_encode(strftime("%A %e %B %Y",$timestamp));
		return 'le '.utf8_encode(strftime("%e %B %Y",$timestamp));
		
	}
}

