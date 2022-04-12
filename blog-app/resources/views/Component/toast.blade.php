<style>
    .toast{
        right: 2%;
        top: 7%;
        z-index: 1000;
    }
    .hide {
        display: none !important;
    }
</style>
<script>
    setInterval(myToast,2000);
    function myToast() {
        $('.toast').addClass('hide')
    }
</script>
<div  class="toast align-items-center d-inline-block position-absolute text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    {{ $slot }}
</div>
