<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<title><?php echo $site_name; ?></title>
<?php
echo plugin::render('stylesheet');
echo plugin::render('javascript');

if ($show_map === TRUE)
{
	echo "\n<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>\n";
}
?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
$(function() {
	$("h2.expand").toggler({speed: "fast"});
});
$(document).ready(function(){
  if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(setPosition);
    //Your callback function—the showMap function in this example—should take a position object as the parameter as follows:
  var latitude = 0;
  var longitude = 0;
        function setPosition(position) {
          // Show a map centered at position
          latitude = position.coords.latitude;
          longitude = position.coords.longitude;
        }

  $("#nearby-places-trigger").click(function(){
     $.ajax({
        url:"<?=url::site()?>mobile/nearby_places/"+latitude+"/"+longitude,
        dataType:'json',
        success:function(data) {
          var incidents = "";
          $(data).each(function(i,e){
            e.distance = (Math.round(100*e.distance))/100;
            incidents += "<li><a href=\"/mobile/locations/"+e.id+"\">"+e.location_name+"</a> - Distance: "+e.distance+"mi</li>";
          })
          $("#nearby-places").html(incidents);
        }
      })
  })
  
  $("#recent-activity-trigger").click(function(){
    $.ajax({
      url:"<?=url::site()?>mobile/recent_activity/"+latitude+"/"+longitude,
      dataType:'json',
      success:function(data) {
        var incidents = "";
        $(data).each(function(i,e){
          e.distance = (Math.round(100*e.distance))/100;
          incidents += "<li><a href=\"/mobile/locations/"+e.id+"\">"+e.location_name+"</a> - Distance: "+e.distance+"mi - Last Activity: "+e.date+"</li>";
        })
        if (data.length==0) {
          incidents = "<h3>There is no recent activity near you.</h3>"
        }
        $("#recent-activity").html(incidents);
      }
    })
  })

}

  
})


//--><!]]>
</script>
<script type="text/javascript">
<?php echo $js; ?>
</script>
</head>

<body <?php
if ($show_map === TRUE) {
	echo " onload=\"initialize()\"";
}
?>>
	<div id="container">
		<div id="header">
			<h1><a href="/mobile/">#Occupy<span class="yellow">Map</a></a></h1>
			<span><?php echo $site_tagline; ?></span>
		</div>
		<div id="navigation">
			&raquo;&nbsp;<a href="<?php echo url::site()."mobile"; ?>">Home</a><?php echo $breadcrumbs; ?>
		</div>
		<div id="page">