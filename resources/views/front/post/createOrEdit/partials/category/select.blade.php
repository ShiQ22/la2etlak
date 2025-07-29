@php
    $catDisplayType   ??= 'c_bigIcon_list';
    $apiResult        ??= [];
    $totalCategories  = (int)data_get($apiResult, 'meta.total', 0);
    $areCategoriesPageable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
    $categories       ??= [];
    $category         ??= null;
    $hasChildren      ??= false;
    $selectedId       ??= 0; // The selected category ID
    $selectionUrl     = url('browsing/categories/select');
    $linkClass        = linkClass();
@endphp

@if (!$hasChildren)
    {{-- Replace the “select a category” field in the form --}}
    @if (!empty($category))
        @php
            $_catId   = data_get($category, 'id');
            $_catName = data_get($category, 'name');
            // Always build a **full** URL including multiple=1
            $_baseUrl = urlQuery($selectionUrl)
                ->setParameters(['parentId' => $_catId, 'multiple' => 1])
                ->toString();
        @endphp

        @if (!empty(data_get($category, 'children')))
            <a href="#browseCategories"
               data-bs-toggle="modal"
               class="modal-cat-link open-selection-url {{ $linkClass }}"
               data-selection-url="{{ $_baseUrl }}"
            >
                {{ $_catName }}
            </a>
        @else
            @php
                $_parentId = data_get($category, 'parent.id', 0);
                $_editUrl  = urlQuery($selectionUrl)
                    ->setParameters(['parentId' => $_parentId, 'multiple' => 1])
                    ->toString();
            @endphp
            {{ $_catName }}&nbsp;
            [ <a href="#browseCategories"
                 data-bs-toggle="modal"
                 class="modal-cat-link open-selection-url {{ $linkClass }}"
                 data-selection-url="{{ $_editUrl }}"
            >
                <i class="fa-regular fa-pen-to-square"></i> {{ t('Edit') }}
            </a> ]
        @endif

    @else
        {{-- No category yet: “Select a category” --}}
        <a href="#browseCategories"
           data-bs-toggle="modal"
           class="modal-cat-link open-selection-url {{ $linkClass }}"
           data-selection-url="{{ urlQuery($selectionUrl)->setParameters(['multiple' => 1])->toString() }}"
        >
            {{ t('select_a_category') }}
        </a>
    @endif

