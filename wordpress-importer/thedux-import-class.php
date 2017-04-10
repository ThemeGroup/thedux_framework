<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class thedux_wp_import extends WP_Import
{
	function set_menus()
	{
		global $thedux_config;
		//get all registered menu locations
		$locations   = get_theme_mod('nav_menu_locations');
		
		//get all created menus
		$thedux_menus  = wp_get_nav_menus();
		
		if(!empty($thedux_menus) && !empty($thedux_config['nav_menus']))
		{
			foreach($thedux_menus as $thedux_menu)
			{
				//check if we got a menu that corresponds to the Menu name array ($thedux_config['nav_menus']) we have set in functions.php
				if(is_object($thedux_menu) && in_array($thedux_menu->name, $thedux_config['nav_menus']))
				{
					$key = array_search($thedux_menu->name, $thedux_config['nav_menus']);
					if($key)
					{
						//if we have found a menu with the correct menu name apply the id to the menu location
						$locations[$key] = $thedux_menu->term_id;
					}
				}
			}
		}
		//update the theme
		set_theme_mod( 'nav_menu_locations', $locations);
	}
}