<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Cratespace')
<img src="{{ asset('img/logo.svg') }}" class="logo" alt="Cratespace">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
