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

<title>COVID Time Series</title>

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
	
	

	<h1>COVID-19 full time series</h1>
		<p>These graphs simply display the per-country time series data from <a href="https://github.com/CSSEGISandData/COVID-19">Johns Hopkins</a>. You can also explore basic <a href="/">projections</a> for a smaller set of countries.</p>
<div class="country_container" style="display:flex; flex-wrap:wrap;  justify-content:space-evenly">
		<?
		foreach (glob("*.full_series.json") as $filename) {
			$country = str_replace(".full_series.json","", $filename) ;
    ?><div class="country"><a href="/series/<?= $country  ?>"><?= $country  ?></a>  </div><?
}

		?>
	</div>
	
	</body>
</html>