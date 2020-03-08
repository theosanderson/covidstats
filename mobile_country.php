<html>
<link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-65298-25"></script>
<script>
	
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-65298-25');
</script>
<?
$prettycountry = $_GET['country'];
if($prettycountry=="UK"){$prettycountry="the UK";}
if($prettycountry=="US"){$prettycountry="the USA";}
?>

<title>COVID-19 Cases Projection for <?= $prettycountry ?></title>
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@">
<meta name="twitter:title" content="COVID-19 Cases Projection for <?= $prettycountry ?>">
<meta name="twitter:description" content="Fit a exponential curve to COVID-19 cases">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="/jquery.js"></script>
<script src="/d3.js"></script>
<script src="/metricsgraphics.js"></script>
 <link href='/metricsgraphics.css' rel='stylesheet' type='text/css'>
<style>
	*{font-family: Spartan;}
	button{font-family:system-ui}
/*	.controls {font-size:16px; text-align:center; background:#EFEFEF; border-radius:20px; margin:30px; padding:10px;}*/
	.controls {font-size:16px; text-align:center; background:#fff; border-radius:20px; margin:30px; padding:10px 30px; border:1px solid #DDD; line-height: 150%;}
	.controls button {font-size:14px; text-align:center;  }
</style>
</head>
<body style="width:600px; margin:0 0; text-align:center;margin-top:50px;">
	<div id="container" style=" background:white; ">
	<div id="graph" ></div>
	<div id="legend" style="display:none"></div>
</div>
	<script>
		

		predictions = null;
		raw = null;
		$.getJSON( '/<?= $_GET['country']?>.predictions.json?'+(new Date()).getTime(), function( data ) { 
			
			predictions = data;
			predictions = MG.convert.date(predictions, 'date');

			$.getJSON( '/<?= $_GET['country']?>.raw.json?'+(new Date()).getTime(), function( data ) { 
			
			raw = data;

			raw = MG.convert.date(raw, 'date');
			 for (var i = 0; i < raw.length; i++) {
        raw[i].active = true;
    }
    plotRawData();

		});

		});

	
		



		function drawGraph(steps_raw, steps_pred){
			data = [raw.slice(0,steps_raw),predictions.slice(0,steps_pred)];
  if(steps_pred>raw.length){
title= "Projection of cases of COVID-19 in <?= $prettycountry ?>";

  }
  else{
  	title= "Cases of COVID-19 in <?= $prettycountry ?>";
  }
			
    MG.data_graphic({
        title: title,
        xax_count:4,
        x_label: "Date",
        y_label: "Number of cases",
        data: data,
        width: 600,
        height: 500,
        left:150,
        legend:['Actual data','Projection'],
        right: 40,
        legend_target: document.getElementById('legend'),
        chart_type : 'line',
        target: document.getElementById('graph'),
        x_accessor: 'date',
           active_point_on_lines: true,
        active_point_accessor: 'active',
        active_point_size: 4,
        y_accessor: 'n',
        area:[false,true]
        //full_width:true,
    //  full_height: true
    });
};

function plotRawData(){
	drawGraph(100,0);

};
to_appear = null;
function fitCurve(){
	target_step=raw.length;
	next_step();
	$("#step1").fadeOut();
	to_appear=  "#step2";


};

current_step = 0;
target_step = null;
limit = 1200000;
interval_time =1000;
function next_step(){
	if (current_step < target_step  & predictions[current_step].n<limit){
	current_step = current_step + 1;
	drawGraph(100,current_step);
	setTimeout(next_step,interval_time)

}
else{
	$(to_appear).fadeIn();
	if(to_appear=="#step3")
		$('#other').fadeIn();
}


}

function extrapolate(){
	interval_time=1000;
	target_step=36;
	next_step();
	$("#step2").fadeOut();
	to_appear=  "#step3";

};





	
</script>
	<style>
		.mg-line1{color:red; stroke-color:red;}
	</style>
	<div style="min-height:140px;">
		<div id="step1" class="controls">
		<p>The graph above shows confirmed COVID-19 cases in <?= $prettycountry ?> plotted over time. </p>
		<button onclick="fitCurve()">Fit an exponential curve to the data</button> 
	</div>
	<div id="step2" style="display:none" class="controls">
		<p>This curve represents the exponential function that best models the current data. Click the button below to extend this exponential curve into the future. </p>
		<button onclick="extrapolate()">Extend curve</button> 
	</div>
	<div id="step3" style="display:none" class="controls">
		<p>Important note: This projection assumes that we do not change our behaviour or introduce additional measures to control the virus. <strong>We can avert this scenario</strong>, by <a target="_blank" href="https://www.youtube.com/watch?v=3PmVJQUCm4E">washing our hands</a>, isolating suspected cases, and cancelling large gatherings.</p>
		
	</div>
</div>

	<div id="other" style="padding-bottom:20px;"><a href="/" style="color:#DDD">Other countries</a>
	</div>
	
	</body>
</html>