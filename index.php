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

<title>COVID Cases Projection</title>

<script src="jquery.js"></script>

<style>
	*{font-family: Spartan;}
/*	.controls {font-size:16px; text-align:center; background:#EFEFEF; border-radius:20px; margin:30px; padding:10px;}*/
	.controls {font-size:16px; text-align:center; background:#fffefa; border-radius:20px; margin:30px; padding:10px 30px; border:1px solid #DDD; line-height: 150%;}
	.controls button {font-size:14px; text-align:center;  }
	.country{ padding:20px; text-align:center;  margin:10px; background:#EEE; border-radius:5px;}
	.country a{ color:black;}
</style>
</head>
<body style="width:800px; margin:0 auto; text-align:center;margin-top:50px;">
	
		<h1>COVID-19 projections</h1> 
		<p> These are projections that indicate how quickly COVID-19 could grow without measures being put into place. You can also view raw <a href="time_series.php">time series</a> for more countries.</p>
<div class="country_container" style="display:flex; flex-wrap:wrap;  justify-content:space-evenly">
		<?
		foreach (glob("*.raw.json") as $filename) {
			$country = str_replace(".raw.json","", $filename) ;
    ?><div class="country"><a href="/country/<?= $country  ?>"><?= $country  ?></a>  </div><?
}

		?>
	</div>

	
	
	</body>
</html>