<?php
/**
 * Editor
 *
 * @package    dorzki\SlackNotifications
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications;

use dorzki\SlackNotifications\Base\Block;
use dorzki\SlackNotifications\Block\Divider;
use dorzki\SlackNotifications\Block\Footer;
use dorzki\SlackNotifications\Block\Header;
use dorzki\SlackNotifications\Block\Image;
use dorzki\SlackNotifications\Block\Image_Text;
use dorzki\SlackNotifications\Block\Link_Button;
use dorzki\SlackNotifications\Block\Text;
use dorzki\SlackNotifications\Block\Text_Group;
use dorzki\SlackNotifications\Exception\Duplication_Exception;
use InvalidArgumentException;

defined( 'ABSPATH' ) || exit;


/**
 * Class Editor
 *
 * @package dorzki\SlackNotifications
 */
class Editor {
	/** @var Block[] */
	protected $blocks = [];


	/**
	 * Editor constructor.
	 *
	 * @throws Duplication_Exception
	 */
	public function __construct() {
		$this->load_blocks();
	}


	/**
	 * Register plugin blocks.
	 *
	 * @return void
	 * @throws Duplication_Exception
	 *
	 * @since 2.1.0
	 */
	private function load_blocks() {
		$this->register_block(
			'header',
			esc_html__( 'Header', 'dorzki-notifications-to-slack' ),
			Header::class
		);

		$this->register_block(
			'footer',
			esc_html__( 'Footer', 'dorzki-notifications-to-slack' ),
			Footer::class
		);

		$this->register_block(
			'divider',
			esc_html__( 'Divider', 'dorzki-notifications-to-slack' ),
			Divider::class
		);

		$this->register_block(
			'text',
			esc_html__( 'Text', 'dorzki-notifications-to-slack' ),
			Text::class
		);

		$this->register_block(
			'text_group',
			esc_html__( 'Text Group', 'dorzki-notifications-to-slack' ),
			Text_Group::class
		);

		$this->register_block(
			'link_button',
			esc_html__( 'Link Button', 'dorzki-notifications-to-slack' ),
			Link_Button::class
		);

		$this->register_block(
			'image_text',
			esc_html__( 'Image with Text', 'dorzki-notifications-to-slack' ),
			Image_Text::class
		);

		$this->register_block(
			'image',
			esc_html__( 'Image', 'dorzki-notifications-to-slack' ),
			Image::class
		);
	}


	/**
	 * Register a new block.
	 *
	 * @param string $id    Block id.
	 * @param string $name  Block name.
	 * @param string $block Block class name.
	 *
	 * @return void
	 * @throws Duplication_Exception
	 *
	 * @since 2.1.0
	 */
	public function register_block( string $id, string $name, string $block ) : void {
		if ( empty( $id ) || empty( $name ) || empty( $block ) ) {
			throw new InvalidArgumentException( esc_html__( 'Block parameters are invalid.', 'dorzki-notifications-to-slack' ) );
		}

		if ( isset( $this->blocks[ $id ] ) ) {
			throw new Duplication_Exception( esc_html__( 'Block already exists.', 'dorzki-notifications-to-slack' ) );
		}

		$this->blocks[ $id ] = [
			'name'  => $name,
			'block' => $block,
		];
	}


	/**
	 * @return Block[]
	 */
	public function get_blocks() : array {
		return $this->blocks;
	}
}
