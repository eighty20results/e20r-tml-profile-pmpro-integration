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

namespace E20R\Integration\TPPI;


class Register_Helper {
	
	/**
	 * @var null|Register_Helper
	 */
	private static $instance = null;
	
	/**
	 * Register_Profile_Fields constructor.
	 *
	 * @access private
	 *
	 * @since  v1.0
	 */
	private function __construct() {
	}
	
	/**
	 * Instantiate and return (or just return) the singleton instance of this class
	 *
	 * @return Register_Helper|null
	 *
	 * @since v1.0
	 */
	public static function getInstance() {
		
		if ( true === is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function loadFieldsFromRH() {
		
		global $pmprorh_registration_fields;
		
		if ( empty( $pmprorh_registration_fields ) ) {
		
		}
	}
}