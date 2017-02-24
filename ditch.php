<?php
/**
 * Plugin Name: Ditch
 * Plugin URI: https://github.com/PonyDesignClub/ditch
 * Description: An opinionated plugin to ditch some standard WordPress functionality
 * Version: 1.0.1
 * Author: Daan Vos de Wael
 * Author URI: https://www.ponydesignclub.nl/
 * License: GPL-2.0+
 */

defined('ABSPATH') or die('These aren\'t the droids you\'re looking for...');

class ditch
{
  /**
   * Static property to hold our singleton instance
   */
  public static $instance = false;

  /**
   * Start up the core functionality of the plugin
   */
  public function __construct()
  {
    // wp_head
    add_action('after_setup_theme', [$this, 'disable_wp_head_functions']);

    // XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');

    // REST API
    add_filter('rest_authentication_errors', [$this, 'disable_rest_api']);

    // if we are in admin mode
    if (is_admin()) {
      // change menu capabilities for editor role
      $this->change_editor_role_caps();

      // change menu items
      add_action('admin_menu', [$this, 'change_main_menu_items']);

      // change admin bar items
      add_action('wp_before_admin_bar_render', [$this, 'change_admin_bar_items']);
    }
  }

  /**
   * If an instance exists, this returns it.  If not, it creates one and retuns it.
   */
  public static function getInstance()
  {
    if (!self::$instance instanceof self) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  /**
   * Calling all the remove functions for various standard inclusions made by WordPress
   */
  public function disable_wp_head_functions()
  {
    // General WP stuff
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('template_redirect', 'wp_shortlink_header', 11);

    // Real Simple Discovery & Windows Live Writer
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    // Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Next & Previous links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

    // RSS
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    // REST API
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('template_redirect', 'rest_output_link_header', 11);

    // oEmbed
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_oembed_register_route');
    remove_action('oembed_dataparse', 'wp_filter_oembed_result');

    // Resource hinting
    remove_action('wp_head', 'wp_resource_hints', 2);
  }

  /**
   * Disabling REST API for users not logged in.
   * WordPress depends too much on the API to disable site-wide.
   */
  public function disable_rest_api($access)
  {
    if (!is_user_logged_in()) {
      return new WP_Error('rest_cannot_access', 'Only authenticated users can access the REST API.', ['status' => rest_authorization_required_code()]);
    }

    return $access;
  }

  /**
   * Give Editor role the capability to edit menu's
   */
  private function change_editor_role_caps()
  {
    $role_object = get_role('editor');
    $role_object->add_cap('edit_theme_options');
  }

  /**
   * Remove the Tools menu item.
   * Remove the Themes submenu item (which was introduced by the new menu edit capability)
   */
  public function change_main_menu_items()
  {
    if (!current_user_can('install_themes')) {
      remove_menu_page('tools.php');
      remove_submenu_page('themes.php', 'themes.php');
    }
  }

  /**
   * Remove the 'New content' button in the Admin bar
   */
  public function change_admin_bar_items()
  {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('new-content');
  }
}

Ditch::getInstance();
