@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'p-4 mb-4 text-sm rounded-lg bg-green-50 text-green-600 text-center font-medium']) }}>
    {{ $status }}
</div>
@endif
