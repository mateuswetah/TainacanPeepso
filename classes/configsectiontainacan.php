<?php

class PeepSoConfigSectionTainacan extends PeepSoConfigSectionAbstract
{
	// Builds the groups array
	public function register_config_groups()
	{
		$this->context='left';
		$this->profiles();

		$this->context='right';
		$this->examples();
	}


	/**
	 * General Settings Box
	 */
	private function profiles()
	{
        // # Enable profile integration
        $this->args('descript', __('Enabled: Tainacan tab will show in user profiles.','tainacan-peepso'));
        $this->set_field(
            'tainacan_profiles_enable',
            __('Enabled', 'tainacan-peepso'),
            'yesno_switch'
        );

        // # Show to owner only
        $this->args('descript', __('Enabled: users will see the Tainacan tab only on their own profiles.','tainacan-peepso'));
        $this->set_field(
            'tainacan_profiles_owner_only',
            __('Profile owner only', 'tainacan-peepso'),
            'yesno_switch'
        );

        // # Label
        $this->args('descript', __('Leave empty for default.','tainacan-peepso'));
        $this->set_field(
            'tainacan_profiles_label',
            __('Menu label', 'tainacan-peepso'),
            'text'
        );

        // # Slug
        $this->args('descript', __('Leave empty for default. Be careful not to use a slug that is already taken, for example "photos", "videos" etc.','tainacan-peepso'));
        $this->set_field(
            'tainacan_profiles_slug',
            __('Menu slug', 'tainacan-peepso'),
            'text'
        );

        // # Icon
        $this->args('descript', __('Icon CSS class override. Leave empty for default','tainacan-peepso'));
        $this->set_field(
            'tainacan_profiles_icon',
            __('Menu icon', 'tainacan-peepso'),
            'text'
        );


		$this->set_group(
			'peepso_tainacan_general',
			__('Profile integration', 'tainacan-peepso')
		);
	}

	/**
	 * Custom Greeting Box
	 */
	private function examples()
	{
	    // # EXAMPLE DROP-DOWN
        // Add "options" parameter (array) to the next field
        $options = array(
            'one' => __('Option 1', 'tainacan-peepso'),
            'two' => __('Option 2', 'tainacan-peepso'),
            'three' => __('Option 3', 'tainacan-peepso'),
        );

        // args(key, value)
        $this->args('options', $options);

        // set_field() will take all previously set args and reset them after the field is rendered
        $this->set_field(
            'tainacan_example_dropdown',
            __('Eample drop-down', 'tainacan-peepso'),
            'select'
        );


        // # EXAMPLE TEXT FIELD
		$this->set_field(
			'tainacan_example_text',
			__('Example text field', 'tainacan-peepso'),
			'text'
		);

		// #EXAMPLE INT FIELS
        // The next has to be a number
        $this->args('int', TRUE);
        $this->args('validation', array('required','numeric'));

        // If we didn't specify a default during plugin activation, we can do it now
        $this->args('default', 1);

        // Once again the args will be included automatically. Note that args set before previous field are gone
        $this->set_field(
            'tainacan_example_int',
            __('Example int field', 'tainacan-peepso'),
            'text'
        );

		$this->set_group(
			'tainacan_examples',
			__('Example config options', 'tainacan-peepso')
		);
	}
}