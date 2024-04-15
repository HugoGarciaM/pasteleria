@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{url('storage/logo.png')}}" class="logo" alt="Pepita Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
