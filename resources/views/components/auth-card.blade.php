<div class="container">
    <div class="row justify-content-center mb-1">
        <div class="col-sm-12 col-md-8 {{ $attributes->get('col_class', 'col-lg-5') }} mt-2">
            <div class="d-flex justify-content-center mb-3">
                {{ $logo }}
            </div>

            <div class="card shadow-sm px-3 overflow-auto" style="max-height: 60vh; background-color: rgba(255, 255, 255, 0.9);">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>