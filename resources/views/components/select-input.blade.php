@props(['disabled' => false])

<?php
    $id = $attributes->get('id') ?? 'x-select-'.uniqid();
?>

<select 
    id="{{ $id }}" 
    @disabled($disabled) 
    {{ $attributes->merge(['class' => 'border border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm', 'id' => $id]) }}
>
    {{ $slot }}
</select>
