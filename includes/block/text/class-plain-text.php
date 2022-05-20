<?php
/**
 * Plain Text
 *
 * @package    dorzki\SlackNotifications\Block\Text
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

namespace dorzki\SlackNotifications\Block\Text;

use dorzki\SlackNotifications\Base\Block_Text;
use dorzki\SlackNotifications\Enum\Text_Format;

defined( 'ABSPATH' ) || exit;


/**
 * Class Plain_Text
 *
 * @package dorzki\SlackNotifications\Block\Text
 */
class Plain_Text extends Block_Text {
	/**
	 * Plain_Text constructor.
	 */
	public function __construct() {
		$this->set_type( Text_Format::PLAIN );
		$this->set_emoji( true );
	}
}
