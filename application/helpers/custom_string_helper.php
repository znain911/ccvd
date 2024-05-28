<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//String Wrapper
function string_wrapper($string, $count=3)
{
	$get_allwords = explode(' ', $string);
	if(count($get_allwords) > 4)
	{
		$arr = '';
		for($i=0; $i<count($get_allwords);$i++)
		{
			if(isset($get_allwords[$i]))
			{
				if($i > $count)
				{
					$arr .= null;
				}else
				{
					$arr .= $get_allwords[$i].' ';
				}
			}
		}
		$arr .= '...';
		return $arr;
	}else
	{
		$arr = '';
		for($i=0; $i<count($get_allwords);$i++)
		{
			if(isset($get_allwords[$i]))
			{
				if($i > $count)
				{
					$arr .= null;
				}else
				{
					$arr .= $get_allwords[$i].' ';
				}
			}
		}
		return $arr;
	}
}

//Date Formatting
function date_formatting($string, $onlydate=false)
{
	$time = strtotime($string);
	if($onlydate == true)
	{
		$myFormatForView = date("M d, Y", $time);
	}else
	{
		$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
	}
	return $myFormatForView;
}

function get_review($rating)
{
	$rate = intval($rating);
	$x = 1;
	$rating_icon = '';
	for($x=1;$x<=$rate;$x++) {
		$rating_icon .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
	}
	while ($x<=5){
		$rating_icon .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
		$x++;
	}
	return $rating_icon;
}