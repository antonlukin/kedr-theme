<?php
$background = (array) get_term_meta( $term->term_id, self::$term_meta, true );

$background = wp_parse_args(
    $background,
    array(
        'image' => '',
    )
);
?>

<tr class="form-field hide-if-no-js">
    <th scope="row" valign="top">
        <label><?php esc_html_e( 'Обложка рубрики', 'kedr-theme' ); ?></label>
    </th>

    <td>
        <div id="kedr-videos-options" style="max-width: 300px;">
            <?php
            printf(
                '<input class="image" type="hidden" name="%s[image]" value="%s">',
                esc_attr( self::$term_meta ),
                esc_url( $background['image'] )
            );
            ?>

            <p>
                <?php
                printf(
                    '<button class="button" type="button" data-select>%s</button>',
                    esc_html__( 'Выбрать изображение', 'kedr-theme' )
                );

                printf(
                    '<button class="button right" type="button" data-remove>%s</button>',
                    esc_html__( 'Удалить', 'kedr-theme' )
                );
                ?>
            </p>
        </div>
    </td>
</tr>