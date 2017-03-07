<?php
/*
Plugin Name: SF Pride Festival Schedule
Plugin URI:  https://sfpride.org
Description: Render performances in a timetable
Version:     20170302
Author:      Jesse Oliver <jesseoliversanford@gmail.com>
Author URI:  oliverjesse.info
License:     Restricted
*/

require_once( plugin_dir_path( __FILE__ ) . 'lib/custom_post_type.php' );
require_once( plugin_dir_path( __FILE__ ) . 'lib/admin.php' );
require_once( plugin_dir_path( __FILE__ ) . 'lib/shortcode.php' );

