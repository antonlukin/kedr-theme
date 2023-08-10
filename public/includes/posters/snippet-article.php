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
$logo->make( $options['logo'] )->downsize( 60, null );

$poster->insert(
    $logo,
    array(
        'x' => 1085,
        'y' => 50,
    )
);

$poster->text(
    $options['label'],
    array(
        'x'          => 75,
        'y'          => 180,
        'width'      => 1000,
        'height'     => 50,
        'horizontal' => 'left',
        'vertical'   => 'top',
        'fontpath'   => $options['font'],
        'fontsize'   => 22,
        'lineheight' => 1.5,
        'color'      => '#ffffff',
    )
);

$poster->text(
    $options['caption'],
    array(
        'x'          => 75,
        'y'          => 260,
        'width'      => 1000,
        'height'     => 200,
        'horizontal' => 'left',
        'vertical'   => 'top',
        'fontpath'   => $options['font'],
        'fontsize'   => 40,
        'lineheight' => 1.375,
        'color'      => '#ffffff',
    ),
    $boundary
);

if ( ! empty( $options['excerpt'] ) ) {
    $poster->text(
        $options['excerpt'],
        array(
            'x'          => 75,
            'y'          => $boundary['height'] + 280,
            'width'      => 1000,
            'height'     => 300 - $boundary['height'],
            'horizontal' => 'left',
            'vertical'   => 'top',
            'fontpath'   => $options['thinfont'],
            'fontsize'   => 28,
            'lineheight' => 1.5,
            'color'      => '#ffffff',
        )
    );
}


$poster->save( $options['file'], 95 );
