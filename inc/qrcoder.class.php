<?php
require_once(dirname(__FILE__).'/settings.class.php');

class QRCoder {
	/**
	 * Costruttore della classe
	 */
	public function __construct() {
		new QRCoderSettings();
		
		add_action('add_meta_boxes', array($this, 'addAdminPostQRCode'));
	}
	
	/**
	 * Aggiunge il QR Code alla pagina
	 * @param string $post_type tipo del post
	 * @return string
	 */
	public function addAdminPostQRCode($post_type) {
		$post_types = QRCoderSettings::getPostTypes();
		if (!empty($post_types)) {
			add_meta_box('qr_coder_meta_box', 'QR Code', array($this, 'printPostQRCodeHtml'), $post_types, 'side');
		}
	}
	
	/**
	 * Stampa l'immagine HTML del QR Code di un post
	 * @param integer|WP_Post $post ID o oggetto del post
	 */
	public function printPostQRCodeHtml($post) {
		if (is_numeric($post) && $post > 0) {
			$post = get_post($post);
		}
		if (is_object($post) && $post instanceof WP_Post) {
			$url = get_permalink($post);
			if ($url) {
				$this->includeQrLib();
				$qrcode_big = (new \chillerlan\QRCode\QRCode(new \chillerlan\QRCode\QROptions(array(
					'outputType' => \chillerlan\QRCode\Output\QROutputInterface::GDIMAGE_PNG,
					'scale' => 50,
					'quietzoneSize' => 2
				))))->render($url);
				$qrcode = (new \chillerlan\QRCode\QRCode())->render($url);
				echo '<a href="'.esc_attr($qrcode_big).'" target="_blank"><img src="'.esc_attr($qrcode).'" alt="QR Code" /></a>';
			}
			unset($url);
		}
	}
	
	/**
	 * Include la libreria per generare i QR Code
	 */
	private function includeQrLib() {		
		require_once(dirname(__FILE__).'/vendor/autoload.php');
	}
}