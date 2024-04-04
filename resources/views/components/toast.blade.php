<div class="toast-container position-fixed top-0 end-0">
    <div id="{{$id}}" class="toast {{$colorscheme}}" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">{{$title}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{$slot}}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toastLiveExample = document.getElementById('{{$id}}');
    if (toastLiveExample) {
        const toastBootstrap = new bootstrap.Toast(toastLiveExample);
        toastBootstrap.show();
    }
});
</script>

