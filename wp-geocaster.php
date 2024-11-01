<?php
/*
Plugin Name: WP GeoCaster
Plugin URI: http://www.geoklix.com/wp-geocaster
Description: The first true all-in-one GeoCaster solution for WordPress, specifically designed for businesses who provide services in multiple countries, states and cities.Place short code [WPGEOCASTER] on you post, page.
Version: 1.0
Author:  Art Yeranosyan
Author URI: http://www.geoklix.com/wp-geocaster
License: GPL2 or later
*/

/*  Copyright 2013 Arthur Yeranosyan  (email : support@geoklix.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Define constants
define('WP_GEOCASTER', trailingslashit(basename(dirname(__FILE__))));
define('WPGEOC_DIR', WP_CONTENT_DIR . '/plugins/' . WP_GEOCASTER);
define('WPGEOC_URL', WP_CONTENT_URL . '/plugins/' . WP_GEOCASTER);

// Load language
load_plugin_textdomain('wp_geocaster', false, basename(dirname(__FILE__)) . '/languages');


include_once dirname(__FILE__) . '/install.php';
include_once dirname(__FILE__) . '/wpgeoc-pages.php';

/**
 * WP GegCaster Plugin Class.
 *
 */
class WP_Geocaster
{

    public $callback ='';

    /**
     * Constructor.
     *
     */

    public function __construct()
    {
        $this->install = new WPGECO_Install();
        $this->message = new WPGEOC_Message();
        $file = WP_CONTENT_DIR . '/plugins/' . basename(dirname(__FILE__)) . '/' . basename(__FILE__);
        register_activation_hook($file, array($this->install, 'init'));
        add_action('init', 'wpgeocstart');
        add_action('admin_menu', array($this, 'register_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('wp_footer', 'wpgeocend');
        add_filter('admin_notices', array($this->message, 'show'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
        add_shortcode('WPGEOCASTER', array($this, 'add_shortcode'));
    }

    /**
     * enqueue script and styles
     */
    public function admin_init()
    {
        $this->enqueue();
    }

    public function enqueue()
    {
        wp_register_script('sa_script', WPGEOC_URL . 'sascript.js', array('jquery'));
        wp_register_style('sa-style', WPGEOC_URL . 'style.css', array(), false);
        wp_enqueue_script('jquery');
        wp_enqueue_script('sa_script');
        wp_enqueue_style('sa-style');
    }

    /**
     * Handle the short code replacement
     *
     */
    public function add_shortcode()
    {

        $action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : 'display';

        if ($action == 'new')
            $action = 'add';

        $post = !empty($_REQUEST) ? $_REQUEST : '';

        $config = array(
            'page' => 'frontend',
            'action' => $action,
            'post' => $post
        );
        $adminPages = new WPGEOC_Pages();
        $adminPages->load($config);

    }

    /**
     * Register Admin Menu
     */
    public function register_menu()
    {
        $slug = 'wp-geocaster.php';

        add_menu_page('Wpgeoc Menu', 'WP GeoCaster', 'manage_options', $slug, create_function('', "wp_geocaster_create_page('countries');"));
        add_submenu_page($slug, 'Countries', 'Countries', 'manage_options', 'wpgeoc-countries', create_function('', "wp_geocaster_create_page('countries');"));
        add_submenu_page($slug, 'Cities', 'Cities', 'manage_options', 'wpgeoc-cities', create_function('', "wp_geocaster_create_page('cities');"));
    }
}

/**
 * Create admin pages
 * @param null $page
 */
function wp_geocaster_create_page($page = null)
{
    $action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : 'display';

    if ($action == 'new')
        $action = 'add';

    $post = !empty($_REQUEST) ? $_REQUEST : '';

    $config = array(
        'page' => $page,
        'action' => $action,
        'post' => $post
    );
    $adminPages = new WPGEOC_Pages();
    $adminPages->load($config);
}

function wpgeocstart()
{
    ob_start("wpgeoccallback");
    wpgeocStartSession();

}

function wpgeocStartSession(){
    if (!session_id()) {
        session_start();
    }
}

/**
 * Buffer end
 */
function wpgeocend()
{
    ob_end_flush();
}

/**
 * Load the buffer data
 *
 * @param $buffer
 * @return mixed
 */
function wpgeoccallback($buffer)
{
    return $buffer;
}


global $wp_geocaster;
$wp_geocaster = new WP_Geocaster();