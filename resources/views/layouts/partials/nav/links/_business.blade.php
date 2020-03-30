<a href="{{ route('home') }}" class="{{ is_active('home', 'bg-gray-900 text-white', 'text-gray-300 hover:text-white hover:bg-gray-700') }} -ml-3 md:ml-6 px-3 py-2 rounded-lg text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>

<a href="{{ route('spaces.index', ['status' => 'Available']) }}" class="{{ is_active('spaces*', 'bg-gray-900 text-white', 'text-gray-300 hover:text-white hover:bg-gray-700') }} -ml-3 md:ml-4 px-3 py-2 rounded-lg text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700">Spaces</a>

<a href="{{ url('/orders?status=Pending') }}" class="{{ is_active('orders*', 'bg-gray-900 text-white', 'text-gray-300 hover:text-white hover:bg-gray-700') }} -ml-3 md:ml-4 px-3 py-2 rounded-lg text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700">Orders</a>

<a href="{{ url('/reports') }}" class="{{ is_active('reports*', 'bg-gray-900 text-white', 'text-gray-300 hover:text-white hover:bg-gray-700') }} -ml-3 md:ml-4 px-3 py-2 rounded-lg text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700">Reports</a>

<a href="{{ url('/support') }}" class="{{ is_active('support*', 'bg-gray-900 text-white', 'text-gray-300 hover:text-white hover:bg-gray-700') }} -ml-3 md:ml-4 px-3 py-2 rounded-lg text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700">Support</a>
