<li class="dropdown block {{ $extraClasses ?? null }}">
    <a class="shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $button }}
    </a>

    <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
        {{ $menu }}
    </div>
</li>
