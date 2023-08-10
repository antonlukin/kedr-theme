<?php
/**
 * Transliteration
 * Cyr2lat simple alternative
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Translit {
    /**
     * Use this method instead of constructor to avoid setting multiple hooks
     */
    public static function load_module() {
        add_action( 'sanitize_title', array( __CLASS__, 'sanitize_title' ), 9 );
        add_action( 'sanitize_file_name', array( __CLASS__, 'sanitize_file_name' ), 9 );
    }

    /**
     * Leave only latin chars and digits in slugs
     */
    public static function sanitize_title( $name ) {
        $name = self::replace_latin( $name );

        // Leave only latin chars and digits in slugs
        $name = preg_replace( '/[^a-z0-9]/i', '-', $name );

        return $name;
    }

    /**
     * Update file names
     */
    public static function sanitize_file_name( $name ) {
        $name = self::replace_latin( $name );

        if ( seems_utf8( $name ) ) {
            $name = urldecode( $name );
        }

        return $name;
    }

    /**
     * Replace latin with cyrillic using ISO 9
     */
    private static function replace_latin( $name ) {
        $replace = array(
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'YO',
            'Ж' => 'ZH',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'J',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'CZ',
            'Ч' => 'CH',
            'Ш' => 'SH',
            'Щ' => 'SHH',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'E',
            'Ю' => 'YU',
            'Я' => 'YA',

            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'cz',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shh',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        );

        $name = strtr( $name, $replace );

        return $name;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Translit::load_module();
