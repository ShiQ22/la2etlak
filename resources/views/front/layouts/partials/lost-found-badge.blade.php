{{-- resources/views/front/layouts/partials/lost-found-badge.blade.php --}}
@php
  // Support both front-end ($post) and Backpack admin ($entry)
  $model = $post ?? $entry;
@endphp

@if (data_get($model, 'lost_or_found') === 'lost')
  <span class="badge badge-lost ms-2">{{ t('Lost') }}</span>
@elseif (data_get($model, 'lost_or_found') === 'found')
  <span class="badge badge-found ms-2">{{ t('Found') }}</span>
@endif
