@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
@php
$buttonStyle = match ($color) {
    'success' => 'background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);',
    'error' => 'background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);',
    default => 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);',
};
@endphp
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}" class="button button-{{ $color }}" target="_blank" rel="noopener" style="{{ $buttonStyle }} box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);">{!! $slot !!}</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
