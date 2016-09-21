<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart","geochart","table"]});
</script>
<script id="chart_module_frame_tmpl" type="text/x-jquery-tmpl">
	<div class="chart_module chart_module_${size}" id="chart_module_${id}"><img src="<?php echo $BASE_URL; ?>/images/small-transparent-loading.gif"></div>
</script>
<script id="chart_module_page_tmpl" type="text/x-jquery-tmpl">
	<div id="chart_module_${id}"><img src="<?php echo $BASE_URL; ?>/images/small-transparent-loading.gif"></div>
</script>
<script id="chart_module_tmpl" type="text/x-jquery-tmpl">
	
	<div class="btn-group" style="position:absolute;top:5px;right:5px;">
		<button type="button" class="btn btn-default btn-xs" data-toggle="dropdown">
	  		<span class="icon-cog"></span>
		</button>
		<ul class="dropdown-menu" role="menu" style="font-size:12px;">
			<li><a href="#" onclick="alert('a')"><span class="icon-cog"></span> Configure </a></li>
			<li class="divider"></li>
			<li><a href="<?php echo $BASE_URL; ?>/details/${id}"><span class="icon-external-link"></span> Details</a></li>
			<li><a href="#"><span class="icon-share"></span> Share</a></li>
			<li><a href="#"><span class="icon-comments"></span> Comment</a></li>
			<li class="divider"></li>
			<li><a href="#"><span class="icon-heart"></span> Add to Favorites</a></li>
			<li><a href="#"><span class="icon-user"></span> Follow Author</a></li>
			<li class="divider"></li>
			<li><a href="#"><span class="icon-bell-alt"></span> Alert Me ... </a></li>
			<li><a href="#"><span class="icon-bar-chart"></span> Analyze</a></li>
			<li class="divider"></li>
			<li><a href="#"><span class="icon-trash"></span> Remove</a></li>
			<li><a href="#"><span class="icon-copy"></span> Duplicate</a></li>
			<li><a href="#"><span class="icon-bug"></span> Report Issue</a></li>
			<li class="divider"></li>
			<li><a href="#"><span class="icon-download"></span> Export</a></li>
			<li class="divider"></li>
			<li><a href="#" onclick="window.com.nytimes.NYTNow.change_chart_size('${id}',false);return false"><span class="icon-th"></span> Make it smaller</a></li>
			<li><a href="#" onclick="window.com.nytimes.NYTNow.change_chart_size('${id}',true);return false"><span class="icon-th-large"></span> Make it bigger</a></li>
		</ul>
	</div>
	<h2>${title}</h2>
	{{if size == "small"}} 
		{{eval chart_adjustment = 175}}
	{{/if}}
	{{if size == "medium"}} 
		{{eval chart_adjustment = 410}}
	{{/if}}
	{{if size == "large"}} 
		{{eval chart_adjustment = 640}}
	{{/if}}
	{{if typeof data_duration != 'undefined' && data_duration.value != ""}} 
		{{eval chart_adjustment -= 13}}
		<div class="data_duration" id="data_duration_${id}">${data_duration.value}</div>
	{{/if}}
	{{if typeof highlighted_data_point != 'undefined'}} 
		{{eval chart_adjustment -= 25}}
		<div class="highlighted_data_point" id="highlighted_data_point_${id}">${highlighted_data_point.value}</div>
	{{/if}}
	{{if typeof notations != 'undefined'}}
		{{each( index, notation ) notations}}
			{{eval chart_adjustment -= 14}}
			<div class="notation" id="${notation}_${index}_${id}">${notation.value}</div>
		{{/each}}
	{{/if}}
	<div class="chart_area" id="chart_canvas_${id}" style="height: ${chart_adjustment}px;"><img style="padding-top:${(chart_adjustment / 2)-18}px;" src="<?php echo $BASE_URL; ?>/images/small-transparent-loading.gif"></div>
	<div>
		<div style="position:absolute;bottom:5px;left:5px;">
			<img src="" width="20" height="20" align="left"/>
			<div class="data_relationship">Owner</div>
			<div class="person_name">Adam Lindenfield</div>
		</div>
		<div style="position:absolute;bottom:5px;right:5px;">
			<span class="ui-icon ui-icon-circle-arrow-w" style="float:left;"></span>
			<span class="icon-heart" style="float:left;padding-top:4px;">&nbsp;</span>
			<span style="float:left;" class="badge icon-comment">14</span>
			<span class="ui-icon ui-icon-calendar" style="float:left;"></span>
			<span class="ui-icon ui-icon-circle-arrow-e" style="float:left;"></span>
		</div>
	</div>

</script>
<script id="chart_page_tmpl" type="text/x-jquery-tmpl">
	<div id="chart_canvas_${id}" style="height: 500px;width:900px;"><img style="padding-top:${(500 / 2)-18}px;" src="<?php echo $BASE_URL; ?>/images/small-transparent-loading.gif"></div>
