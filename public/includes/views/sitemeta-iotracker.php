<?php // phpcs:disable ?>
<script>
    window.ioObject='io';
    (function(i){window[i]=window[i]||function(){(window[i].a=window[i].a||[]).push(arguments)}})(window.ioObject);
</script>

<script async src="https://cdn.onthe.io/io.js/<?php echo esc_attr( KEDR_IO_TRACKER ); ?>"></script>
<script>
    window._io_config = window._io_config || {};
    window._io_config["0.2.0"] = window._io_config["0.2.0"] || [];
    window._io_config["0.2.0"].push({
        page_url: window.location.href,
        page_language: 'ru',
        <?php
        foreach ( $params as $key => $value ) {
            printf( "%s: '%s',\n", esc_attr( $key ), $value );
        }
        ?>
    });
</script>

<script>
    document.addEventListener( 'DOMContentLoaded', () => {
        const post = document.querySelector('.post');

        if ( post === null ) {
            return;
        }

        post.setAttribute( 'data-io-article-url', window.location.href );
    } );
</script>
