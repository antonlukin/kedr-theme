<tr class="form-field hide-if-no-js">
    <th scope="row" valign="top">
        <label><?php esc_html_e( 'Обложка рубрики', 'kedr-theme' ); ?></label>
    </th>

    <td>
        <div id="kedr-subcats-options" style="max-width: 300px;">
            <?php
            if ( ! empty( $options['attachment'] ) ) {
                printf(
                    '<img src="%s" alt="" style="%s">',
                    esc_attr( wp_get_attachment_image_url( $options['attachment'], 'full' ) ),
                    'max-width: 95%'
                );
            }

            printf(
                '<input type="hidden" name="%s[attachment]" value="%s">',
                esc_attr( self::$term_meta ),
                esc_attr( $options['attachment'] )
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