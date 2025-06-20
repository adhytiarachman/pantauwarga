@props(['title', 'value', 'icon' => 'users', 'color' => 'primary'])

<div class="card border-0 shadow-sm" data-aos="zoom-in">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div>
            <h6 class="fw-semibold mb-2 text-muted">{{ $title }}</h6>
            <h3 class="display-6 text-{{ $color }}">{{ $value }}</h3>
        </div>
        <div>
            <i data-lucide="{{ $icon }}" class="text-{{ $color }}" style="width: 36px; height: 36px;"></i>
        </div>
    </div>
</div>
