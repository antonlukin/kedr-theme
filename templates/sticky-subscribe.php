<?php
$field = get_field( 'sticky-subscribe-telegram_content', 'option' )
?>

<div class="sticky-subscribe fixed-bottom d-flex align-items-center justify-content-center" id="sticky-subscribe">
    <div class="container d-flex align-items-center justify-content-center">
        <a href="<?php echo $field['sticky-subscribe-telegram_link']; ?>" class="d-flex align-items-center w-100">
            <div class="container d-flex align-items-center justify-content-center">
                <img src="<?php echo $field['sticky-subscribe-telegram_icon']; ?>" alt="">
                <div>
                    <strong>
						<?php echo $field['sticky-subscribe-telegram_title']; ?>
                    </strong>
                    <p class="mb-0">
						<?php echo $field['sticky-subscribe-telegram_subtitle']; ?>
                    </p>
                </div>
            </div>
        </a>
        <div class="sticky-subscribe_close ms-auto" id="sticky-subscribe-close">
            <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.72.293a1 1 0 0 0-1.415 0L5.012 3.586 1.72.293A1 1 0 0 0 .305 1.707L3.598 5 .305 8.293A1 1 0 1 0 1.72 9.707l3.293-3.293 3.293 3.293A1 1 0 0 0 9.72 8.293L6.426 5 9.72 1.707a1 1 0 0 0 0-1.414Z"
                      fill="#000" fill-rule="nonzero"/>
            </svg>
        </div>
    </div>
</div>