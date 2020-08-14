<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Cratespace')
<img src="http://cratespace.test/img/logo.png" class="logo" alt="Cratespace Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
