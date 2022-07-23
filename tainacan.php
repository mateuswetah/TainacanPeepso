<?php
/**
 * Plugin Name: PeepSo Tools: Tainacan
 * Plugin URI: https://peepso.com
 * Description: Plugin template for development of PeepSo addons
 * Author: PeepSo
 * Author URI: https://peepso.com
 * Version: 5.1.0.1
 * Copyright: (c) 2015 PeepSo, Inc. All Rights Reserved.
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tainacan-peepso
 * Domain Path: /language
 *
 * We are Open Source. You can redistribute and/or modify this software under the terms of the GNU General Public License (version 2 or later)
 * as published by the Free Software Foundation. See the GNU General Public License or the LICENSE file for more details.
 * This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
 */

class PeepSoTainacan
{
	private static $_instance = NULL;

	const PLUGIN_NAME	 = 'Tools: Tainacan';
	const PLUGIN_VERSION = '5.1.0.1';
	const PLUGIN_RELEASE = ''; //ALPHA1, BETA10, RC1, '' for STABLE

    public $widgets = array(
        'PeepSoWidgetTainacan',
    );

    private static function ready() {
        return(class_exists('PeepSo') && self::PLUGIN_VERSION.self::PLUGIN_RELEASE == PeepSo::PLUGIN_VERSION.PeepSo::PLUGIN_RELEASE);
    }

	/**
	 * peepso_all_plugins filter integration
	 * PEEPSO_VER_MIN is the minimum REQUIRED PeepSo version - if PeepSo is BELOW this number, disable self
	 * PEEPSO_VER_MAX is the maximum TESTED PeepSo version -  if PeepSo is ABOVE this number, render a a warning
	 * Hooking into peepso_all_plugins without these two constants will result in strict version lock
	 */

	private function __construct()
	{
        /** VERSION INDEPENDENT hooks **/

        // Admin
        if (is_admin()) {
            add_action('admin_init', array(&$this, 'peepso_check'));
        }

        // Compatibility
        add_filter('peepso_all_plugins', function($plugins) {
            $plugins[plugin_basename(__FILE__)] = get_class($this);
            return $plugins;
        });

        // Activation
        register_activation_hook(__FILE__, function() {
            if (!$this->peepso_check()) {
                return (FALSE);
            }

            require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . 'activate.php');
            $install = new PeepSoTainacanInstall();
            $res = $install->plugin_activation();
            if (FALSE === $res) {
                // error during installation - disable
                deactivate_plugins(plugin_basename(__FILE__));
            }
            return (TRUE);
        });

