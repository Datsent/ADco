<?php
namespace ElementorPro\Modules\Forms\Actions;

use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Slack extends Action_Base {

	public function get_name() {
		return 'slack';
	}

	public function get_label() {
		return __( 'Slack', 'elementor-pro' );
	}

	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_slack',
			[
				'label' => __( 'Slack', 'elementor-pro' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'slack_webhook',
			[
				'label' => __( 'Webhook URL', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'https://hooks.slack.com/services/',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the slack webhook URL that will receive the form\'s submitted data.', 'elementor-pro' ),
				'render_type' => 'none',
			]
		);

		$widget->add_control(
			'slack_channel',
			[
				'label' => __( 'Channel', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '#general',
				'description' => __( 'Enter the channel you want to receive the notification, if not specified the Webhook channel will be used.', 'elementor-pro' ),
			]
		);

		$widget->add_control(
			'slack_username',
			[
				'label' => __( 'Username', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Elementor Pro Forms', 'elementor-pro' ),
			]
		);

		$widget->add_control(
			'slack_title',
			[
				'label' => __( 'Title', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Form Submission.', 'elementor-pro' ),
			]
		);

		$widget->add_control(
			'slack_pretext',
			[
				'label' => __( 'Pre Text', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'New Form Submission.', 'elementor-pro' ),
				'description' => __( 'Optional text that appears above the notification', 'elementor-pro' ),
			]
		);

		$widget->add_control(
			'slack_text',
			[
				'label' => __( 'Text', 'elementor-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'A new Form Submission has been received.', 'elementor-pro' ),
				'description' => __( 'Optional text that appears within the notification', 'elementor-pro' ),
			]
		);

		$widget->add_control(
			'slack_webhook_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9c0244',
			]
		);

		$widget->add_control(
			'slack_add_fields',
			[
				'label' => __( 'Add Form Data', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'slack_add_ts',
			[
				'label' => __( 'Add Timestamp', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$widget->end_controls_section();
	}

	public function on_export( $element ) {
		unset(
			$element['slack_add_ts'],
			$element['slack_add_fields'],
			$element['slack_webhook_color'],
			$element['slack_text'],
			$element['slack_pretext'],
			$element['slack_title'],
			$element['slack_username'],
			$element['slack_webhook'],
			$element['slack_channel']
		);
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		if ( empty( $settings['slack_webhook'] ) || false === strpos( $settings['slack_webhook'], 'https://hooks.slack.com/services/' ) ) {
			return;
		}

		// Build slack webhook data
		$webhook_data = [
			'username' => isset( $settings['slack_username'] ) ? $settings['slack_username'] : 'Elementor Forms',
		];

		if ( ! empty( $settings['slack_channel'] ) ) {
			$webhook_data['channel'] = $settings['slack_channel'];
		}

		$attachment = [
			'text' => __( 'A new Form Submission has been received', 'elementor-pro' ),
			'title' => __( 'A new Submission', 'elementor-pro' ),
			'color' => isset( $settings['slack_webhook_color'] ) ? $settings['slack_webhook_color'] : '#9c0244',
			'title_link' => isset( $_POST['referrer'] ) ? $_POST['referrer'] : site_url(),
		];

		if ( ! empty( $settings['slack_title'] ) ) {
			$attachment['title'] = $settings['slack_title'];
		}

		if ( ! empty( $settings['slack_text'] ) ) {
			$attachment['text'] = $settings['slack_text'];
		}

		if ( ! empty( $settings['slack_pretext'] ) ) {
			$attachment['pretext'] = $settings['slack_pretext'];
		}

		if ( ! empty( $settings['slack_add_fields'] ) && 'yes' === $settings['slack_add_fields'] ) {
			// prepare Form Data
			$raw_fields = $record->get( 'fields' );
			$fields = [];
			foreach ( $raw_fields as $id => $field ) {
				$fields[] = [
					'title' => $field['title'] ? $field['title'] : $id,
					'value' => $field['value'],
					'short' => false,
				];
			}

			$attachment['fields'] = $fields;
		}

		if ( ! empty( $settings['slack_add_ts'] ) && 'yes' === $settings['slack_add_ts'] ) {
			$attachment = array_merge( $attachment, [
				'footer' => __( 'Elementor Pro', 'elementor-pro' ),
				'footer_icon' => is_ssl() ? ELEMENTOR_ASSETS_URL . 'images/logo-icon.png' : null,
				'ts' => time(),
			] );
		}

		$webhook_data['attachments'] = [ $attachment ];

		$webhook_data = apply_filters( 'elementor_pro/forms/slack/webhook_args', $webhook_data );

		$response = wp_remote_post( $settings['slack_webhook'], [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body' => wp_json_encode( $webhook_data ),
		] );

		if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			$ajax_handler->add_admin_error_message( 'Slack Webhook Error' );
		}
	}
}
