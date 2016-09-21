<?php

$lookup_id = substr($ACTION,8);
$chart_object = load_chart_data($lookup_id);

foreach ($user_json['favorites'] as $user_chart) 
{
	if($chart_object['id']==$user_chart['id'])
	{
		$chart_object = array_merge($chart_object, $user_chart);
		break;
	}
}
$chart_object['size']='large';
?><!DOCTYPE html>
<html>
	<head>
		<title>BizBook</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo $BASE_URL; ?>/packages/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/packages/font-awesome/css/font-awesome.min.css">
		<link href="<?php echo $BASE_URL; ?>/css/ui.css" rel="stylesheet" media="screen" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php echo $BASE_URL; ?>/packages/jquery.tmpl.js"></script>
		<script src="<?php echo $BASE_URL; ?>/packages/bootstrap-3.0.0/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo $BASE_URL; ?>/packages/packery.pkgd.js"></script>
		<script src="<?php echo $BASE_URL; ?>/packages/draggabilly.pkgd.js"></script>
		<script src="<?php echo $BASE_URL; ?>/packages/moment.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<?php include("js_app.php");?>
	</head>
	<body>
		<?php include("navigation.php");?>
		<div id="charts_pane">
			<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a href="#">Home</a></li>
						<li role="presentation" class="dropdown-header">Dropdown header</li>
						<li><a href="#">Profile</a></li>
						<li><a href="#">Messages</a></li>
					</ul>
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
					<h1><?php echo $chart_object['title']; ?></h1>
					<div id="full_chart_pane" style="margin-bottom:25px;"></div>
					<div id="charts_data"></div>
				</div>
			</div>
		</div>
	</body>
</html>