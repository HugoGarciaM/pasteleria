
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{$title}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>


    {{-- @yield('content_modal') --}}
{{-- <div class="modal-footer"> --}}
    {{--     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
    {{--     <button type="submit" class="btn btn-primary">Guardar</button> --}}
    {{-- </div> --}}
