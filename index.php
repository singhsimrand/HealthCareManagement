<?php
error_reporting(E_ALL);
session_start();


$BASE_URL = "/NYTNow";
$ACTION = str_replace($BASE_URL, "", $_SERVER['REQUEST_URI']);
$USERS_DIR = "users/";
$TEMPLATES_DIR = "templates/";
$CHARTS_DIR = "charts/";

$ACTION=trim($ACTION);
while (substr($ACTION, 0, 1)=="/")
{
	$ACTION=substr($ACTION, 1);
	$ACTION=trim($ACTION);
}
while (substr($ACTION, -1, 1)=="/")
{
	$ACTION=substr($ACTION, 0, -1);
	$ACTION=trim($ACTION);
}





if($ACTION == "login" && isset($_POST['email']) && isset($_POST['password']))
{
	$ACTION = $_POST["action"];
	list($user, $domain, $uid, $gid, $gecos, $home, $shell)= explode("@", $_POST["email"]);
	$user_json = $USERS_DIR.$user.'.json';
	if(file_exists($user_json))
	{
		$user_json = load_user_data($user);
		if($user_json !== FALSE)
		{
			if($user_json['password'] == sha1($_POST["password"]))
			{
				$_SESSION['user']=$user;
			}
		}
	}
}
elseif ($ACTION  == "logout")
{
	unset($_SESSION['user']);
}
if (!isset($_SESSION['user']))
{

	include($TEMPLATES_DIR."login.php");
	die();
}
if($ACTION == ""){
	$ACTION="home";
}



$user_json = load_user_data($_SESSION['user']);
$lenses_list = get_lense_list('lenses');

if(substr($ACTION,0,4)=="home" || substr($ACTION,0,4)=="view")
{
	include($TEMPLATES_DIR."panel.php");
}
elseif(substr($ACTION,0,7)=="details")
{
	include($TEMPLATES_DIR."details.php");
}









function load_user_data($userid)
{
	global $USERS_DIR;
	$user_json = $USERS_DIR.$userid.'.json';
	if(file_exists($user_json))
	{
		$user_json = file_get_contents($user_json);
		$user_json = json_decode($user_json, true);
		if($user_json !== NULL)
		{
			return $user_json;
		}
	}
	return FALSE;
}


function load_chart_data($chart_id)
{
	global $CHARTS_DIR;
	$chart_json = $CHARTS_DIR.$chart_id.'.json';
	if(file_exists($chart_json))
	{
		$chart_json = file_get_contents($chart_json);
		$chart_json = json_decode($chart_json, true);
		if($chart_json !== NULL)
		{
			return $chart_json;
		}
	}
	return FALSE;
}

function get_lense_list($path)
{
	$list_of_files = array();	
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if ($entry != "." && $entry != "..")
			{
				if(is_dir($path.'/'.$entry))
				{
					$results = get_lense_list($path.'/'.$entry);
					if(count($results))
					{
						$list_of_files[$entry]=$results;
					}
				}
				else
				{
					$json_data = file_get_contents($path.'/'.$entry);
					$json_data = json_decode($json_data, true);
					if($json_data !== NULL)
					{
						$list_of_files[]=$json_data;
					}
					
				}
				
			}
		}
		closedir($handle);
	}
	return $list_of_files;
	
}

function in_array_recursive($key, $value, $array)
{
	if(is_array($array))
	{
		foreach ($array as $k => $v)
		{
			if(is_array($v))
			{
				$result = in_array_recursive($key, $value, $v);
				if($result)
				{
					return true;
				}
			}
			else
			{
				if( $key == $k && $value == $v)
				{
					return true;
				}
			}
		}
	}
}


/*

if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
} else {
  $_SESSION['count']++;
}
*/

//var_dump($_SESSION);


//var_dump($_GET);
//var_dump($_SERVER );



?>
