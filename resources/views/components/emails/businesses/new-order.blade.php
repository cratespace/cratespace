@component('mail::message')
# New Order Placed

A new order with no. [**{{ '#' . $order->uid }}**](https://cratespace.biz/orders/{{ $order->uid }}) has been placed and is awainting your confirmation.
Sign in to [{{ config('app.name') }}](https://cratespace.biz/login) to confirm order.<br>

You can also call the customer who placed the order to make sure the request is still valid.

### Customer Details
- Name: **{{ $order->name }}**
- Email: **{{ $order->email }}**
- Phone: **{{ $order->phone }}**
@endcomponent
