<?php
/**
 * Settings -> Controls -> Section
 *
 * @package    dorzki\SlackNotifications\Settings\Control
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

namespace dorzki\SlackNotifications\Settings\Control;

use dorzki\SlackNotifications\Base\Settings_Control;
use dorzki\SlackNotifications\Enum\Control_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Section
 *
 * @package dorzki\SlackNotifications\Settings\Control
 */
class Section extends Settings_Control {
	/** @var Settings_Control[] */
	protected $options = [];


	/**
	 * Section constructor.
	 *
	 * @param string $id       Control id.
	 * @param string $label    Control label.
	 * @param array  $controls Control fields.
	 */
	public function __construct( string $id, string $label, array $controls = [] ) {
		parent::__construct( Control_Type::SECTION, $id, $label );

		$this->options = $controls;
	}


	/**
	 * @return Settings_Control[]
	 */
	public function get_options() : array {
		return $this->options;
	}
}
