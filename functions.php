<?php
//    require get_template_directory() . '/inc/block-patterns.php';
if ( ! function_exists( 'kedrmedia_supports' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function kedrmedia_supports() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'kedrmedia_supports' );

if ( ! function_exists( 'kedrmedia_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 * @since Twenty Twenty-Two 1.0
	 *
	 */
	function kedrmedia_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'kedrmedia-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);
		wp_register_style(
			'kedrmedia-bootstrap',
			get_template_directory_uri() . '/assets/css/bootstrap.min.css',
			array(),
			$version_string
		);


		// Add styles inline.
		wp_add_inline_style( 'kedrmedia-style', kedrmedia_get_font_face_styles() );
		wp_add_inline_style( 'kedrmedia-bootstrap', kedrmedia_get_font_face_styles() );

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'kedrmedia-bootstrap' );
		wp_enqueue_style( 'kedrmedia-style' );
		if ( is_singular() ) {
			wp_enqueue_style( 'adt-fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css', array(), wp_get_theme()->get( 'Version' ) );
		}
	}

endif;

add_action( 'wp_enqueue_scripts', 'kedrmedia_styles' );

if ( ! function_exists( 'kedrmedia_scripts' ) ) :
	function kedrmedia_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$version = is_string( $theme_version ) ? $theme_version : false;

		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js' );
		wp_enqueue_script( 'kedrmedia-scripts', get_template_directory_uri() . '/assets/js/common.js', null, $version, true  );
	}
endif;

add_action( 'wp_enqueue_scripts', 'kedrmedia_scripts' );

add_theme_support( 'post-formats', array( 'aside', 'gallery', 'video', 'audio' ) );

function add_fancybox() {
	if ( is_singular() ) {
		echo "<script src=\"https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js\"></script>";

		echo '<script type="text/javascript">
                Fancybox.bind("img.fancybox-image");
             </script>';
	}
}

add_action( 'wp_footer', 'add_fancybox' );


function add_image_fluid_class( $content ) {
	global $post;
	$pattern     = "/<img(.*?)class=\"(.*?)\"(.*?)>/i";
	$replacement = '<img$1class="$2 fancybox-image"$3>';
	$content     = preg_replace( $pattern, $replacement, $content );

	return $content;
}

add_filter( 'the_content', 'add_image_fluid_class' );

function img_responsive( $content ) {
	return str_replace( '<img class="', '<img class="img-responsive ', $content );
}

add_filter( 'the_content', 'img_responsive' );

if ( ! function_exists( 'kedrmedia_get_font_face_styles' ) ) :

	/**
	 * Get font face styles.
	 * Called by functions twentytwentytwo_styles() and twentytwentytwo_editor_styles() above.
	 *
	 * @return string
	 * @since Twenty Twenty-Two 1.0
	 *
	 */
	function kedrmedia_get_font_face_styles() {

		return "
		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: normal;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
		}

		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: italic;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Italic.ttf.woff2' ) . "') format('woff2');
		}
		";

	}

endif;


if ( function_exists( 'acf_add_options_page' ) ):

	acf_add_options_page( array(
		'page_title' => 'Настройка темы КедрМедиа',
		'menu_title' => 'Настройки темы',
		'menu_slug'  => 'theme-kedr-settings',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Главная страница',
		'menu_title'  => 'Компановка главной страницы',
		'menu_slug'   => 'theme-kedr-fronpage-settings',
		'parent_slug' => 'theme-kedr-settings',
		'capability'  => 'edit_posts',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Топ материалов',
		'menu_title'  => 'Топы',
		'menu_slug'   => 'theme-kedr-top-settings',
		'parent_slug' => 'theme-kedr-settings',
		'capability'  => 'edit_posts',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Партнеры',
		'menu_title'  => 'Партнеры',
		'menu_slug'   => 'theme-kedr-partners-settings',
		'parent_slug' => 'theme-kedr-settings',
		'capability'  => 'edit_posts',
	) );

