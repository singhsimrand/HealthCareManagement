<?php
$active_view = false;
if(substr($ACTION,0,4) == "view")
{
	$lookup_id = substr($ACTION,5);
	foreach ($lenses_list as $key => $value)
	{
		if(is_string($key))
		{
			foreach ($value as $key_L2 => $value_L2)
			{
				if($value_L2['id'] == $lookup_id)
				{
					$active_view = $value_L2;
					break 2;
				}
			}
		}
		else
		{
			if($lookup_id == $value['id'])
			{
				$active_view = $value;
				break 1;
			}
		}
		
	}
}
?>
<!DOCTYPE html>
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
			
			
		</div>
	</body>
</html>
<!--
//170757022

select week, sum(page_views) from
(
  SELECT EXTRACT(WEEK FROM eventdate) as week, count(*) as page_views 
  FROM fact_datum_page_201306 group by week
  UNION
  SELECT EXTRACT(WEEK FROM eventdate) as week, count(*) as page_views 
  FROM fact_datum_page_201307 group by week
  UNION
  SELECT EXTRACT(WEEK FROM eventdate) as week, count(*) as page_views 
  FROM fact_datum_page_201308 group by week
  UNION
  SELECT EXTRACT(WEEK FROM eventdate) as week, count(*) as page_views 
  FROM fact_datum_page_201309 group by week
) 
where week > EXTRACT(WEEK FROM now() - interval '12 weeks')  
group by week

//-->

<!--

/*
	
	{
		id:"v12346",
		title:"Something L",
		size:"small",
		highlighted_data_point:{
			type:"text/plain",
			value:"by Month"
		},
		chart_options:{
			options:{
				pieHole: 0.4,
				chartArea:{
					left:5,
					top:5,
					width:"100%",
					height:"100%",
				}
			},
			type:"google_pieChart",
		},
		chart_data:
		{
				type:"text/json_nyt",
				url:"http://bi-datavis01.dev.ewr1.nytimes.com/api/redshift/runquery/etprd/SELECT%20sourceapp%2C%20count(*)%20FROM%20fact_datum_page_20130906%20group%20by%20sourceapp/?api_key=123"
		}
	},
	{
		id:"v1234",
		title:"Something Small",
		size:"small",
		data_duration:{
			type:"text/json_api",
			value:"Total PV for ${utilities.format_date(\"MMMM\")} ${utilities.format_number_to_short(rows[0].row[0])}",
			url:"http://bi-datavis01.dev.ewr1.nytimes.com/api/redshift/runquery/etprd/SELECT%20count(*)%20FROM%20fact_datum_page_20130906%20/?api_key=123 ",
		},
		highlighted_data_point:{
			type:"text/json_api",
			value:"$${utilities.format_number_to_short(rows[0].row[0])}",
			url:"http://bi-datavis01.dev.ewr1.nytimes.com/api/redshift/runquery/etprd/SELECT%20count(*)%20FROM%20fact_datum_page_20130906%20/?api_key=123 ",
		},
		
	},
	{
		id:"v12345",
		title:"Something M",
		size:"medium",
		data_duration:{
			type:"text/plain",
			value:"by Month"
		}
	},
	{
		id:"v12346",
		title:"Something L",
		size:"large",
		data_duration:{
			type:"text/plain",
			value:"by Month"
		}
	},
]
*/
-->