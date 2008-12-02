<?php
/*
Plugin Name: VB's way to simply add YouTube videos
Plugin URI: http://vladbabii.com/experimente/vb-simple-youtube
Description: A simple way to add a youtube video. Just put youtube::video_id:: and you'll see the video in the post. Example: youtube::CwyrGwM4a7M::. Just dont forget the "::" after the id.
Version: 0.1
Author: Vlad Babii
Author URI: http://vladbabii.com
*/

function vb_simple_youtube_pre_tag() 	{ return 'youtube::'; }
function vb_simple_youtube_post_tag() 	{ return '::'; }
function vb_simple_youtube_priority() 	{ return 100; }

function vb_simple_youtube_content($wall)
{
	$lastfound	= null;
	$pretag		= vb_simple_youtube_pre_tag();
	$posttag	= vb_simple_youtube_post_tag();
	$found		= strpos($wall,$pretag,null);
	while($found !== false)
	{
		$foundend = strpos($wall,$posttag,$found+strlen($pretag));
		if($foundend === false)
		{
			$found = false;
		} else {
			$videoid = '';
			$videoid = substr($wall, $found+strlen($pretag), $foundend-($found+strlen($pretag)));
			$wall 	 = str_replace($pretag.$videoid.$posttag,
				'<object width="425" height="350" data="http://www.youtube.com/v/'.$videoid.'" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/'.$videoid.'" /></object>'			
				, $wall);
			
			$lastfound = $found;
			$found = strpos($wall,$pretag,$lastfound+strlen($pretag));
		}
	}
	return $wall;
}


add_filter('the_content', 'vb_simple_youtube_content',vb_simple_youtube_priority());



?>