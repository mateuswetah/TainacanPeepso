<?php
require_once(PeepSo::get_plugin_dir() . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'install.php');

class PeepSoTainacanInstall extends PeepSoInstall
{

	// optional default settings
	protected $default_config = array(
		#'TAINACAN' => '100',
	);

	public function plugin_activation( $is_core = FALSE )
	{
		// Set some default settings
		$settings = PeepSoConfigSettings::get_instance();
		$settings->set_option('tainacan_profiles_enable', 1);
		$settings->set_option('tainacan_example_int', 1);
		$settings->set_option('tainacan_example_text', 'Custom Tainacan');
		$settings->set_option('tainacan_example_dropdown', 'two');


		parent::plugin_activation($is_core);

		return (TRUE);
	}

	// optional DB table creation
	public static function get_table_data()
	{
		$aRet = array(
			'tainacan' => "
				CREATE TABLE tainacan (
					hlw_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					PRIMARY KEY (tainacan_id),
				) ENGINE=InnoDB",
		);

		 return $aRet;
	}

	// optional notification emails
	public function get_email_contents()
	{
		$emails = array(
			'email_tainacan' => "Tainacan",
		);

		 return $emails;
	}

	// optional page with shortcode
	protected function get_page_data()
	{
		// default page names/locations
		$aRet = array(
			'tainacan' => array(
				'title' => __('Peepso Tainacan', 'tainacan-peepso'),
				'slug' => 'tainacan',
				'content' => '[peepso_tainacan]'
			),
		);

		return ($aRet);
	}
}