//	acf_add_options_sub_page( array(
//		'page_title'  => 'Theme Footer Settings',
//		'menu_title'  => 'Footer',
//		'parent_slug' => 'theme-general-settings',
//	) );

endif;

// Support Bootstrap nav markup
function register_navwalker() {
	require_once get_template_directory() . '/includes/class-wp-bootstrap-navwalker.php';
}

add_action( 'after_setup_theme', 'register_navwalker' );

// Create theme menu
register_nav_menus( array(
	'primary' => __( 'Основное меню', 'kedrmedia' ),
	'footer'  => __( 'Меню футера', 'kedrmedia' ),
) );

// Change logo in wp-login page
function kedr_auth_logo() { ?>
    <style>
        body.login div#login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg);
            background-size: contain;
            padding-bottom: 30px;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'kedr_auth_logo' );

// Ensure all network sites include WebP support.
add_filter(
	'site_option_upload_filetypes',
	function ( $filetypes ) {
		$filetypes = explode( ' ', $filetypes );
		if ( ! in_array( 'webp', $filetypes, true ) ) {
			$filetypes[] = 'webp';
		}
		$filetypes = implode( ' ', $filetypes );

		return $filetypes;
	}
);

// Add thteme supports
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-logo' );

// Add fonts

//add_action('after_setup_theme', function() {
//    add_editor_style(array(
//        'https://fonts.googleapis.com/css2?family=Bona+Nova:wght@400;700&family=Raleway:ital,wght@0,200;0,400;0,600;0,700;1,400&display=swap'
//    ));
//    wp_register_style(
//        'kedrmedia-googlefonts',
//        'https://fonts.googleapis.com/css2?family=Bona+Nova:wght@400;700&family=Raleway:ital,wght@0,200;0,400;0,600;0,700;1,400&display=swap'
//    );
//
//    wp_enqueue_style('kedrmedia-googlefonts');
//});

/**
 * Check if given term has child terms
 *
 * @param Integer $term_id
 * @param String $taxonomy
 *
 * @return Boolean
 */
function category_has_children( $term_id = 0, $taxonomy = 'category' ) {
	$children = get_categories( array(
		'child_of'   => $term_id,
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
		'fields'     => 'ids',
	) );

	return ( $children );
}

//add_action( 'save_post_post', 'generate_social_thumbnail', 10, 3 );

// Изображение для социальных сетей
function generate_social_thumbnail( int $post_ID ) {
//	header( 'Content-Type: image/png' );
	$mediaism_social_thumbnail_suffix = '-' . $post_ID . '-social';

	// Параметры для генерации
	$max_width  = 1200;
	$max_height = 675;
//	$max_height = 630;
	$quality = 80;

	// Фон
	$url_to_image  = parse_url( wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) ) );
	$path_to_image = substr( $url_to_image['path'], 1 );
	if ( has_post_thumbnail( $post_ID ) ) {
		$path_to_image = substr( $url_to_image['path'], 1 );
	} else {
		$path_to_image = 'wp-content/uploads/social.png';
	}

	$path_to_new_image = stristr( $path_to_image, '.', true ) . $mediaism_social_thumbnail_suffix . '.png';

	$postcat = get_the_category( $post_ID );
	if ( $postcat[0]->term_id == 1133 ) {
		global $url_to_image;
		global $path_to_image;
		$url_to_image = get_stylesheet_directory() . '/assets/img/bg-social-news.png';
		$path_to_image = substr( $url_to_image, 28 );
	}

	// Узнаем размер текущего изображения
	list( $orig_width, $orig_height, $type ) = getimagesize( $path_to_image );

	// Считаем соотношение сторон.
	$width_ratio  = $max_width / $orig_width;
	$height_ratio = $max_height / $orig_height;

	// Ratio used for calculating new image dimensions.
	$ratio = min( $width_ratio, $height_ratio );

	// Calculate new image dimensions.
	$new_width  = (int) $orig_width * $width_ratio;
	$new_height = (int) $orig_height * $width_ratio;

	$new_position_x = $orig_height / 6;

	// Создем изображение.
	$new_image = imagecreatetruecolor( $max_width, $max_height );

	$mime = strtolower( image_type_to_mime_type( $type ) );

	if ( $mime == 'image/jpeg' ) {
		$image = imagecreatefromjpeg( $path_to_image );

	} elseif ( $mime == 'image/png' ) {
		$image = imagecreatefrompng( $path_to_image );
	}

	// imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
	imagecopyresized( $new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height );

	$new_image = @sampled_social_thumbnail( $post_ID, $new_image, $max_width, $max_height );

	if ( imagepng( $new_image, $path_to_new_image, floor( $quality / 10 ) ) ) {
		// Free up the memory.
		imagedestroy( $image );
		imagedestroy( $new_image );

	}

}

