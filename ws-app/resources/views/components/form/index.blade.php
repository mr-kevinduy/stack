@props([
    'action' => '',
    'method' => 'POST',
    'enctype' => '',
    'csrf' => true
])

<form action="{{ $action }}" method="{{ $method }}" {{ ! empty($enctype) ? 'enctype="'.$enctype.'"' : null }}>
    @if ($csrf)
        @csrf
    @endif

    {{ $slot }}
</form>
