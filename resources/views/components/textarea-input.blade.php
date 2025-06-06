@props(['id', 'name', 'rows' => 5, 'value'=>'', 'required' => false])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}
>
{{ old($name, $value) }}
</textarea>
