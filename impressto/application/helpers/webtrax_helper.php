<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////
function bar_graph($type, $values, $labels = '', $pfolor = '', $lColor = '', $showVal = 0, $legend = '') {

	$webtraxasseturl = ASSETURL  . "/" . PROJECTNAME . "/default/core_modules/webtrax/";
	
	error_reporting(E_WARNING);

	$colors = array('#0000FF', '#FF0000', '#00E000', '#A0A0FF', '#FFA0A0', '#00A000');

	$graph = '';

	$d = explode(',', $values);

	$r = (strlen($labels) > 1) ? explode(',', $labels) : array();

	$lColor = (strlen($lColor) < 3) ? '#C0E0FF' : trim($lColor);
	$drf = explode(',', $pfolor);

	for($i = $sum = $max = 0; $i < count($d); $i++) {
		$drw = explode(';', $d[$i]);
		for($j = $cnt = 0; $j < count($drw); $j++) {
			$val[$i][$j] = trim($drw[$j]);
			$sum += $val[$i][$j];
			if($val[$i][$j] > $max) $max = $val[$i][$j];
			if(!$bf[$j]) {
				if($cnt >= count($colors)) $cnt = 0;
				$bf[$j] = (strlen($drf[$j]) < 3) ? $colors[$cnt++] : trim($drf[$j]);
			}
		}
	}
	$mPercent = $sum ? round($max * 100 / $sum) : 0;
	$mul = $mPercent ? 100 / $mPercent : 1;
	$type = strtolower($type);		
		
		$graph .= "<div class=\"clearfix\">";
		$graph .= "<table id=\"crudRecords\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
		$graph .= "<thead>";
		$graph .= "<th width=\"75\">Date</th>";
		$graph .= "<th width=\"75\">%</th>";
		$graph .= "<th width=\"75\">#</th>";
		$graph .= "<th>&nbsp;</th>";
		$graph .= "</thead>";
		$graph .= "<tbody>";
		
		for($i = 0; $i < count($d); $i++) {
		
			$date = ($i < count($r)) ? trim($r[$i]) : $i+1;
			$graph .= "<tr>";
									
			$graph .= "<td align=\"center\">". $date ."</td>";
			
			for($j = 0; $j < count($val[$i]); $j++) {
			
				$percent = $sum ? round($val[$i][$j] * 100 / $sum) : 0;
				
				if($percent) {
						
					$graph .= "<td align=\"center\">". $percent ."</td>";
					$graph .= "<td align=\"center\">". $val[$i][$j] ."</td>";
					$graph .= "<td>";
					$graph .= "<div class=\"progress progress-info\" style=\"margin: 0 0 0;\">";
					$graph .= "<div class=\"bar\" style=\"width: ". $percent ."%;\"></div>";
					$graph .= "</div>";
					$graph .= "</td>";
						
					//$val[$i][$j] <-- i have no idea what this is it and it is not showing up -gabe
				}
			}
			$graph .= '</tr>';
		}
		$graph .= "</tbody>";
		$graph .= "</table>";

	return $graph;
} // end of bargraph function

/////////////////////////////
//
// Added December 26, 2003 to show unique visitor per day
//
/////////////////////////////
function AddUniquePerDay($yesterdaysarchivedata){

	global $pf;

	$yesterdays_year = date("Y",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
	$yesterdays_month = date("m",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
	$yesterdays_day = date("d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));

	$month_uniqueperday_archive = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . $yesterdays_year . $yesterdays_month . "_unique_perday.txt";

	if(file_exists($month_uniqueperday_archive)){
		$fp = fopen($month_uniqueperday_archive, "a"); 
	}else{
		$fp = fopen($month_uniqueperday_archive, "w"); 
	}

	foreach($yesterdaysarchivedata as $rec){

		$yesterdays_unique_array[]= $rec[2];

	}

	$yesterday_total = array_count_values($yesterdays_unique_array);

	fwrite($fp, count($yesterday_total) . "|" . $yesterdays_day . "|\n");

	fclose($fp);

}

/////////////////
function process_prevday($prevdayfile){

	global $pf;

	$yesterdaysarchivedfile = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . "archive_" . date("Ymd",mktime (0,0,0,date("m"),date("d")-1,date("Y"))) . ".txt";


	if(!file_exists($yesterdaysarchivedfile)){
		rename($prevdayfile, $yesterdaysarchivedfile);
	}

	$arcfile = fopen($yesterdaysarchivedfile,"r"); 

	$yesterdaysarchivedata = array();

	while ($line = fgets($arcfile,4096)) { 
		$yesterdaysarchivedata[] = explode("|",$line); 
	}

	AddUniquePerDay($yesterdaysarchivedata);

	
	$twomontholdfile = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax/" . date("Ym",mktime (0,0,0,date("m")-2,date("d"),date("Y"))) . "__" . date("d",mktime (0,0,0,date("m"),date("d"),date("Y"))) . ".txt";
	if(file_exists($twomontholdfile)){ unlink($twomontholdfile); }

}