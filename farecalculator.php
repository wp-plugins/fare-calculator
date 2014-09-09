<?php
/*
Plugin Name: Fare calculator
Plugin URI: http://staunchire.com
Description: Easy way to calculate the fare price on taxi or any service, with the help of google map with auto suggestion place , this is the plugin you need. 
Version: 1.0
Author: Gopi krishnan, MoB: +91 8122335200, Email: krishna25auro@gmail.com
Author URI: https://www.facebook.com/badchetah
License: GPL2
*/
/*
Copyright 2014  Gopi krishnan  (email : krishna25auro@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program;
*/





function fc_faretable()
{
       
	global $wpdb;
 
	
	  $table_name = $wpdb->prefix . "fare";
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		service tinytext NOT NULL,
		fare tinytext NOT NULL,
		UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	
}
// this hook will cause our creation function to run when the plugin is activated
register_activation_hook( __FILE__, 'fc_faretable' );


function fc_fareremovetb() {
     global $wpdb;
     $table_name = $wpdb->prefix . "fare";
     $sql = "DROP TABLE IF EXISTS $table_name;";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");
}

register_deactivation_hook( __FILE__, 'fc_fareremovetb' );











function fc_fare(){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">html{height:100%}body{height:100%;margin:0px;padding:0px;font-family:tahoma;font-size:8pt}#total{font-size:large;text-align:center;font-family:arial;color:green;margin:5px 0 10px 0;font-size:14px;width:374px}input{margin:5px 0px;font-family:tahoma;font-size:8pt}</style>
<head><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">//<![CDATA[
var map=null;var directionDisplay;
var directionsService=new google.maps.DirectionsService();
function fc_initialize(){directionsDisplay=new google.maps.DirectionsRenderer();
	var India=new google.maps.LatLng(<?php echo esc_attr( get_option('latitude') ); ?>,<?php echo esc_attr( get_option('longitude') ); ?>);
	var mapOptions={center:India,zoom:10,minZoom:3,
		streetViewControl:false,
		mapTypeId:google.maps.MapTypeId.ROADMAP,
		zoomControlOptions:{style:google.maps.ZoomControlStyle.MEDIUM}};
		map=new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

		var fromText=document.getElementById('start');var fromAuto=new google.maps.places.Autocomplete(fromText);fromAuto.bindTo('bounds',map);
		var toText=document.getElementById('end');
		var toAuto=new google.maps.places.Autocomplete(toText);toAuto.bindTo('bounds',map);
		directionsDisplay.setMap(map);directionsDisplay.setPanel(document.getElementById('directions-panel'));}



function fc_calcRoute(){
	var start=document.getElementById('start').value;
	var end=document.getElementById('end').value;
	var request={origin:start,destination:end,travelMode:google.maps.DirectionsTravelMode.DRIVING};
	directionsService.route(request,
		function(response,status){if(status==google.maps.DirectionsStatus.OK){directionsDisplay.setDirections(response);fc_computeTotalDistance(response);}});}
function fc_computeTotalDistance(result){var total=0;
	var myroute=result.routes[0];
	for(i=0;i<myroute.legs.length;i++){total+=myroute.legs[i].distance.value;}
total=total/1000;var e=document.getElementById("car");
var strUser=e.options[e.selectedIndex].value;
//if(total<=300)
/*{if(strUser==8)
{var dist=(8+17)*total;}
else if(strUser==9)
{var dist=(9+16)*total;}
else if(strUser==11)
{var dist=(11+26.5)*total;}
else if(strUser==12)
{var dist=(12+25.5)*total;}
else if(strUser==13)
{var dist=(13+24.5)*total;}}
else{*/
var dist=strUser*total;
document.getElementById("total").innerHTML="Total Distance = "+total+" km </br> Fare Price = Rs "+dist;}
function auto(){var input=document.getElementById[('start'),('end')];var types
var options={types:[],componentRestrictions:{country:["IND"]}};var autocomplete=new google.maps.places.Autocomplete(input,options);}
google.maps.event.addDomListener(window,'load',fc_initialize);
//]]></script>
<style>#car{  border: 1px solid #c6c6c6;
    margin-bottom: 25px;
    padding: 5px;
    width: 50%;}
	
	
	</style>
 </head>
<body onLoad="fc_initialize()">
  <div id="map_canvas" style="width: 874px; height: 300px; border: solid 1px #336699"></div> 
 <div class="post style-2 bottom-2">
      
   
 
                <!--   <select value="select car" id="car" style="float:left;margin-top:5px">
<option value=8>INDICA</option>
<option value=8>Liva</option>
<option value=8>EECO</option>
<option value=8>FIGO</option>
<option value=9>INDIGO</option>
<option value=9>FORD FIESTA</option>
<option value=9>FORD IKON</option>
<option value=9>SWIFT DEZIRE</option>
<option value=9>LOGAN</option>
<option value=9>ETIOS</option>
<option value=9>VERITTO</option>
<option value=11>TAVERA</option>
<option value=11>TATA SUMO</option>
<option value=12>INNOVA</option>
<option value=13>XYLO</option>
<option value=13>TEMPO TRAVELLER</option>