        /** VERSION LOCKED hooks **/
        if(self::ready()) {
            if (is_admin()) {
                add_action('admin_init', array(&$this, 'peepso_check'));
            }

            add_action('peepso_init', array(&$this, 'init'));

            // Navigation
            add_filter('peepso_navigation_profile', function($links){

                // do nothing if the option is disabled
                if(0==PeepSo::get_option('tainacan_profiles_enable',1)) {
                    return $links;
                }

                // do nothing if "owner only" is enabled and we are loading someone elses profile
                if(1==PeepSo::get_option('tainacan_profiles_owner_only',0)) {
                    if(isset($links['_user_id']) && get_current_user_id() != $links['_user_id']) {
                        return $links;
                    }
                }

                $links['tainacan'] = array(
                    'href' => PeepSo::get_option('tainacan_profiles_slug', 'tainacan', TRUE),
                    'label'=> PeepSo::get_option('tainacan_profiles_label', __('Tainacan', 'tainacan-peepso'), TRUE),
                    'icon' => PeepSo::get_option('tainacan_profiles_icon', 'ps-icon-gift', TRUE),
                );

                return $links;
            });

            // Widgets
            add_filter('peepso_widgets', array(&$this, 'register_widgets'));
        }


	}

	public static function get_instance()
	{
		if (NULL === self::$_instance) {
			self::$_instance = new self();
		}
		return (self::$_instance);
	}

	public function init()
	{
		PeepSo::add_autoload_directory(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
		PeepSoTemplate::add_template_directory(plugin_dir_path(__FILE__));

		if (is_admin()) {
			add_action('admin_init', array(&$this, 'peepso_check'));

			add_filter('peepso_admin_config_tabs', function( $tabs ) {
                $tabs['tainacan'] = array(
                    'label' => __('Tainacan', 'tainacan-peepso'),
                    // Icon by  Smashicons @ FlatIcon.com - licensed CC 3.0 BY
                    // https://www.flaticon.com/authors/smashicons
                    'icon' => 'https://secure.gravatar.com/avatar/5c98c0d57ae70c38010833156a1f0b4e?s=100&d=mm&r=g   ',
                    'tab' => 'tainacan',
                    'function' => 'PeepSoConfigSectionTainacan',
                );

                return $tabs;
            });

		} else {
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        }
        
        // Render the profile segment attached via peepso_navigation_profile
        $profile_slug = PeepSo::get_option('tainacan_profiles_slug', 'tainacan', TRUE);

        add_action('peepso_profile_segment_' . $profile_slug, function () {

            $this->view_user_id = PeepSoUrlSegments::get_view_id(PeepSoProfileShortcode::get_instance()->get_view_user_id());

            // Verify if the option is enabled and the user has the right to come here.
            $continue = TRUE;

            // If tabs are disabled
            if(0==PeepSo::get_option('tainacan_profiles_enable',1)) { $continue = FALSE; }

            // Or "Owner Only" is enabled and we are not the owner
            if(1==PeepSo::get_option('tainacan_profiles_owner_only',0)) {
                if(get_current_user_id() !=  $this->view_user_id) {
                    $continue = FALSE;
                }
            }

            if($continue) {
                // If everything is OK, print the HTML
                echo PeepSoTemplate::exec_template('tainacan', 'profile-tainacan', array('view_user_id' => $this->view_user_id), TRUE);
            } else {
                // If not, redirect gracefully to profile home
                PeepSo::redirect(PeepSoUser::get_instance($this->view_user_id)->get_profileurl());
            }
        });

        add_filter('peepso_widgets', array(&$this, 'register_widgets'));
	}

	/**
	 * Check if PeepSo class is present (PeepSo is installed and activated)
	 * If there is no PeepSo, immediately disable the plugin and display a warning
	 * @return bool
	 */
	public function peepso_check()
	{
		if (!class_exists('PeepSo')) {

			add_action('admin_notices', function(){
                ?>
                <div class="error peepso">
                    <strong>
                        <?php echo sprintf(__('The %s plugin requires the PeepSo plugin to be installed and activated.', 'tainacan-peepso'), self::PLUGIN_NAME);?>
                    </strong>
                </div>
                <?php
            });

			unset($_GET['activate']);
			deactivate_plugins(plugin_basename(__FILE__));
			return (FALSE);
		}

		return (TRUE);
	}

	public function enqueue_scripts()
	{
		wp_enqueue_style('tainacan-peepso', plugin_dir_url(__FILE__) . 'assets/css/tainacan.css', array('peepso'), self::PLUGIN_VERSION, 'all');
		wp_enqueue_script('tainacan-peepso', plugin_dir_url(__FILE__) . 'assets/js/tainacan.js', array('peepso'), self::PLUGIN_VERSION, TRUE);
    }
    
    /**
     * Callback for the core 'peepso_widgets' filter; appends our widgets to the list
     * @param $widgets
     * @return array
     */
    public function register_widgets($widgets)
    {
        // register widgets
        // @TODO that's too hacky - why doesn't autoload work?
        foreach (scandir($widget_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR) as $widget) {
            if(strlen($widget)>=5) require_once($widget_dir . $widget);
        }

        return array_merge
        
        ($widgets, $this->widgets);
    }

}

PeepSoTainacan::get_instance();

// EOF