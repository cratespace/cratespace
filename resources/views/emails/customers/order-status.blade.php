@component('mail::message')
# Order {{ '#' . $order->uid }} {{ $order->status }}

Hi, {{ $order->name }}<br>

Your order has been {{ strtolower($order->status) }}. Please contact the business for further details.

### Business Details
- Name: **{{ $order->user->business->name }}**
- Email: **{{ $order->user->business->email }}**
- Phone: **{{ $order->user->business->phone }}**

If you have any questions, please [let us know](https://cratespace.biz/support)!
@endcomponent