</select>--> 
<div class='sdc'>
<table><tr><td> 
  <span style="color: black;float: left;"> From:</span></td>
               <td> <input type="text" id="start" size="50px" name="start" placeholder="Enter Location From" style="float:left;margin-left:20px;"></td>
             <tr><td>   <span style="color: black;float: left;">To:</span></td>
                <td>  <input size="50px" type="text" id="end" name="end" placeholder="Enter Destination " style="float:left;margin-left:20px;"> </td>
				  			          
 <tr><td>Select Service :</td><td><select  value="select car" id="car" style="float:left;margin-top:5px;margin-left:20px;">
            <?php
			global $wpdb;
			$table_name = $wpdb->prefix . "fare";
            $postids = $wpdb->get_results("SELECT service,fare FROM $table_name");

            foreach ($postids as $value) {
                echo '<option value='.$value->fare.'>' . $value->service . '</option>' ;

            }
            ?>
        </select></td></tr>
				  
				 <tr> <td><input type="button" value="Calculate" onClick="fc_calcRoute();"></td><td> <div style="float:left" id="total"></td></tr></table></div>

	
				  </div>
             
             </div>
       </body>
</html> <?php }

add_shortcode('fc_fare', 'fc_fare');

add_action('admin_menu', 'fc_farecreatemenu');

function fc_farecreatemenu() {

	//create new top-level menu
	add_menu_page('Fare Plugin Settings', 'Fare Settings', 'administrator', __FILE__, 'fc_faresettingspage',plugins_url('/images/fare.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'fc_registermysettings' );
}


function fc_registermysettings() {
	//register our settings
	register_setting( 'fare-settings-group', 'latitude' );
	register_setting( 'fare-settings-group', 'longitude' );
	
}
	
function fc_faresettingspage() {
?>
<div class="wrap">
<h2>Fare Calculator Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'fare-settings-group' ); ?>
    <?php do_settings_sections( 'fare-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
		<label>Enter latitude and longitude of country/place to display on map</label> 
        <th scope="row">Latitude</th>
        <td><input type="text" name="latitude" value="<?php echo esc_attr( get_option('latitude') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Longitude</th>
        <td><input type="text" name="longitude" value="<?php echo esc_attr( get_option('longitude') ); ?>" /></td>
        </tr>
        </table>    
    <?php submit_button(); ?>
</form>
</br>
</div>
<div>
<?php
global $wpdb;
if(isset($_POST['service'])){

$table_name = $wpdb->prefix . "fare";
$wpdb->insert( $table_name, array( 'service' => $_POST['service'], 'fare' => $_POST['fare'] ) );
}

?>
<?php// echo $path /farecalculator/insert.php ?>
</br></br></br>

<?php $path = plugins_url( ); ?> 
<form method="post" action="">
       <table class="form-table">
        <tr valign="top">
		<label>Enter Service and its price/fare</label> 
        <th scope="row">Service</th>
        <td><input type="text" name="service" value="" required="required" /> eg : INNOVA</td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Fare</th>
        <td><input type="text" name="fare" value="" required="required" />eg : 10(for amount)</td>
        </tr>
		<tr> </tr>
        </table>    
   <input type="submit" value="ADD"/>
</form></br>

<?php
if(isset($_POST['delid'])){
	global $wpdb;
	echo $did=$_POST['delid'];
	$table_name = $wpdb->prefix . "fare";
        $wpdb->query(" DELETE FROM $table_name where id=".$did);
		
//$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = 1"));
}

?>
<style>
.faretable {
	margin:0px;padding:0px;
	width:100%;
	box-shadow: 10px 10px 5px #888888;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.faretable table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.faretable tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.faretable table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.faretable table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.faretable tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.faretable tr:hover td{
	
}
.faretable tr:nth-child(odd){ background-color:#e5e5e5; }
.faretable tr:nth-child(even)    { background-color:#ffffff; }.faretable td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.faretable tr:last-child td{
	border-width:0px 1px 0px 0px;
}.faretable tr td:last-child{
	border-width:0px 0px 1px 0px;
}.faretable tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.faretable tr:first-child td{
		background:-o-linear-gradient(bottom, #cccccc 5%, #b2b2b2 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #b2b2b2) );
	background:-moz-linear-gradient( center top, #cccccc 5%, #b2b2b2 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#cccccc", endColorstr="#b2b2b2");	background: -o-linear-gradient(top,#cccccc,b2b2b2);

	background-color:#cccccc;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#000000;
}
.faretable tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #cccccc 5%, #b2b2b2 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #b2b2b2) );
	background:-moz-linear-gradient( center top, #cccccc 5%, #b2b2b2 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#cccccc", endColorstr="#b2b2b2");	background: -o-linear-gradient(top,#cccccc,b2b2b2);

	background-color:#cccccc;
}
.faretable tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.faretable tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
	
	</style>




<div class="faretable">

		<table  >
		<th>Service</th><th>Fare</th><th>Action</th>
		<?php
		$table_name = $wpdb->prefix . "fare";
		$postids = $wpdb->get_results("SELECT id,service,fare FROM $table_name");
		


            foreach ($postids as $value) {
                echo '<tr valign="top">';
                echo '<td>' . $value->service . '</td>';
                echo '<td>' . $value->fare . '</td>';
               echo "<td><form method='post' action=''>
			   <input name='delid' type='hidden' value='$value->id'/><input type='submit' value='Delete'/></form></td>";
                echo '</tr>';
            } 
             
			 ?>
			 </table>
</div></br></br></br>
 Preview: <select >
            <?php
			$table_name = $wpdb->prefix . "fare";
            $postids = $wpdb->get_results("SELECT service,fare FROM $table_name");

            foreach ($postids as $value) {
                echo '<option value='.$value->fare.'>' . $value->service . '</option>' ;

            }
            ?>
        </select></br>
	<span>Copy the shorcode into pages or posts: [fc_fare] </span></br></br></br>
		

copyright&copy;2014<a href='http://www.staunchire.com' target='_blank'>Staunchire</a> 
Author :Gopi krishnan

</div>



<?php } ?>
