function sampled_social_thumbnail( $post_id, $new_image, $new_width, $new_height ) {
	$mediaism_social_thumbnail_logo           = get_template_directory_uri() . '/assets/img/logo-white.png';
	$mediaism_social_thumbnail_ttf            = get_template_directory_uri() . '/assets/fonts/social/Raleway-Bold.ttf';
	$mediaism_social_thumbnail_ttf_additional = get_template_directory_uri() . '/assets/fonts/social/Raleway-Regular.ttf';
	// Заливка
	$shadow = imagecreatetruecolor( $new_width, $new_height );

	// Логотип
	$url_to_logo  = parse_url( $mediaism_social_thumbnail_logo );
	$path_to_logo = substr( $url_to_logo['path'], 1 );
	$logo         = imagecreatefrompng( $path_to_logo );

	list( $logowidth, $logoheight ) = getimagesize( $path_to_logo );

	// Шрифт
	$url_to_font             = parse_url( $mediaism_social_thumbnail_ttf );
	$path_to_font            = substr( $url_to_font['path'], 1 );
	$url_to_font_additional  = parse_url( $mediaism_social_thumbnail_ttf_additional );
	$path_to_font_additional = substr( $url_to_font_additional['path'], 1 );

	// Надпись
	$text = get_the_title( $post_id );
	$lead = get_the_excerpt( $post_id );

	if ( mb_strlen( $lead ) > 100 ):
		$lead = mb_substr( $lead, 0, 100 );
		$lead .= '...';
	endif;

	$category_data = get_the_category( $post_id );
	$category      = $category_data[0]->name;

	// Цвета
	$white   = imagecolorallocate( $new_image, 255, 255, 255 );
	$primary = imagecolorallocate( $new_image, 52, 129, 94 );
	$black   = imagecolorallocate( $new_image, 0, 0, 0 );

	$postcat = get_the_category( $post_id );
	if ( $postcat[0]->term_id == 1133 ) {

		// Наложили лого
//		imagecopyresampled( $new_image, $logo, 60, 30, 0, 0, $new_width, $new_height, $new_width, $new_height );

		// Работа с текстом
		$margin     = 20;
		$write_text = explode( "\n", wordwrap( $text, 60 ), 10 );
		$dimensions = imagettfbbox( 34, 0, $path_to_font, $write_text );

		$delta_y = - 20;

		// Центрирование по вертикали
		$y = ( imagesy( $new_image ) - ( ( $dimensions[1] - $dimensions[7] ) + $margin ) * count( $write_text ) ) / 2;

		// Категория
		imagettftext( $new_image, 26, 0, 60, $y - 34, $white, $path_to_font, $category );

		// Построчный вывод текста
		foreach ( $write_text as $line ) {
			// $dimensions = imagettfbbox(26, 0, $path_to_font, $line);
			$delta_y  = $delta_y + ( $dimensions[1] - $dimensions[7] ) + $margin * 3;
			$last_row = $y + $delta_y;

			imagettftext( $new_image, 44, 0, 60, $last_row, $white, $path_to_font, $line );
		}

	} else {

		// Наложили тень
		imagecopymerge( $new_image, $shadow, 0, 0, 0, 0, $new_width, $new_height, 50 );

		// Наложили лого
		imagecopyresampled( $new_image, $logo, 60, 30, 0, 0, $new_width, $new_height, $new_width, $new_height );

		// Работа с текстом
		$margin          = 20;
		$write_text      = explode( "\n", wordwrap( $text, 50 ), 10 ); // Меняется число символов строке
		$write_lead      = explode( "\n", wordwrap( $lead, 70 ), 10 );
		$dimensions      = imagettfbbox( 44, 0, $path_to_font, $write_text );
		$dimensions_lead = imagettfbbox( 42, 0, $path_to_font_additional, $write_lead );

		$delta_y  = - 20;
		$last_row = 0;

		// Центрирование по вертикали
		$y = ( imagesy( $new_image ) - ( ( $dimensions[1] - $dimensions[7] ) + $margin ) * count( $write_text ) ) / 2;

		// Категория
		imagettftext( $new_image, 26, 0, 60, $y - 34, $primary, $path_to_font, $category );


		// Построчный вывод текста
		foreach ( $write_text as $line ) {
			// $dimensions = imagettfbbox(26, 0, $path_to_font, $line);
			$delta_y  = $delta_y + ( $dimensions[1] - $dimensions[7] ) + $margin * 3;
			$last_row = $y + $delta_y;

			imagettftext( $new_image, 44, 0, 60, $last_row, $white, $path_to_font, $line );
		}

		// Построчный вывод лида
		$last_row += 20;
		foreach ( $write_lead as $line ) {
			// $dimensions = imagettfbbox(26, 0, $path_to_font, $line);
			$last_row = $last_row + ( $dimensions_lead[1] - $dimensions_lead[7] ) + $margin * 2.5;

			imagettftext( $new_image, 36, 0, 60, $last_row, $white, $path_to_font_additional, $line );
		}

	}

	return $new_image;

}

