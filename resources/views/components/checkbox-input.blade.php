@props(['id', 'name', 'value', 'checked' => false])

<input type="checkbox"
    id="{{ $id }}"
    name="{{ $name }}"
    value="{{ $value }}"
    {{ $checked ? 'checked' : '' }}
    {{ $attributes->merge(['class' => 'mr-2 leading-tight']) }} />
