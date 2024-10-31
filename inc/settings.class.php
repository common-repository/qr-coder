<?php
class QRCoderSettings {
	/**
	 * Costruttore della classe
	 */
	public function __construct() {
		add_action('admin_init', array($this, 'adminInit'));
	}
	
	/**
	 * Inizializzazione delle impostazioni nel pannello d'amministrazione
	 */
	public function adminInit() {
		register_setting('permalink', 'qrcoder_post_types', array(
			'type' => 'string'
		));
		add_settings_section(
			'qrcoder_settings_section',
			'QR Coder',
			null,
			'permalink'
		);
		add_settings_field(
			'qrcoder_post_types',
			__('Post Types'),
			array($this, 'postTypesField'),
			'permalink',
			'qrcoder_settings_section'
		);
		if (isset($_POST['qrcoder_post_types']) && is_array($_POST['qrcoder_post_types'])) {
			$this->savePostTypes($_POST['qrcoder_post_types']);
		}
	}
	
	/**
	 * Stampa il campo per selezionare i tipi di post
	 */
	public function postTypesField() {
		$qrcoder_post_types = self::getPostTypes();
		foreach (get_post_types(null, 'objects') as $type) {
			if ($type->public || $type->publicly_queryable) : ?>
				<label style="display:block;"><input type="checkbox" name="qrcoder_post_types[]" value="<?php echo esc_attr($type->name);?>"<?php if (in_array($type->name, $qrcoder_post_types)) : ?> checked="checked"<?php endif;?>> <?php echo esc_html($type->label);?></label>
			<?php endif;
		}
	}
	
	/**
	 * Salva i tipi di post
	 * @param array $types tipi
	 * @return boolean
	 */
	private function savePostTypes($types) {
		$res = false;
		if (is_array($types)) {
			foreach ($types as $k => $v) {
				$v = is_string($v) ? trim(sanitize_key($v)) : '';
				if ($v === '') {
					unset($types[$k]);
				} else {
					$types[$k] = $v;
				}
			}
			$types = array_values($types);
			$res = update_option('qrcoder_post_types', $types);
		}
		return $res;
	}
	
	/**
	 * Restituisce i tipi di post
	 * @return array
	 */
	public static function getPostTypes() {
		$types = get_option('qrcoder_post_types');
		return is_array($types) ? $types : array();
	}
}