// Вывод социального изображения
function get_social_thumbnail( $post_id = 0, $mediaism_social_thumbnail_suffix = '-social' ) {
	if ( $post_id == 0 ) {
		global $post;
		$post    = get_post( $post );
		$post_id = $post->ID;
	}


	if ( has_post_thumbnail( $post_id ) ) {
		$url_to_image        = parse_url( get_the_post_thumbnail_url( $post_id ) );
		$type_image          = stristr( $url_to_image['path'], '.' );
		$url_to_social_image = 'https://' . $url_to_image['host'] . stristr( $url_to_image['path'], '.', true ) . '-' . $post_id . $mediaism_social_thumbnail_suffix . '.png';
	} else {
		$url_to_social_image = 'https://kedr.media/wp-content/uploads/social-' . $post_id . $mediaism_social_thumbnail_suffix . '.png';
	}


	return $url_to_social_image;

}

function the_social_thumbnail( $post_id ) {

	echo get_social_thumbnail( $post_id );

}

add_action( 'init', 'create_taxonomy' );
function create_taxonomy() {

	register_taxonomy( 'project', [ 'post' ], [
		'label'        => '',
		// определяется параметром $labels->name
		'labels'       => [
			'name'              => 'Проекты',
			'singular_name'     => 'Проект',
			'search_items'      => 'Искать проект',
			'all_items'         => 'Все проекты',
			'view_item '        => 'Открыть проект',
			'parent_item'       => 'Родитель',
			'parent_item_colon' => 'Родитель:',
			'edit_item'         => 'Редактировать проект',
			'update_item'       => 'Обновить проект',
			'add_new_item'      => 'Добавить проект',
			'new_item_name'     => 'Имя проекта',
			'menu_name'         => 'Проект',
			'back_to_items'     => '← Назад в проекты',
		],
		'description'  => '',
		'public'       => true,
		'hierarchical' => true,

		'rewrite'           => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'      => array(),
		'meta_box_cb'       => null,
		// html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column' => false,
		// авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'      => true,
		// добавить в REST API
		'rest_base'         => true,
		// $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );
}

add_action( 'init', 'create_region_taxonomy' );
function create_region_taxonomy() {

	register_taxonomy( 'region', [ 'post' ], [
		'label'        => '',
		// определяется параметром $labels->name
		'labels'       => [
			'name'              => 'Регионы',
			'singular_name'     => 'Регион',
			'search_items'      => 'Искать регион',
			'all_items'         => 'Все регионы',
			'view_item '        => 'Открыть регион',
			'parent_item'       => 'Родитель',
			'parent_item_colon' => 'Родитель:',
			'edit_item'         => 'Редактировать регион',
			'update_item'       => 'Обновить регион',
			'add_new_item'      => 'Добавить регион',
			'new_item_name'     => 'Имя региона',
			'menu_name'         => 'Регион',
			'back_to_items'     => '← Назад в регионы',
		],
		'description'  => '',
		'public'       => true,
		'hierarchical' => true,

		'rewrite'           => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'      => array(),
		'meta_box_cb'       => null,
		// html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column' => false,
		// авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'      => 1,
		// добавить в REST API
		'rest_base'         => 'regions',
		// $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );
}

// ACF
if ( function_exists( 'acf_add_local_field_group' ) ):

	acf_add_local_field_group( array(
		'key'                   => 'group_627bd41640bdd',
		'title'                 => 'Внешнее видео',
		'fields'                => array(
			array(
				'key'               => 'field_627bd41d7b5e6',
				'label'             => 'Фрейм',
				'name'              => 'video_frame',
				'type'              => 'textarea',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'maxlength'         => '',
				'rows'              => '',
				'new_lines'         => '',
			),
			array(
				'key'               => 'field_6295d63a0f392',
				'label'             => 'Алтернативый лид',
				'name'              => 'alt_excerpt',
				'type'              => 'textarea',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'maxlength'         => '',
				'rows'              => '',
				'new_lines'         => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 1,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_627bbcd25adf8',
		'title'                 => 'Настройки главной страницы',
		'fields'                => array(
			array(
				'key'               => 'field_627bbcdb227eb',
				'label'             => 'Последние материалы',
				'name'              => 'frontpage-latestpost',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_627bbd63227ec',
						'label'             => 'Кол-во материалов',
						'name'              => 'posts_per_page',
						'type'              => 'number',
						'instructions'      => 'Этот параметр регулирует общее кол-во выводимых материалов в первом блоке',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '25',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 8,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => 1,
						'max'               => '',
						'step'              => '',
					),
					array(
						'key'               => 'field_627bbdac227ed',
						'label'             => 'Кол-во крупных блоков сверху',
						'name'              => 'primary_posts',
						'type'              => 'number',
						'instructions'      => 'Крупные (primary) блоки перед лентой карточек',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '25',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 2,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					),
					array(
						'key'               => 'field_629e41d2bc1b2',
						'label'             => 'Дополнительные записи после видео',
						'name'              => 'additional_posts',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '20',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_629e41ffbc1b3',
						'label'             => 'Количество дополнительных записей',
						'name'              => 'count_additional_posts',
						'type'              => 'number',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					),
				),
			),
			array(
				'key'               => 'field_6295c56a54804',
				'label'             => 'Крупный блок',
				'name'              => 'primary_end',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_6295c56a54805',
						'label'             => 'Отобразить блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '20',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_6295c56a54806',
						'label'             => 'Выбрать запись',
						'name'              => 'selected_post',
						'type'              => 'true_false',
						'instructions'      => 'Если вы хотите указать конкретную запись - установите ее вручную. В автоматическом режиме, будет выводиться последняя запись из категории Видео',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Вручную',
						'ui_off_text'       => 'Последняя',
					),
					array(
						'key'               => 'field_6295c56a54807',
						'label'             => 'Запись',
						'name'              => 'select_post',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_6295c56a54806',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'post',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
				),
			),
			array(
				'key'               => 'field_627bd56news',
				'label'             => 'Блок с новостями',
				'name'              => 'frontpage-news',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_627bd592b26124',
						'label'             => 'Отобразить блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '20',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_627bd5adb26dcnews',
						'label'             => 'Выбрать запись',
						'name'              => 'selected_news',
						'type'              => 'true_false',
						'instructions'      => 'Если вы хотите указать конкретную новость - установите ее вручную и она отобразится с изображением. В автоматическом режиме, будет выводиться 6 новостей',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Вручную',
						'ui_off_text'       => 'Автоматически',
					),
					array(
						'key'               => 'field_627bd60db26ddnews',
						'label'             => 'Запись',
						'name'              => 'select_news',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_627bd5adb26dcnews',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'post',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
				),
			),
			array(
				'key'               => 'field_627bd56ab26da',
				'label'             => 'Блок с видео',
				'name'              => 'frontpage-video',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_627bd592b26db',
						'label'             => 'Отобразить блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '20',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_627bd5adb26dc',
						'label'             => 'Выбрать запись',
						'name'              => 'selected_post',
						'type'              => 'true_false',
						'instructions'      => 'Если вы хотите указать конкретную запись - установите ее вручную. В автоматическом режиме, будет выводиться последняя запись из категории Видео',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Вручную',
						'ui_off_text'       => 'Последняя',
					),
					array(
						'key'               => 'field_627bd60db26dd',
						'label'             => 'Запись',
						'name'              => 'select_post',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_627bd5adb26dc',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'post',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
				),
			),
			array(
				'key'               => 'field_627e44a8131bc',
				'label'             => 'Спецпроект',
				'name'              => 'frontpage-project',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_627e44ef131bd',
						'label'             => 'Отборажение',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_62bab125bbd07',
						'label'             => 'Количество',
						'name'              => 'project_count',
						'type'              => 'number',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '20',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					),
					array(
						'key'               => 'field_629e3b920b640',
						'label'             => 'Спецпроект',
						'name'              => 'taxonomy',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_627e44ef131bd',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'taxonomy'          => 'project',
						'field_type'        => 'select',
						'allow_null'        => 0,
						'add_term'          => 1,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 0,
					),
					array(
						'key'               => 'field_62baaf8ec0d0a',
						'label'             => 'Описание',
						'name'              => 'description',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_62baafa5c0d0b',
						'label'             => 'Ссылка кнопки',
						'name'              => 'button_link',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 'mailto:info@kedr.media?subject=Письмо по теме проекта',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_62baafb7c0d0c',
						'label'             => 'Текст кнопки',
						'name'              => 'button_text',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '50',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 'Рассказать',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
				),
			),
			array(
				'key'               => 'field_62a471ef680ed',
				'label'             => 'Блок с фото',
				'name'              => 'frontpage-gallery',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62a471ef680ee',
						'label'             => 'Отобразить блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '15',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_62d53211babc7',
						'label'             => 'Место',
						'name'              => 'place',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '25',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Конец',
						'ui_off_text'       => 'Середина',
					),
					array(
						'key'               => 'field_62a471ef680ef',
						'label'             => 'Выбрать запись',
						'name'              => 'selected_post',
						'type'              => 'true_false',
						'instructions'      => 'Если вы хотите указать конкретную запись - установите ее вручную. В автоматическом режиме, будет выводиться последняя запись из категории Видео',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '25',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Вручную',
						'ui_off_text'       => 'Последняя',
					),
					array(
						'key'               => 'field_62a471ef680f0',
						'label'             => 'Запись',
						'name'              => 'select_post',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_62a471ef680ef',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '35',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'post',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-kedr-fronpage-settings',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_62822aefed09f',
		'title'                 => 'Настройки категории',
		'fields'                => array(
			array(
				'key'               => 'field_62822afc0e067',
				'label'             => 'Обложка',
				'name'              => 'poster',
				'type'              => 'image',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'return_format'     => 'url',
				'preview_size'      => 'medium',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			),
			array(
				'key'               => 'field_62822b080e068',
				'label'             => 'Объявление',
				'name'              => 'notofication',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62822b340e069',
						'label'             => 'Изображение',
						'name'              => 'image',
						'type'              => 'image',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'url',
						'preview_size'      => 'medium',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
					array(
						'key'               => 'field_62822cab0e06a',
						'label'             => 'Текст',
						'name'              => 'text',
						'type'              => 'textarea',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'maxlength'         => '',
						'rows'              => '',
						'new_lines'         => 'wpautop',
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'category',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_627b7b3e7885d',
		'title'                 => 'Основные настройки темы',
		'fields'                => array(
			array(
				'key'               => 'field_627b7f3c0e00e',
				'label'             => 'Фиксированная плашка сверху "Поддержать"',
				'name'              => 'header-fixed-support',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => '',
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_62850b37e5c6a',
				'label'             => 'Фиксированная плашка сверху "Email Подписка"',
				'name'              => 'header-fixed-emailsubscribe',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => '',
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_627b7fd50e00f',
				'label'             => 'Текст в плашке "Поддержать"',
				'name'              => 'header-fixed-support_text',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_627b7f3c0e00e',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '«Кедр» — независимое экологическое издание. Мы работаем благодаря вашей поддержке.',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_627b8887fbc32',
				'label'             => 'Фиксированная плашка снизу "Подписаться"',
				'name'              => 'sticky-subscribe-telegram',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => '',
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_627b88f0fbc33',
				'label'             => 'Содержимое плашки',
				'name'              => 'sticky-subscribe-telegram_content',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_627b8887fbc32',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_627b895efbc34',
						'label'             => 'Заголовок',
						'name'              => 'sticky-subscribe-telegram_title',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 'Подпишись на	Telegram «Кедр»',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_627b8981fbc35',
						'label'             => 'Подпись',
						'name'              => 'sticky-subscribe-telegram_subtitle',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 'Будь в курсе последних новостей',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_627b899afbc36',
						'label'             => 'Ссылка',
						'name'              => 'sticky-subscribe-telegram_link',
						'type'              => 'url',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
					),
					array(
						'key'               => 'field_627b89b9fbc37',
						'label'             => 'Иконка',
						'name'              => 'sticky-subscribe-telegram_icon',
						'type'              => 'image',
						'instructions'      => 'Иконка в svg формате. 16x16px',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'url',
						'preview_size'      => 'thumbnail',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
				),
			),
			array(
				'key'               => 'field_62d5357eb3eba',
				'label'             => 'Блок пожертвований',
				'name'              => 'post-donate',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62d5357eb3ebb',
						'label'             => 'Статус',
						'name'              => 'status',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Включен',
						'ui_off_text'       => 'Выключен',
					),
					array(
						'key'               => 'field_62d5357eb3ebc',
						'label'             => 'Заголовок блока',
						'name'              => 'title',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_62d5359bb3ec0',
						'label'             => 'Текст блока',
						'name'              => 'text',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-kedr-settings',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 1,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_62bac0a8316b3',
		'title'                 => 'Партнеры',
		'fields'                => array(
			array(
				'key'               => 'field_62bac0a835c18',
				'label'             => 'Блок топ материалов',
				'name'              => 'partners_group',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62bac0a837efe',
						'label'             => 'Активный блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_62bac0f508563',
						'label'             => 'Партнеры',
						'name'              => 'partners',
						'type'              => 'repeater',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'collapsed'         => '',
						'min'               => 0,
						'max'               => 0,
						'layout'            => 'table',
						'button_label'      => '',
						'sub_fields'        => array(
							array(
								'key'               => 'field_62bac10708564',
								'label'             => 'Лого',
								'name'              => 'logo',
								'type'              => 'image',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'return_format'     => 'url',
								'preview_size'      => 'medium',
								'library'           => 'all',
								'min_width'         => '',
								'min_height'        => '',
								'min_size'          => '',
								'max_width'         => '',
								'max_height'        => '',
								'max_size'          => '',
								'mime_types'        => '',
							),
							array(
								'key'               => 'field_62bac11f08565',
								'label'             => 'Ссылка',
								'name'              => 'link',
								'type'              => 'url',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
							),
						),
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-kedr-partners-settings',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_62950e10a1e63',
		'title'                 => 'Словарь',
		'fields'                => array(
			array(
				'key'               => 'field_62950e15819b2',
				'label'             => 'Словарь записи',
				'name'              => 'post_glossary',
				'type'              => 'repeater',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'collapsed'         => '',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'table',
				'button_label'      => '',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62950e5c819b3',
						'label'             => 'Ключевое слово',
						'name'              => 'keyword',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_62950e80819b4',
						'label'             => 'Описание',
						'name'              => 'description',
						'type'              => 'textarea',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '70',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'maxlength'         => '',
						'rows'              => 3,
						'new_lines'         => '',
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 1,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_62bab23bd1b76',
		'title'                 => 'Топ материалов',
		'fields'                => array(
			array(
				'key'               => 'field_62bab8e96f157',
				'label'             => 'Блок топ материалов',
				'name'              => 'top_group',
				'type'              => 'group',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'layout'            => 'block',
				'sub_fields'        => array(
					array(
						'key'               => 'field_62bab92c6f159',
						'label'             => 'Активный блок',
						'name'              => 'has_block',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '30',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
					array(
						'key'               => 'field_62bab91e6f158',
						'label'             => 'Заголовок',
						'name'              => 'title',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '70',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_62bab9736f15a',
						'label'             => 'Материалы',
						'name'              => 'top_posts',
						'type'              => 'relationship',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => '',
						'taxonomy'          => '',
						'filters'           => array(
							0 => 'search',
							1 => 'post_type',
							2 => 'taxonomy',
						),
						'elements'          => array(
							0 => 'featured_image',
						),
						'min'               => '',
						'max'               => '',
						'return_format'     => 'object',
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-kedr-top-settings',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

	acf_add_local_field_group( array(
		'key'                   => 'group_627d373f78489',
		'title'                 => 'Читать далее',
		'fields'                => array(
			array(
				'key'               => 'field_627d3745f6e75',
				'label'             => 'Читайте также',
				'name'              => 'readmore_recomendation',
				'type'              => 'post_object',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'post_type'         => '',
				'taxonomy'          => '',
				'allow_null'        => 1,
				'multiple'          => 0,
				'return_format'     => 'object',
				'ui'                => 1,
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

endif;

/**
 * Remove comments and trackabcks
 */
add_action( 'add_meta_boxes', function() {
	remove_meta_box( 'commentsdiv', get_post_type(), 'normal' );
    remove_meta_box( 'trackbacksdiv', get_post_type(), 'normal' );
} );

add_action( 'admin_menu', function() {
	remove_menu_page( 'edit-comments.php' );
} );

/**
 * Remove useless widgets from wp-admin
 */
add_action(
	'admin_init',
	function() {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	}
);

/**
 * Remove autop from contact forms
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Add new image sizes
 */
add_action( 'after_setup_theme', function() {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 300, true );

	add_image_size( 'card', 800, 9999, false );
	add_image_size( 'wide', 1200, 9999, false );
} );

/**
 * Little bit increase jpeg quality
 */
add_filter( 'jpeg_quality', function() {
	return 80;
} );