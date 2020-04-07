@component('mail::message')
# Order Pending Confirmation

Hi, {{ $order->name }}<br>

The payment for order **{{ '#'. $order->uid }}** has been confirmed! We'll let you know when your order is accepted.<br>

If you have any questions, please [let us know](https://cratespace.biz/support)!
@endcomponent
