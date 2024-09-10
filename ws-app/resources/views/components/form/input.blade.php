@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => ''
])

@if (! empty($label))
    <x-form.label name="{{ ! empty($id) ? $id : $name }}">{{ $label }}</x-form.label>
@endif

<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="{{ ! empty($id) ? $id : $name }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" />
