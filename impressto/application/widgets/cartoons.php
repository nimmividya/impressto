<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='cartoons']
//  direct from PHP code Widget::run('cartoons', array('name'=>'header'));
// within smarty {widget type='cartoons'}



class cartoons extends Widget
{
    function run() {

		$args = func_get_args();
				
		$this->load->spark('cloud_carousel'); // loading a spark simply means you are adding its path to autosearch and loading the spark config
		$this->load->helper('cloud_carousel');
		
		$images = array(
			array(
				'img'			=> 'homer.jpg',
				'img_alt'		=> 'Homer Simpson',
				'img_title'		=> '#3 Homer Simpson',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_dwyane_wade_1112.html',
				'href_target'	=> '_blank'
			),
			array(
				'img'			=> 'mr_burns.jpg',
				'img_alt'		=> 'Mister Burns',
				'img_title'		=> '#6 Mister Burns',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_lebron_james_1112.html',
				'href_target'	=> '_blank'
			),
			array(
				'img'			=> 'bart.jpg',
				'img_alt'		=> 'Bart Simpson',
				'img_title'		=> '#1 Bart Simpson',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_chris_bosh_1112.html',
				'href_target'	=> '_blank'
			),
			array(
				'img'			=> 'butthead.jpg',
				'img_alt'		=> 'Butthead',
				'img_title'		=> '#31 Butthead',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_shane_battier_1112.html',
				'href_target'	=> '_blank'
			),
			array(
				'img'			=> 'beavis.jpg',
				'img_alt'		=> 'Beavis',
				'img_title'		=> '#15 Beavis',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_mario_chalmers_1112.html',
				'href_target'	=> '_blank'
			),
			array(
				'img'			=> 'charlie_brown.jpg',
				'img_alt'		=> 'Charlie Brown',
				'img_title'		=> '#40 Charlie Brown',
				'href'			=> 'http://www.nba.com/heat/roster/heat_player_udonis_haslem_1112.html',
				'href_target'	=> '_blank'
			)
		);

		$config = array(
			'xPos'			=> 300,
			'yPos'			=> 100,
			'buttonLeft'	=> '$("#carousel-left-but")',
			'buttonRight'	=> '$("#carousel-right-but")',
			'altBox'		=> '$("#carousel-alt-text")',
			'titleBox'		=> '$("#carousel-title-text")',
			'mouseWheel'	=> true,
			'reflHeight'	=> 50,
			'reflGap'		=> 10,
			'reflOpacity'	=> .3,
			'bringToFront'	=> true
		);
		

		echo cloud_carousel($images,$config,'my-cloud-carousel');
		 
    }
} 

