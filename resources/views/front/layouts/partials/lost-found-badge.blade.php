@if (data_get($post, 'lost_or_found') === 'lost')
  <span class="badge badge-lost ms-2">{{ t('Lost') }}</span>
@elseif (data_get($post, 'lost_or_found') === 'found')
  <span class="badge badge-found ms-2">{{ t('Found') }}</span>
@endif