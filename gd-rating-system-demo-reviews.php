<?php

/*
Plugin Name:       GD Rating System Pro: Reviews Demo
Plugin URI:        https://rating.dev4press.com/
Description:       Control plugin for the GD Rating System Pro demo website.
Author:            Milan Petrovic
Author URI:        https://www.dev4press.com/
Text Domain:       gd-rating-system-demo-reviews
Version:           2.0
Requires at least: 4.9
Tested up to:      5.6
Requires PHP:      5.6
License:           GPLv3 or later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html

== Copyright ==
Copyright 2008 - 2020 Milan Petrovic (email: milan@gdragon.info)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gdrts_dt_dirname_basic = dirname( __FILE__ ) . '/';
$gdrts_dt_urlname_basic = plugins_url( '/gd-rating-system-demo-reviews/' );

define( 'GDRTS_DT_PATH', $gdrts_dt_dirname_basic );
define( 'GDRTS_DT_URL', $gdrts_dt_urlname_basic );

require_once( GDRTS_DT_PATH . 'core/demo.php' );
