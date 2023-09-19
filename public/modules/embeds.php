<?php
/**
 * Embed filters
 * Customize default WordPress embed code
 *
 * @package kedr-theme
 * @since 2.0
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Embeds {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'embed_defaults', array( __CLASS__, 'set_defaults' ) );

        if ( ! is_admin() ) {
            add_filter( 'embed_oembed_html', array( __CLASS__, 'update_youtube_embed' ), 10, 2 );
            add_filter( 'embed_oembed_html', array( __CLASS__, 'update_vimeo_embed' ), 10, 2 );
        }

        add_filter( 'the_content_feed', array( __CLASS__, 'replace_feed_embeds' ), 5 );
    }

    /**
     * Set default embed sizes
     */
    public static function set_defaults( $defaults ) {
        $defaults = array(
            'width'  => 736,
            'height' => 552,
        );

        return $defaults;
    }

    /**
     * Update YouTube html to show preloader
     */
    public static function update_youtube_embed( $result, $url ) {
        $regex = '~http(?:s)?:\/\/(?:m.)?(?:www\.)?youtu(?:\.be\/|(?:be-nocookie|be)\.com\/(?:watch|[\w]+\?(?:feature=[\w]+.[\w]+\&)?v=|v\/|e\/|embed\/|live\/|shorts\/|user\/(?:[\w#]+\/)+))([^&#?\n]+)~i';

        if ( ! preg_match( $regex, $url, $match ) ) {
            return $result;
        }

        $preview = "https://img.youtube.com/vi/{$match[1]}/default.jpg";

        foreach ( array( 'maxresdefault', 'hqdefault', 'mqdefault' ) as $size ) {
            $response = wp_remote_head( "https://img.youtube.com/vi/{$match[1]}/{$size}.jpg" );

            if ( wp_remote_retrieve_response_code( $response ) === 200 ) {
                $preview = "https://img.youtube.com/vi/{$match[1]}/{$size}.jpg";

                break;
            }
        }

        $params = array(
            'rel'      => 0,
            'showinfo' => 0,
            'autoplay' => 1,
        );

        wp_parse_str( wp_parse_url( $url, PHP_URL_QUERY ), $query );

        if ( isset( $query['t'] ) ) {
            $params['start'] = $query['t'];
        }

        $result = sprintf(
            '<div class="embed embed--youtube" data-embed="%1$s">%2$s</div>',
            sprintf(
                'https://www.youtube.com/embed/%1$s?%2$s',
                esc_attr( $match[1] ),
                build_query( $params )
            ),
            sprintf(
                '<a class="embed__dummy" href="%1$s" target="_blank" style="background-image: url(%2$s)"></a>',
                esc_url( $url ),
                esc_url( $preview )
            )
        );

        return $result;
    }

    /**
     * Update Vimeo html to show preloader
     */
    public static function update_vimeo_embed( $result, $url ) {
        if ( is_admin() ) {
            return $result;
        }

        if ( ! preg_match( '#https?://(?:.+\.)?vimeo\.com/(?:video/)?([\d]+).*#i', $url, $match ) ) {
            return $result;
        }

        $request = wp_remote_get( "https://vimeo.com/api/v2/video/{$match[1]}.json" );
        $preview = '';

        if ( ! is_wp_error( $request ) ) {
            $meta = json_decode( wp_remote_retrieve_body( $request ) );

            foreach ( array( 'thumbnail_large', 'thumbnail_medium', 'thumbnail_small' ) as $size ) {
                if ( isset( $meta[0]->$size ) ) {
                    $preview = $meta[0]->$size;

                    break;
                }
            }
        }

        $result = sprintf(
            '<div class="embed embed--vimeo" data-embed="%1$s">%2$s</div>',
            sprintf(
                'https://player.vimeo.com/video/%s?byline=0&autoplay=1',
                esc_attr( $match[1] )
            ),
            sprintf(
                '<a class="embed__dummy" href="%1$s" target="_blank" style="background-image: url(%2$s)"></a>',
                esc_url( $url ),
                esc_url( $preview )
            )
        );

        return $result;
    }

    /**
     * Replace custom video preloaders in feeds
     */
    public static function replace_feed_embeds( $content ) {
        $content = preg_replace(
            '~<div class="embed\s.+?"\s+data-embed="([^"]+)".+?</div>~is',
            '<iframe src="$1" frameborder="0"></iframe>',
            $content
        );

        return $content;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Embeds::load_module();
