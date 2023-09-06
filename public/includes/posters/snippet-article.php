<?php
/**
 * Article poster template
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

$poster = new PosterEditor\PosterEditor();
$poster->canvas(
    1200,
    630,
    array(
        'color'   => $options['color'],
        'opacity' => 0,
    )
);

if ( ! empty( $options['thumbnail'] ) ) {
    $poster->make( $options['thumbnail'] )->fit( 1200, 630 );
    $poster->blackout( 70 );
}

$logo = new PosterEditor\PosterEditor();
$logo->make( $options['logo-green'] )->downsize( 184, null );

$poster->insert(
    $logo,
    array(
        'x' => 75,
        'y' => 50,
    )
);

$poster->text(
    mb_strtoupper( $options['label'] ),
    array(
        'x'          => 75,
        'y'          => 220,
        'width'      => 1000,
        'height'     => 50,
        'horizontal' => 'left',
        'vertical'   => 'top',
        'fontpath'   => $options['font-bold'],
        'fontsize'   => 18,
        'lineheight' => 1.5,
        'color'      => '#ffffff',
    )
);

$poster->text(
    $options['caption'],
    array(
        'x'          => 75,
        'y'          => 285,
        'width'      => 1000,
        'height'     => 200,
        'horizontal' => 'left',
        'vertical'   => 'top',
        'fontpath'   => $options['font-bold'],
        'fontsize'   => 48,
        'lineheight' => 1.5,
        'color'      => '#ffffff',
    ),
    $boundary
);

if ( ! empty( $options['excerpt'] ) ) {
    $poster->text(
        $options['excerpt'],
        array(
            'x'          => 75,
            'y'          => $boundary['height'] + 295,
            'width'      => 1000,
            'height'     => 300 - $boundary['height'],
            'horizontal' => 'left',
            'vertical'   => 'top',
            'fontpath'   => $options['font-thin'],
            'fontsize'   => 34,
            'lineheight' => 1.5,
            'color'      => '#ffffff',
        )
    );
}


$poster->save( $options['file'], 95 );
