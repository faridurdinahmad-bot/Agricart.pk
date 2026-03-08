@props(['title', 'subtitle' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-heading">{{ $title }}</h1>
        @if($subtitle)
        <p class="text-sm text-white/70 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
    <div class="flex flex-wrap gap-2">{{ $actions }}</div>
    @endif
</div>