</script>
<script id="new_chart_module_tmpl" type="text/x-jquery-tmpl">
	<div class="chart_module chart_module_small" style="text-align:center;padding-top:30px;color:#E0E0E0;">
		<span class="icon-plus-sign-alt" style="font-size:150px"></span>
		<br/>
		Add A Chart
	</div>
</script>
<script>
window.com={nytimes:{}}
window.com.nytimes.NYTNow={
	grid_mode:<?php 
		if(substr($ACTION,0,7) != "details")
		{
			echo "true";
		} 
		else
		{
			echo "false";
		}
	?>,
	modules:[
	<?php 
	$modules = array();
	if($ACTION == "home")
	{
		foreach ($user_json['favorites'] as $user_chart) 
		{
			$system_chart = load_chart_data($user_chart['id']);
			$system_chart = array_merge($system_chart, $user_chart);
			$modules[]=json_encode($system_chart);
		}
	}
	elseif (substr($ACTION,0,7) == "details")
	{
		$modules[]=json_encode($chart_object);
	}
	elseif ($active_view !== FALSE)
	{
		foreach ($active_view['charts'] as $view_chart) 
		{
			$system_chart = load_chart_data($view_chart['id']);
			$system_chart = array_merge($system_chart, $view_chart);
			$modules[]=json_encode($system_chart);
		}
	}	
	echo implode(",\n", $modules);
	?>
	],
	utility_functions:{
		precise_round:function(num,decimals){
			return (Math.round(num*Math.pow(10,decimals))/Math.pow(10,decimals)).toFixed(decimals);
		},
		format_date:function(format,funk,key,value){
			var m = moment()
			funk=funk||false
			if(funk)
			{
				m=m[funk].call(m,key,value);
			}
			console.log("Formatting date with "+format)
			return m.format(format)
		},
		format_number_to_short:function(number,decimals){
			decimals = decimals||2
			var number=Math.round(number);
			var trillion = 1000000000000;
			var billion = 1000000000;
			var million = 1000000;
			var thousand = 1000;
			var hundred = 100;
			if(number>trillion)
			{
				number = this.precise_round(number/trillion,decimals)+'T';
			}
			else if(number>billion)
			{
				number = this.precise_round(number/billion,decimals)+'B';
			}
			else if (number>million)
			{
				number = this.precise_round(number/million,decimals)+'M';
			}
			else if (number>thousand)
			{
				number = this.precise_round(number/thousand,decimals)+'K';
			}
			return number;
			
		},
		text_data_to_array:function(data, column_seperator, line_seperator){
			console.log("In text_data_to_array")
			column_seperator = column_seperator||"\t"
			line_seperator = line_seperator || "\n"
			data=data.split(line_seperator) 
			for(var l=0;l<data.length;l++)
			{
				data[l]=data[l].split(column_seperator)
				for(var c=0;c<data[l].length;c++)
				{
					var item = data[l][c]
					item = isNaN(item)?item:((item.indexOf(".")>-1)?parseFloat(item):parseInt(item))
					data[l][c] = item
				}
			}
			console.log(data)
			return data
		}
	},
	render_data_in_fields:function(module_field,module_id,field_name){
		console.log(module_field.type)
		switch(module_field.type) {
			case "text/plain":
				break;
			case "text/script":
				try {
					module_field.value=eval(module_field.value)
				} catch (e){
					
				}
				break;
			case "text/json_api":
				var markup = module_field.value
				var div_id = field_name+"_"+module_id
				$.template(div_id, markup );
				
				var url = module_field.url
				console.log("url",url)
				
				var function_helper = {}
				function_helper['utilities']=window.com.nytimes.NYTNow.utility_functions
				$.template(div_id+"_url", url );
				url = $.tmpl( div_id+"_url", function_helper )[0]['data']
				
				console.log("url",url)
				module_field.value='... Loading ...'
				
				$.getJSON(url, function(data) {
					data['utilities']=window.com.nytimes.NYTNow.utility_functions
					var new_markup = $.tmpl( div_id, data )
					console.log("new_markup",new_markup)
					$('#'+div_id).html(new_markup)
					module_field.value=markup
				}).fail(function(data, textStatus, jqXHR) {
					
				});
				
				break;
			default:
				break;
		}
		return module_field;
	},
	render_module:function(module)
	{
		
		console.log("Rendering Module",module)
		if(this.grid_mode)
		{
			var fields = ['data_duration','highlighted_data_point']
			for(var f=0;f<fields.length;f++)
			{
				if(typeof module[fields[f]] != 'undefined')
				{
					module[fields[f]] = this.render_data_in_fields(module[fields[f]],module.id,fields[f])
				}
			}
		
			if(typeof module['notations'] != 'undefined' && module['notations'].length>0)
			{
				for(var n=0;n<module['notations'].length;n++)
				{
					module['notations'][n] = this.render_data_in_fields(module['notations'][n],module.id,'notation_'+n)
				}
			}
			console.log("Done processing fields")
			
			$.template("chart_module_tmpl", $('#chart_module_tmpl').html() )
			var new_markup = $.tmpl( "chart_module_tmpl", module )
			$('#chart_module_'+module.id).html(new_markup)
		}
		else
		{
			$.template("chart_page_tmpl", $('#chart_page_tmpl').html() )
			var new_markup = $.tmpl( "chart_page_tmpl", module )
			$('#chart_module_'+module.id).html(new_markup)
		}
		
		
		
		
		console.log("Done Rendering Module")
		
		if(typeof module.chart_options != 'undefined')
		{
			
			console.log("building chart")
			
			var chart_object = null
			var chart_div_id = 'chart_canvas_'+module.id

			switch(module.chart_options.type)
			{
				case "google_pieChart":
					chart_object = new google.visualization.PieChart(document.getElementById(chart_div_id));
					break;
				case "google_columnChart":
					chart_object = new google.visualization.ColumnChart(document.getElementById(chart_div_id));
					break;
				default:
					break;
			}


			switch(module.chart_data.type)
			{
				case "text/manual_tsv":
					var chart_data = this.utility_functions.text_data_to_array(module.chart_data.data,"\t")
					chart_data = google.visualization.arrayToDataTable(chart_data);
					chart_object.draw(chart_data, module.chart_options.options);
					break;
				case "text/json_nyt":
					$.getJSON(module.chart_data.url, function(data)
					{
						console.log(chart_div_id)
						switch(module.chart_options.type)
						{
							case "google_pieChart":
								chart_object = new google.visualization.PieChart(document.getElementById(chart_div_id));
								break;
							case "google_columnChart":
								chart_object = new google.visualization.ColumnChart(document.getElementById(chart_div_id));
								break;
							default:
								break;
						}
						console.log(data)
						var data_matrix = []
						var schema = data['schema']['fields']
						var column_names  = []
						var rows = data['rows']
						for(var s=0;s<schema.length;s++)
						{
							column_names.push(schema[s]['name'])
						}
						data_matrix.push(column_names)
						for(var r=0;r<rows.length;r++)
						{
							data_matrix.push(rows[r]['row'])
						}
						data_matrix = google.visualization.arrayToDataTable(data_matrix);
						chart_object.draw(data_matrix, module.chart_options.options);
						
						if($('#charts_data').length>0)
						{
							var data_table = new google.visualization.Table(document.getElementById('charts_data'));
							data_table.draw(data_matrix, {showRowNumber: true});
						}
						
						

					}).fail(function(data, textStatus, jqXHR) {

					});
					break;
				default:
					break;
			}
		}
		
		
		
				
	},
	build:function(){
		console.log(this.modules);
		for(var m=0;m<this.modules.length;m++)
		{
			if(this.grid_mode)
			{
				$('#chart_module_frame_tmpl').tmpl(this.modules[m]).appendTo( "#charts_pane" )
			}
			else
			{
				$('#chart_module_page_tmpl').tmpl(this.modules[m]).appendTo( "#full_chart_pane" )	
			}			
		}
		if(this.grid_mode)
		{
			$('#new_chart_module_tmpl').tmpl().appendTo( "#charts_pane" )
		}
		for(var m=0;m<this.modules.length;m++)
		{
			//this.modules[m] = this.comiple_module(this.modules[m])
			this.render_module(this.modules[m])
		}
	},
	change_chart_size:function(id,make_it_bigger)
	{
		var chart_object = $("#chart_module_"+id)
		var sizes = ['small','medium','large']
		var old_size = ''
		var new_size = false;
		var new_size_index;
		var modules = window.com.nytimes.NYTNow.modules
		
		for(var s=0;s<sizes.length;s++)
		{
			if(chart_object.hasClass("chart_module_"+sizes[s]))
			{
				new_size_index = (make_it_bigger)?s+1:s-1;
				old_size=sizes[s]
				if(typeof sizes[new_size_index] != 'undefined')
				{
					new_size=sizes[new_size_index];
					for(var m=0;m<modules.length;m++)
					{
						if(modules[m]['id']==id)
						{
							window.com.nytimes.NYTNow.modules[m]['size']=new_size;
							chart_object.removeClass("chart_module_"+old_size);
							chart_object.addClass("chart_module_"+new_size);
							window.com.nytimes.NYTNow.render_module(window.com.nytimes.NYTNow.modules[m]);
							$container.packery('layout');
							break;
						}
					}
					break;
				}
				
			}
		}
		
	},
	init:function(){
		$.extend($.tmpl.tag, {"eval": {open: "$1;"}});
		
		this.build()
		
		if(this.grid_mode)
		{
			$container = $('#charts_pane');

			$container.packery({
				itemSelector: '.chart_module',
				gutter: 8,
				columnWidth: 196,
				rowHeight: 225,
			});
			
			var itemElems = $( $container.packery('getItemElements') );
			// make item elements draggable
			itemElems.draggable();
			// bind Draggable events to Packery
			$container.packery( 'bindUIDraggableEvents', $itemElems );
		}
		
		
		
		
		
		
	}
}
$( document ).ready(function()
{
	com.nytimes.NYTNow.init()
});
</script>