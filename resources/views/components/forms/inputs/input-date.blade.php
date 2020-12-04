@props(['name' => null,, 'id' => null, 'label' => null, 'value' => null, 'instruction' => false])

<x-forms.inputs.input
    {{ $attributes }}
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    label="{{ $label }}"
    value="{{ $value }}"
    type="date">
</x-forms.inputs.input>
