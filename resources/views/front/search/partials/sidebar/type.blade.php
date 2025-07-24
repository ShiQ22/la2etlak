@php
    $currentType = request()->query('type', '');
@endphp

<div class="mb-3">
    <h5 class="border-bottom pb-2">{{ t('Listing Type') }}</h5>
    <ul class="list-unstyled mb-0">
        <li>
            <a href="{{ request()->fullUrlWithQuery(['type' => '']) }}"
               class="{{ $currentType === '' ? 'fw-bold' : '' }}">
                {{ t('All') }}
            </a>
        </li>
        <li>
            <a href="{{ request()->fullUrlWithQuery(['type' => 'lost']) }}"
               class="{{ $currentType === 'lost' ? 'fw-bold text-danger' : '' }}">
                {{ t('Lost') }}
            </a>
        </li>
        <li>
            <a href="{{ request()->fullUrlWithQuery(['type' => 'found']) }}"
               class="{{ $currentType === 'found' ? 'fw-bold text-success' : '' }}">
                {{ t('Found') }}
            </a>
        </li>
    </ul>
</div>
