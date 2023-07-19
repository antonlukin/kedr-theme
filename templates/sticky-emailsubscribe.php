<section class="header-email-subscribe d-none" id="header-emailsubscripe">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <!--            5-->
			<?php echo do_shortcode( '[contact-form-7 id="253" title="Email Рассылка"]' ); ?>
            <div class="sticky-subscribe_close ms-auto" id="sticky-subscribe-close" onclick="close_email_subscribe()">
                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.72.293a1 1 0 0 0-1.415 0L5.012 3.586 1.72.293A1 1 0 0 0 .305 1.707L3.598 5 .305 8.293A1 1 0 1 0 1.72 9.707l3.293-3.293 3.293 3.293A1 1 0 0 0 9.72 8.293L6.426 5 9.72 1.707a1 1 0 0 0 0-1.414Z"
                          fill="#fff" fill-rule="nonzero"/>
                </svg>
            </div>
        </div>
    </div>
</section>
<script>
    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) c_end = document.cookie.length;
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return null;
    }

    hesc = getCookie('HESubscribe');
    if (hesc == null) {
        document.getElementById('header-emailsubscripe').classList.remove('d-none')
    }

    function close_email_subscribe() {
        document.getElementById('header-emailsubscripe').classList.add('d-none')
        document.cookie = "HESubscribe=close";
    }
</script>