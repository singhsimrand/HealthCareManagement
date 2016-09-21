var $ = require('jquery');
var m = require('moment');
var jqtpl = require('jqtpl');
var fs = require('fs');
var file = __dirname + '/../../infoCenter/charts/v123468898742.json';






fs.readFile(file, 'utf8', function (err, data)
{
	if (err)
	{
		console.log('Error: ' + err);
		return;
	}
	
	data = JSON.parse(data);
	
	if (typeof data["chart_data"] != "undefined" && typeof data["chart_data"]["query"] != "undefined" && typeof data["chart_data"]["query"]["filter_groups"] != "undefined")
	{
		
		var output = render_sql(data["chart_data"]["query"],{"product":"mobile_web","frequency":"daily"});
		console.log(output);
		
		//var tpl = "<div>${a}</div>"
		//var output = jqtpl.render(tpl, {a:123});
		//console.log(output);
		//console.dir(data["chart_data"]);
	}
	
	
	
	
});


function render_sql(query_object, selected_filters)
{
	var output = "X";
	var filters = {};
	var filter_groups = query_object["filter_groups"];
	var data_object_4_tpl = {
		utilities:{
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
		}
		
		
	}
	
	for (var key in selected_filters)
	{
		data_object_4_tpl[key] = {}
		data_object_4_tpl[key]["key"] = selected_filters[key];
	}
	console.log("data_object_4_tpl",data_object_4_tpl);
	
	for(var f=0;f<filter_groups.length;f++)
	{
		var selected_filter_key = selected_filters[filter_groups[f]["key"]];
		console.log("selected_filter_key",selected_filter_key)
		var filter_premutations = filter_groups[f]["filters"];
		for(var fp=0;fp<filter_premutations.length;fp++)
		{
			if (filter_premutations[fp]["key"]==selected_filter_key)
			{
				data_object_4_tpl[filter_groups[f]["key"]]["sql"] = jqtpl.render(filter_premutations[fp]["sql"], data_object_4_tpl);
				break;
			}
		}
		
		//console.log(tpl);
		//jqtpl.render(tpl, {a:123})
	}
	console.log("data_object_4_tpl",data_object_4_tpl);
	
	output = jqtpl.render(query_object["sql"], data_object_4_tpl);

	console.log(selected_filters);
	return output;
}

