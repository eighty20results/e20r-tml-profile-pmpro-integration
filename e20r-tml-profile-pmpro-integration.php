<?php
/**
 *  Copyright (c) 2019. - Eighty / 20 Results by Wicked Strong Chicks.
 *  ALL RIGHTS RESERVED
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  You can contact us at mailto:info@eighty20results.com
 */

/*
Plugin Name: E20R Integration for PMPro and Theme My Login Profiles
Plugin URI: https://eighty20results.com/e20r-tml-rofile-pmpro-integration
Description: Add integration of Register Helper for the Profiles module of Theme My Login
Version: 1.0
Author: Eighty / 20 Results by Wicked Strong Chicks, LLC <thomas@eighty20results.com>
Author URI: https://eighty20results.com/thomas-sjolshagen/
License: GPL2
*/
namespace E20R\Integration\TPPI;

use E20R\Integration\TPPI\Register_Profile_Fields;

/**
 * Class TML_PMProRH
 * @package E20R\Integration\TPPI
 */
class TML_PMProRH {
	
	/**
	 * The singleton instance for this class
	 *
	 * @var null|TML_PMProRH
	 *
	 * @since v1.0
	 */
	private static $instance = null;
	
	/**
	 * TML_PMProRH constructor.
	 *
	 * @access private
	 *
	 * @since v1.0
	 */
	private function __construct() {}
	
	/**
	 * Deactivate the clone() magic method
	 *
	 * @access private
	 *
	 * @since v1.0
	 */
	private function __clone() {}
	
	/**
	 * Return or instantiate & return the TML_PMProRH class
	 *
	 * @return TML_PMProRH|null
	 *
	 * @since v1.0
	 */
	public static function getInstance() {
		
		if ( true === is_null( self::$instance )) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * Load all plugin specific action and filter handlers
	 *
	 * @since v1.0
	 */
	public function loadHooks() {
		
		// Check all required dependencies for this add-on
		add_action( 'init', array( $this, 'checkDependencies' ), -1 );
		
		// Load late
		add_action( 'init', array( Register_Helper::getInstance(), 'loadFieldsFromRH'), 9999 );
		
		// Handle validation and saving of TML fields from profile page
		add_action( 'profile_update', array( Register_Profile_Fields::getInstance(), 'saveForTML' ), 999 );
		add_filter( 'user_profile_update_errors', array( Register_Profile_Fields::getInstance(), 'validateRHFields' ), 999 );
	}
	
}

add_action( 'plugins_loaded', array( TML_PMProRH::getInstance(), 'loadHooks' ), -1 );