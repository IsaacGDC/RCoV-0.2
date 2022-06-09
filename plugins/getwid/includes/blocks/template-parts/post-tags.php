<?php

namespace Getwid\Blocks;

class PostTags extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/template-post-tags';
	protected static $assetsHandle = 'getwid/template-parts';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    'blockDivider' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'textColor' => array(
                        'type' => 'string'
                    ),
                    'customTextColor' => array(
                        'type' => 'string'
                    ),
                    'backgroundColor' => array(
                        'type' => 'string'
                    ),
                    'customBackgroundColor' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'icon' => array(
                        'type' => 'string',
                        'default' => 'fas fa-tags'
                    ),
                    'iconColor' => array(
                        'type' => 'string'
                    ),
                    'customIconColor' => array(
                        'type' => 'string'
                    ),
                    'fontSize' => array(
                        'type' => 'string'
                    ),
                    'customFontSize' => array(
                        'type' => 'string'
                    ),
                    'divider' => array(
                        'type' => 'string',
                        'default' => ','
                    ),
                    'textAlignment' => array(
                        'type' => 'string'
                    ),
                    'className' => array(
                        'type' => 'string'
                    )
                ),
                'render_callback' => [ $this, 'render_callback' ]
            )
        );
    }

    private function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		if ( FALSE == getwid()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		add_filter( 'getwid/optimize/assets',
			function ( $assets ) {
				$assets[] = self::$assetsHandle;

				return $assets;
			}
		);

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$assetsHandle,
			getwid_get_plugin_url( 'assets/blocks/template-parts/style' . $rtl . '.css' ),
			[],
			getwid()->settings()->getVersion()
		);
    }

    public function render_callback( $attributes, $content ) {

        //Not BackEnd render if we view from template page
        if ( ( get_post_type() == getwid()->postTemplatePart()->postType ) || ( get_post_type() == 'revision' ) ) {
            return $content;
        }

        $block_name = 'wp-block-getwid-template-post-tags';
        $wrapper_class = $block_name;

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' '.esc_attr( $attributes[ 'className' ] );
        }

        if ( isset( $attributes[ 'divider' ] ) && $attributes[ 'divider' ] != '' ) {
            $wrapper_class .= ' has-divider';
        }

        if ( isset( $attributes[ 'textAlignment' ]) ) {
            $wrapper_style .= 'text-align: '.esc_attr( $attributes[ 'textAlignment' ] ) . ';';
        }

        if ( isset( $attributes[ 'customFontSize' ] ) ) {
			$font_size = is_numeric( $attributes['customFontSize'] ) ? $attributes['customFontSize'] . 'px' : $attributes['customFontSize'];
            $wrapper_style .= 'font-size: ' . esc_attr( $font_size ) . ';';
        }

        if ( isset( $attributes[ 'fontSize'] ) ) {
            $wrapper_class .= ' has-' . esc_attr( $attributes[ 'fontSize' ] ) . '-font-size';
        }

        $divider = isset( $attributes['divider'] ) && $attributes[ 'divider' ] != '' ? $attributes[ 'divider' ] : '';

        $is_back_end = getwid_is_block_editor();

        getwid_custom_color_style_and_class( $wrapper_style, $wrapper_class, $attributes, 'color', $is_back_end );

        $tags_list = get_the_tag_list( '', '');

        $icon_class = '';
        $icon_style = '';
        getwid_custom_color_style_and_class( $icon_style, $icon_class, $attributes, 'color', $is_back_end, [ 'color' => 'iconColor', 'custom' => 'customIconColor' ] );

        $result = '';

        $extra_attr = array(
            'wrapper_class' => $wrapper_class,
            'wrapper_style' => $wrapper_style,

            'divider'    => $divider,
            'icon_class' => $icon_class,
            'icon_style' => $icon_style
        );

        if ($tags_list) {
            ob_start();

            getwid_get_template_part( 'template-parts/post-tags', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

		$this->block_frontend_assets();

        return $result;
    }
}

new \Getwid\Blocks\PostTags();
