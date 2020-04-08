<ul class="flex items-center">
    <li class="mr-3">
        <a href="{{ route('users.edit', ['user' => $user, 'page' => 'account']) }}"
            class="{{ is_active('users/' . $user->username . '/settings/account', 'bg-gray-300 text-gray-700', 'hover:bg-gray-300 hover:text-gray-700') }} block py-2 px-4 rounded-lg text-gray-600 focus:bg-gray-300 focus:text-gray-700">Account</a>
    </li>

    <li class="mr-3">
        <a href="{{ route('users.edit', ['user' => $user, 'page' => 'business']) }}"
            class="{{ is_active('users/' . $user->username . '/settings/business', 'bg-gray-300 text-gray-700', 'hover:bg-gray-300 hover:text-gray-700') }} block py-2 px-4 rounded-lg text-gray-600 focus:bg-gray-300 focus:text-gray-700">Business</a>
    </li>

    <li class="mr-3">
        <a href="{{ route('users.edit', ['user' => $user, 'page' => 'billing']) }}"
            class="{{ is_active('users/' . $user->username . '/settings/billing', 'bg-gray-300 text-gray-700', 'hover:bg-gray-300 hover:text-gray-700') }} block py-2 px-4 rounded-lg text-gray-600 focus:bg-gray-300 focus:text-gray-700">Billing</a>
    </li>
</ul>
