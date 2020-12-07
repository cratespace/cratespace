@props(['menuDirection' => 'normal'])

<div {{ $attributes->merge(['class' => 'dropdown leading-none flex-no-shrink']) }}>
    {{ $trigger }}

    <div class="dropdown-menu {{ $menuDirection === 'right' ? 'dropdown-menu-right' : null }} mt-2 border-none rounded-xl shadow-lg bg-white p-2">
        {{ $links }}
    </div>
</div>
