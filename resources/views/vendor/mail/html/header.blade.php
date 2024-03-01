@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ asset('/images/logo.png') }}" class="logo" alt="{{ $slot }}">
</a>
</td>
</tr>