@else
    {{-- Inside the modal: show “Go to parent” + children grid --}}
    @if (!empty($category))
        @php
            $_parentId = data_get($category, 'parent.id', 0);
            $_backUrl  = urlQuery($selectionUrl)
                ->setParameters(['parentId' => $_parentId, 'multiple' => 1])
                ->toString();
        @endphp
        <p>
            <a href="{!! $_backUrl !!}"
               class="btn btn-primary btn-sm modal-cat-link"
               data-ignore-guard="true"
               data-selection-url="{{ $_backUrl }}"
            >
                <i class="fa-solid fa-reply"></i> {{ t('go_to_parent_categories') }}
            </a>
            &nbsp;<strong>{{ data_get($category, 'name') }}</strong>
        </p>
    @endif

    @if (!empty($categories))
        <div class="container">

            @if ($catDisplayType == 'c_picture_list')
                <div id="modalCategoryList" class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-2 py-1 px-0">
                    @foreach($categories as $cat)
                        @php
                            $_id          = data_get($cat, 'id');
                            $_hasChildren = !empty(data_get($cat, 'children')) ? 1 : 0;
                            $_parentId    = data_get($cat, 'parent.id', 0);
                            $_type        = data_get($cat, 'type');
                            $_imageUrl    = data_get($cat, 'image_url');
                            $_name        = data_get($cat, 'name');
                            $_url         = urlQuery($selectionUrl)
                                ->setParameters(['parentId' => $_id, 'multiple' => 1])
                                ->toString();
                            $isLeaf       = ($_hasChildren == 0);
                        @endphp

                        <div class="col px-0 d-flex justify-content-center align-content-stretch">
                            <div class="text-center w-100 border rounded px-3 py-2 m-1 position-relative">

                                @if($isLeaf)
                                    <input type="checkbox"
                                           class="cat-checkbox position-absolute top-0 end-0 m-2"
                                           data-id="{{ $_id }}"
                                    />
                                @endif

                                <a href="{{ $_hasChildren ? $_url : '#' }}"
                                   class="modal-cat-link {{ $linkClass }} {{ !$_hasChildren ? 'leaf-cat' : '' }}"
                                   data-parent-id="{{ $_parentId }}"
                                   data-id="{{ $_id }}"
                                   data-has-children="{{ $_hasChildren }}"
                                   data-type="{{ $_type }}"
                                   data-selection-url="{{ $_url }}"
                                >
                                    <img src="{{ $_imageUrl }}" class="lazyload img-fluid" alt="{{ $_name }}">
                                    <h6 class="mt-2 fw-bold{{ !$isLeaf ? ' text-secondary' : '' }}">
                                        {{ $_name }}
                                    </h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            @elseif ($catDisplayType == 'c_bigIcon_list')
                <div id="modalCategoryList" class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-2 py-0 px-0">
                    @foreach($categories as $cat)
                        @php
                            $_id          = data_get($cat, 'id');
                            $_hasChildren = !empty(data_get($cat, 'children')) ? 1 : 0;
                            $_parentId    = data_get($cat, 'parent.id', 0);
                            $_type        = data_get($cat, 'type');
                            $_iconClass   = data_get($cat, 'icon_class');
                            $_name        = data_get($cat, 'name');
                            $_url         = urlQuery($selectionUrl)
                                ->setParameters(['parentId' => $_id, 'multiple' => 1])
                                ->toString();
                            $isLeaf       = ($_hasChildren == 0);
                        @endphp

                        <div class="col px-0 d-flex justify-content-center align-content-stretch">
                            <div class="text-center w-100 border rounded px-3 py-2 m-1 position-relative">

                                @if($isLeaf)
                                    <input type="checkbox"
                                           class="cat-checkbox position-absolute top-0 end-0 m-2"
                                           data-id="{{ $_id }}"
                                    />
                                @endif

                                <a href="{{ $_hasChildren ? $_url : '#' }}"
                                   class="modal-cat-link {{ $linkClass }} {{ !$_hasChildren ? 'leaf-cat' : '' }}"
                                   data-parent-id="{{ $_parentId }}"
                                   data-id="{{ $_id }}"
                                   data-has-children="{{ $_hasChildren }}"
                                   data-type="{{ $_type }}"
                                   data-selection-url="{{ $_url }}"
                                >
                                    @if(in_array(config('settings.listings_list.show_category_icon'), [2,6,7,8]))
                                        <i class="{{ $_iconClass ?? 'bi bi-folder-fill' }}" style="font-size:3rem;"></i>
                                    @endif
                                    <h6 class="mt-2 fw-bold{{ !$isLeaf ? ' text-secondary' : '' }}">
                                        {{ $_name }}
                                    </h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                @php
                    $showIcon = in_array(config('settings.listings_list.show_category_icon'), [2,6,7,8]);
                    $borderBottom = ($catDisplayType == 'c_border_list') ? ' border-bottom pb-2' : '';
                @endphp

                <ul id="modalCategoryList"
                    class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-1 my-4 list-unstyled">
                    @foreach($categories as $cat)
                        @php
                            $_catId       = data_get($cat, 'id');
                            $_hasChildren = !empty(data_get($cat, 'children')) ? 1 : 0;
                            $_parentId    = data_get($cat, 'parent.id', 0);
                            $_catType     = data_get($cat, 'type');
                            $_catIcon     = $showIcon
                                ? '<i class="' . data_get($cat,'icon_class','') . '"></i> '
                                : '';
                            $_catName     = data_get($cat, 'name');
                            $_url         = urlQuery($selectionUrl)
                                ->setParameters(['parentId'=>$_catId, 'multiple'=>1])
                                ->toString();
                            $isLeaf       = ($_hasChildren == 0);
                            $_hasLink     = ($_catId != $selectedId || $_hasChildren == 1);
                        @endphp

                        <li class="col d-flex px-2{{ $_hasLink ? '' : ' text-secondary fw-bold' }} my-2">
                            <div class="w-100{{ $borderBottom }} position-relative">

                                @if($isLeaf)
                                    <input type="checkbox"
                                           class="cat-checkbox position-absolute top-0 end-0 m-2"
                                           data-id="{{ $_catId }}"
                                    />
                                @endif

                                @if($_hasLink)
                                    <a href="{!! $_url !!}"
                                       class="modal-cat-link {{ $linkClass }}"
                                       data-parent-id="{{ $_parentId }}"
                                       data-id="{{ $_catId }}"
                                       data-has-children="{{ $_hasChildren }}"
                                       data-type="{{ $_catType }}"
                                       data-selection-url="{{ $_url }}"
                                    >
                                @endif

                                {!! $_catIcon !!}{{ $_catName }}

                                @if($_hasLink)
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if($totalCategories > 0 && $areCategoriesPageable)
            <br>
            @include('vendor.pagination.api.bootstrap-4')
        @endif

    @else
        {{ $apiMessage ?? t('no_categories_found') }}
    @endif
@endif
