{{-- resources/views/front/layouts/partials/listing-type-modal.blade.php --}}
<div class="modal fade" id="listingTypeModal" tabindex="-1" aria-labelledby="listingTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="listingTypeModalLabel">{{ t('Is this item Lost or Found?') }}</h5>
        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="{{ t('Close') }}"></button>
      </div>
      <div class="modal-body">
        <div class="d-grid gap-3">
             <button type="button"
           class="btn btn-listing btn-border py-3"
           onclick="window.location='{{ urlGen()->addPost() }}?type=lost';">
     <i class="fa-regular fa-pen-to-square me-1"></i> {{ t('lost') }}
   </button>
             <button type="button"
           class="btn btn-listing btn-border py-3"
           onclick="window.location='{{ urlGen()->addPost() }}?type=found';">
     <i class="fa-regular fa-pen-to-square me-1"></i> {{ t('found') }}
   </button>
        </div>
      </div>
    </div>
  </div>
</div>
