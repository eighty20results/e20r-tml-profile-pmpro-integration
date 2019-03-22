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


class Register_Profile_Fields {
	
	/**
	 * Instance of this class (singleton)
	 *
	 * @var null|Register_Profile_Fields
	 *
	 * @since v1.0
	 */
	private static $instance = null;
	
	/**
	 * List of defined TML fields created for Register Helper compatibility
	 *
	 * @var \Theme_My_Login_Form_Field[] $tml_fields
	 *
	 * @since v1.0
	 */
	private $tml_fields = array();
	
	/**
	 * List of input (field) types supported by TML
	 *
	 * @var string[] $allowed_types
	 *
	 * @since v1.0
	 */
	private $allowed_types = array();
	
	/**
	 * List of RH Types and what TML field they map to
	 *
	 * @var string[]
	 *
	 * @since v1.0
	 */
	private $rh_tml_type_map = array();
	
	/**
	 * The priority (location) on the TML profile page
	 *
	 * @var int $current_tml_priority
	 *
	 * @since v1.0
	 */
	private $current_tml_priority = 0;
	
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
	 * Add a Register Helper field to the TML profile page
	 *
	 * @param string $field_name
	 * @param string $rh_type
	 * @param string $label
	 * @param mixed  $value
	 * @param string $element_id
	 * @param int    $priority
	 * @param string $form_name
	 *
	 * @since v1.0
	 */
	public static function addToTML( $field_name, $value, $rh_type = 'text', $label = null, $element_id = null, $priority = 1, $form_name = 'profile' ) {
		
		$me = self::getInstance();
		
		// Map RH field (types) to TML field type(s)
		$tml_type     = $me->getTMLFieldType( $rh_type );
		$tml_priority = $me->current_tml_priority;
		
		try {
			$tml_priority = $me->calculateTMLPriority( $priority );
		} catch ( \Exception $exception ) {
			trigger_error( "Error: " . $exception->getMessage(), E_USER_ERROR );
		}
		
		$me->tml_fields["{$form_name}_{$field_name}"] =
			tml_add_form_field( $form_name, $field_name, array(
					'type'     => $tml_type,
					'label'    => $label,
					'value'    => $value,
					'id'       => $element_id,
					'priority' => $tml_priority,
				)
			);
	}
	
	/**
	 *
	 */
	public static function saveForTML() {
	
	}
	/**
	 * Instantiate and return (or just return) the singleton instance of this class
	 *
	 * @return Register_Profile_Fields|null
	 *
	 * @since v1.0
	 */
	public static function getInstance() {
		
		if ( true === is_null( self::$instance ) ) {
			self::$instance = new self();
			
			self::$instance->allowed_types = apply_filters( 'e20r-tppi-allowed-tml-types', array(
					'text',
					'textarea',
					'checkbox',
					'radio-group',
					'dropdown',
					'hidden',
					'custom',
				)
			);
		}
		
		return self::$instance;
	}
	
	/**
	 * Fetch the corresponding TML field type (using the Register Helper field type)
	 *
	 * @param string $rh_field_type
	 *
	 * @return string
	 *
	 * @since v1.0
	 */
	public function getTMLFieldType( $rh_field_type ) {
		
		$rh_tml_map = apply_filters( 'e20r-tppi-rh-tml-type-map', $this->rh_tml_type_map, $rh_field_type );
		
		return $rh_tml_map[ $rh_field_type ];
	}
	
	/**
	 * Generate the priority number to use for the TML form field registration
	 *
	 * @param int $priority
	 *
	 * @return int
	 *
	 * @throws \Exception
	 *
	 * @since v1.0
	 */
	public function calculateTMLPriority( $priority = 1 ) {
		
		if ( ! is_int( $priority ) ) {
			throw new \Exception( __( 'Invalid priority value for the TML field!', 'e20r-tml-profile-pmpro-integration' ) );
		}
		
		if ( empty( $this->current_tml_priority ) ) {
			$this->current_tml_priority = 1;
		}
		
		if ( 1 === $priority && 1 !== $this->current_tml_priority ) {
			return $this->current_tml_priority ++;
		}
		
		// Caller has a specific priority they want
		$this->current_tml_priority = $priority;
		
		// Return the current priority value for the TML field
		return $this->current_tml_priority;
	}
}