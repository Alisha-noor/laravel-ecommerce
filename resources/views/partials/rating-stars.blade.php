@php
  // Props: $rating (0–5, can be decimal), $showCount (bool), $count (int), $size (e.g. 'fa-sm')
  $rating = isset($rating) ? floatval($rating) : 0;
  $full = floor($rating);
  $half = ($rating - $full) >= 0.25 && ($rating - $full) < 0.75 ? 1 : 0;
  if (($rating - $full) >= 0.75) { $full++; $half = 0; }
  $empty = max(0, 5 - $full - $half);
  $sizeClass = $size ?? '';
@endphp

<span class="d-inline-flex align-items-center gap-1">
  @for ($i=0; $i<$full; $i++)
    <i class="fa-solid fa-star {{ $sizeClass }}" style="color:#f5b301" aria-hidden="true"></i>
  @endfor
  @for ($i=0; $i<$half; $i++)
    <i class="fa-solid fa-star-half-stroke {{ $sizeClass }}" style="color:#f5b301" aria-hidden="true"></i>
  @endfor
  @for ($i=0; $i<$empty; $i++)
    <i class="fa-regular fa-star {{ $sizeClass }}" style="color:#f5b301" aria-hidden="true"></i>
  @endfor

  @if(!empty($showCount) && isset($count))
    <small class="text-muted ms-1">({{ number_format($count) }})</small>
  @endif
</span>
