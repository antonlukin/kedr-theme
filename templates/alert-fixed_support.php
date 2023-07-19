<div class="alert-support d-flex align-items-center" id="support-block">
    <div class="container d-flex align-items-center justify-content-between">
        <p class="mb-0">
            <?php the_field('header-fixed-support_text', 'option'); ?>
        </p>
        <a href="" class="btn btn-outline-secondary">Поддержать</a>
        <div class="support-block_close mx-4" id="support-block-close" onclick="close_support()">
            <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.72.293a1 1 0 0 0-1.415 0L5.012 3.586 1.72.293A1 1 0 0 0 .305 1.707L3.598 5 .305 8.293A1 1 0 1 0 1.72 9.707l3.293-3.293 3.293 3.293A1 1 0 0 0 9.72 8.293L6.426 5 9.72 1.707a1 1 0 0 0 0-1.414Z" fill="#fff" fill-rule="nonzero"/>
            </svg>
        </div>
    </div>
</div>

<script>
    function close_support() {
        document.getElementById('support-block').classList.add('d-none')
    }
</script>