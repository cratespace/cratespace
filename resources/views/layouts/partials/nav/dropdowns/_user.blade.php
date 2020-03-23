<div class="dropdown ml-4">
    <button class="dropdown-toggle max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="h-8 w-8 rounded-full" src="{{ user('photo') }}" alt="{{ user('name') }}" />
    </button>

    <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
        <a href="{{ route('users.show', user()) }}" class="dropdown-item block px-4 py-2 text-sm">Profile</a>
        <a href="{{ route('users.edit', ['user' => user('username'), 'page' => 'account']) }}" class="dropdown-item block px-4 py-2 text-sm">Settings</a>
        <a class="dropdown-item block px-4 py-2 text-sm" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            Sign out
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
