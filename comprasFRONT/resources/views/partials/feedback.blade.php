<div class="">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-info">
            {{ session('success') }}
        </div>
    @endif
</div>