/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: Mayeul Akpovi (BeDigit - https://bedigit.com)
 *
 * LICENSE
 * -------
 * This software is provided under a license agreement and may only be used or copied
 * in accordance with its terms, including the inclusion of the above copyright notice.
 * As this software is sold exclusively on CodeCanyon,
 * please review the full license details here: https://codecanyon.net/licenses/standard
 */


/**
 * Fetch and render custom fields for one category ID.
 * @param {string} id    The category ID
 * @param {string} label The category’s name (for the heading)
 */
function loadFieldsForCategory(id, label) {
  // Create a placeholder group
  const $group = $(`
    <div class="category-fields-group mb-4">
      <h5 class="fw-bold">${$('<div>').text(label).html()}</h5>
      <div class="category-fields-body">Loading…</div>
    </div>
  `);
  // Append it to the container
  $('#cfContainer').append($group);

  // Fetch the fields via AJAX
  $.ajax({
    method: 'POST',
    url: `${siteUrl}/browsing/categories/${id}/fields`,
    data: {
      _token: $('input[name="_token"]').val(),
      languageCode: languageCode,
      postId: typeof postId !== 'undefined' ? postId : ''
    }
  })
  .done(xhr => {
    // Replace “Loading…” with the HTML returned by the server
    $group.find('.category-fields-body').html(xhr.customFields);
    // Re-init any select2 dropdowns inside that group
    initSelect2($group, languageCode);
  })
  .fail(() => {
    $group.find('.category-fields-body')
          .html('<div class="text-danger">Failed to load fields.</div>');
  });
}

/* Prevent errors, If these variables are missing. */
if (typeof categoryWasSelected === 'undefined') {
	var categoryWasSelected = false;
}
if (typeof packageIsEnabled === 'undefined') {
	var packageIsEnabled = false;
}
var select2Language = languageCode;
if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
	select2Language = langLayout.select2;
}
if (typeof permanentPostsEnabled === 'undefined') {
	var permanentPostsEnabled = 0;
}
if (typeof postTypeId === 'undefined') {
	var postTypeId = 0;
}
if (typeof editLabel === 'undefined') {
	var editLabel = 'Edit';
}
// --- Multi-category selection state ---
let selectedCats = new Set();
let isMultiMode = false;

onDocumentReady((event) => {
  // Multi‐select state
  let selectedCats  = new Set();
  let selectedNames = {}; // ← NEW: keeps each ID’s human label
  let isMultiMode   = false;

  // 1) Whenever the modal opens, reseed from hidden inputs
  $('#browseCategories').on('show.bs.modal', () => {
    selectedCats.clear();
    selectedNames = {};
    $('#catsContainer')
      .find('input[name="categories[]"]')
      .each(function() {
        const id = String($(this).val());
        selectedCats.add(id);
        // read the corresponding <li> for the label
        const label = $(`#catsList li[data-id="${id}"]`).clone()
                          .children().remove().end().text().trim();
        selectedNames[id] = label;
      });
  });

  // 2) Initial tree load
   // 2) Detect multi‐mode BEFORE building the tree
 const launcher = document.querySelector('.modal-cat-link.open-selection-url');
 if (
   launcher &&
   launcher.dataset.selectionUrl.includes('multiple=1')
 ) {
   isMultiMode = true;
 }

 // 2.1) If Edit page, seed any pre‐selected IDs into our JS state
 if (isMultiMode) {
   $('#catsContainer').find('input[name="categories[]"]').each(function() {
     const id = String($(this).val());
     selectedCats.add(id);
     const label = $(`#catsList li[data-id="${id}"]`).clone()
                       .children().remove().end().text().trim();
     selectedNames[id] = label;
   });
 }

 // 3) Now build the category tree (common for Create & Edit)
 getCategories(siteUrl, languageCode);

 // 3.1) Immediately load custom fields for seeded categories (Edit only)
 if (isMultiMode && selectedCats.size) {
   const $cf = $('#cfContainer').empty();
   selectedCats.forEach(id => {
     // …reuse your AJAX logic to fetch/render fields…
   });
 }

 
  // 4+5) Click handler: leaf‐tiles toggle only in multi, otherwise AJAX
  $(document).on('click', '.modal-cat-link, #selectCats .page-link', function(e) {
    const $el    = $(this);
    const isLeaf = $el.hasClass('leaf-cat');

    if (isLeaf && isMultiMode) {
      e.preventDefault();
      e.stopPropagation();

      const id  = String($el.data('id'));
      const $box = $el.closest('.position-relative').find('.cat-checkbox')[0];
      const label = $el.find('h6').text().trim();

      if (selectedCats.has(id)) {
        selectedCats.delete(id);
        delete selectedNames[id];
        if ($box) $box.checked = false;
      } else {
        selectedCats.add(id);
        selectedNames[id] = label;
        if ($box) $box.checked = true;
      }
      return false;
    }

    // single‐mode or parent/pagination → AJAX
    e.preventDefault();
    getCategories(siteUrl, languageCode, this);
  });

  // 6) “Done” button → rebuild the entire form and fields
  $('#catsDoneBtn').off('click').on('click', () => {
    // 6.1) Visual list
    let listHtml = '<ul id="catsList">';
    selectedCats.forEach(id => {
      const safeLabel = $('<div>').text(selectedNames[id]||'Unknown').html();
      listHtml += `<li data-id="${id}">${safeLabel} ` +
                  `<span class="remove-cat" data-id="${id}">×</span>` +
                  `</li>`;
    });
    listHtml += '</ul>';

    // 6.2) Inject into catsContainer
    const $c = $('#catsContainer').html(listHtml);

    // 6.3) Re‐attach “Select/Edit” link
    const selectUrl = launcher
      ? launcher.dataset.selectionUrl
      : `${siteUrl}/browsing/categories/select?multiple=1`;
    const linkClass = '{{ linkClass() }}';
    const linkText  = '{{ t("select_categories") }}';
    $c.append(
      `<a href="#browseCategories" data-bs-toggle="modal"` +
      ` class="modal-cat-link open-selection-url ${linkClass}"` +
      ` data-selection-url="${selectUrl}">${linkText}</a>`
    );

    // 6.4) Hidden inputs
    $c.find('input[name="categories[]"], input[name="category_types[]"]').remove();
    selectedCats.forEach(id => {
      // assume you preserve category_types[] separately if needed
      $c.append(`<input type="hidden" name="categories[]" value="${id}">`);
    });

    // 6.5) Fetch & render per‐category fields
$('#cfContainer').empty();
selectedCats.forEach(id => {
  loadFieldsForCategory(id, selectedNames[id] || '');
});


    // 6.6) Close modal
    bootstrap.Modal.getInstance(
      document.getElementById('browseCategories')
    ).hide();
  });

  // 6.7) Remove‐cat “×” handler
  $(document).on('click', '#catsContainer .remove-cat', function() {
    const id = String($(this).data('id'));
    selectedCats.delete(id);
    delete selectedNames[id];
    // re‐render
    $('#catsDoneBtn').trigger('click');
  });

  // 6.8) EDIT-PAGE INITIAL LOAD:
// If we’re in multi-mode and have pre-selected categories, load their fields now
if (isMultiMode && selectedCats.size > 0) {
  // Clear any existing fields
  $('#cfContainer').empty();
  // Load each category’s fields
  selectedCats.forEach(id => {
    loadFieldsForCategory(id, selectedNames[id] || '');
  });
}


  // 7) Permanent‐posts toggle (unchanged)
  showPermanentPostsOption(permanentPostsEnabled, postTypeId);
  $('input[name="post_type_id"]').on('click', function() {
    postTypeId = $(this).val();
    showPermanentPostsOption(permanentPostsEnabled, postTypeId);
  });
});





/**
 * Get subcategories buffer and/or Append selected category
 */
function getCategories(siteUrl, languageCode, jsThis = null) {
  let csrfToken = $('input[name=_token]').val();

  // Determine URL & ID
  let url;
  let selectedId      = $('#categoryId').val();
  let beingSelectedId = 0;
  let selectedManually = false;

  if (!isDefined(jsThis) || jsThis === null) {
    beingSelectedId = !isEmpty(selectedId) ? selectedId : 0;
    url             = `${siteUrl}/browsing/categories/select`;
    if (!categoryWasSelected) return false;
  } else {
    const thisEl       = $(jsThis);
    selectedManually   = true;
    url                = thisEl.hasClass('page-link')
                       ? thisEl.attr('href')
                       : thisEl.data('selection-url');
    beingSelectedId    = parseInt(thisEl.data('id')) || 0;

    // If leaf, optimize by appending directly
    let hasChildren = thisEl.data('has-children');
    if (isDefined(hasChildren) && (hasChildren === 0 || hasChildren === '0')) {
      let catName     = thisEl.text();
      let catType     = thisEl.data('type');
      let catParentId = thisEl.data('parent-id');
      let catParentUrl = urlQuery(url)
                          .setParameters({ parentId: catParentId })
                          .toString();
      let linkText    = `<i class="fa-regular fa-pen-to-square"></i> ${editLabel}`;
      let outputHtml  = 
            catName +
            `[ <a href="#browseCategories"
                   data-bs-toggle="modal"
                   class="modal-cat-link open-selection-url link-primary text-decoration-none"
                   data-selection-url="${catParentUrl}"
               >${linkText}</a> ]`;

      return appendSelectedCategory(
        siteUrl,
        languageCode,
        beingSelectedId,
        catType,
        outputHtml,
        selectedManually
      );
    }
  }

  // AJAX payload
  let payload = { parentId: beingSelectedId };
  if (!isEmpty(selectedId)) payload.selectedId = selectedId;

  // Perform AJAX
  $.ajax({
    method: 'GET',
    url: url,
    data: payload,
    beforeSend() {
      let el = $('#selectCats');
      el.empty().addClass('py-4').busyLoad('hide');
      el.busyLoad('show', {
        text: langLayout.loading,
        custom: createCustomSpinnerEl(),
        containerItemClass: 'm-5',
      });
    }
  })
  .done(function(xhr) {
    let el = $('#selectCats');
    el.removeClass('py-4').busyLoad('hide');
    if (!isDefined(xhr.html) || !isDefined(xhr.hasChildren)) return false;

    if (xhr.hasChildren) {
      // ── Inject children HTML ──
      el.removeClass('text-center').html(xhr.html);

      // ── 8) Re-tick our checkboxes ──
      selectedCats.forEach(id => {
        el.find(`.cat-checkbox[data-id="${id}"]`).prop('checked', true);
      });

    } else {
      // … your existing single-select leaf logic …
      if (!isDefined(xhr.category) || !isDefined(xhr.category.id)) return false;

      if (isMultiMode) {
        // toggle in JS Set only
        const leafId = xhr.category.id.toString();
        const box    = el.find(`.cat-checkbox[data-id="${leafId}"]`)[0];
        if (selectedCats.has(leafId)) {
          selectedCats.delete(leafId);
          if (box) box.checked = false;
        } else {
          selectedCats.add(leafId);
          if (box) box.checked = true;
        }
        return false;
      }

      // fallback: single select
      return appendSelectedCategory(
        siteUrl,
        languageCode,
        xhr.category.id,
        xhr.category.type,
        xhr.html,
        selectedManually
      );
    }
  })
  .fail(function(xhr) {
    let msg = getErrorMessageFromXhr(xhr);
    if (msg) jsAlert(msg, 'error', false, true);
    let modalEl = document.getElementById('browseCategories');
    bootstrap.Modal.getInstance(modalEl)?.hide();
  });
}


/**
 * Get subcategories buffer and/or Append selected category
 *
 * @param siteUrl
 * @param languageCode
 * @param jsThis
 * @returns {boolean}
 */
function getCategories(siteUrl, languageCode, jsThis = null) {
	let csrfToken = $('input[name=_token]').val();
	
	/* Get Request URL */
	let url;
	
	let selectedId = $('#categoryId').val();
	let beingSelectedId;
	let selectedManually = false;
	
	if (!isDefined(jsThis) || jsThis === null) {
		/* On page load, without click on the modal link */
		// ---
		beingSelectedId = !isEmpty(selectedId) ? selectedId : 0;
		
		/* Set the global selection URL */
		url = `${siteUrl}/browsing/categories/select`;
		
		if (!categoryWasSelected) {
			return false;
		}
		
	} else {
		/* Click on the modal link */
		// ---
		const thisEl = $(jsThis);
		selectedManually = true;
		
        // FIRST, check if it's a pagination link; otherwise read our real selection URL
        if (thisEl.hasClass('page-link')) {
            url = thisEl.attr('href');
        } else {
            url = thisEl.data('selection-url');
        }
        // And always pick up the ID from the clicked tile
        beingSelectedId = parseInt(thisEl.data('id')) || 0;
		
		/*
		 * Optimize the category selection
		 * by preventing AJAX request to append the selection
		 */
		let hasChildren = thisEl.data('has-children');
		if (isDefined(hasChildren) && (hasChildren === 0 || hasChildren === '0')) {
			let catName = thisEl.text();
			let catType = thisEl.data('type');
			let catParentId = thisEl.data('parent-id');
			let catParentUrl = urlQuery(url).setParameters({parentId: catParentId}).toString();
			
			let linkText = `<i class="fa-regular fa-pen-to-square"></i> ${editLabel}`;
			let outputHtml = catName
				+ `[ <a href="#browseCategories"
						data-bs-toggle="modal"
						class="modal-cat-link open-selection-url link-primary text-decoration-none"
						data-selection-url="${catParentUrl}"
					>${linkText}</a> ]`;
			
			return appendSelectedCategory(siteUrl, languageCode, beingSelectedId, catType, outputHtml, selectedManually);
		}
	}
	
	const payload = {
		'parentId': beingSelectedId
	};
	if (!isEmpty(selectedId)) {
		payload['selectedId'] = selectedId;
	}
	
	/* Reorder the category list */
	/* const categoryListReorder = new BsRowColumnsReorder('#modalCategoryList', {defaultColumns: 6}); */
	
	/* AJAX Call */
	let ajax = $.ajax({
		method: 'GET',
		url: url,
		data: payload,
		beforeSend: function() {
			/*
			let spinner = '<i class="spinner-border"></i>';
			$('#selectCats').addClass('text-center').html(spinner);
			*/
			
			let selectCatsEl = $('#selectCats');
			selectCatsEl.empty().addClass('py-4').busyLoad('hide');
			selectCatsEl.busyLoad('show', {
				text: langLayout.loading,
				custom: createCustomSpinnerEl(),
				containerItemClass: 'm-5',
			});
		}
	});
	ajax.done(function (xhr) {
		let selectCatsEl = $('#selectCats');
		selectCatsEl.removeClass('py-4').busyLoad('hide');
		
		if (!isDefined(xhr.html) || !isDefined(xhr.hasChildren)) {
			return false;
		}
		
		 /* Get & append the category's children */
    if (xhr.hasChildren) {
        selectCatsEl.removeClass('text-center');
        selectCatsEl.html(xhr.html);
		// Re-apply any existing checks
selectedCats.forEach(id => {
  const cb = selectCatsEl.find(`.cat-checkbox[data-id="${id}"]`)[0];
  if (cb) cb.checked = true;
});

    } else {
        // Must have category info & HTML
        if (
            !isDefined(xhr.category) ||
            !isDefined(xhr.category.id) ||
            !isDefined(xhr.category.type) ||
            !isDefined(xhr.html)
        ) {
            return false;
        }

        // Multi-select mode: just toggle our Set + checkbox
        if (isMultiMode) {
            const leafId = xhr.category.id.toString();
            const checkbox = selectCatsEl.find(`.cat-checkbox[data-id="${leafId}"]`)[0];
            if (selectedCats.has(leafId)) {
                selectedCats.delete(leafId);
                if (checkbox) checkbox.checked = false;
            } else {
                selectedCats.add(leafId);
                if (checkbox) checkbox.checked = true;
            }
            return false;
        }

        // Single-select fallback: collapse & append
        return appendSelectedCategory(
            siteUrl,
            languageCode,
            xhr.category.id,
            xhr.category.type,
            xhr.html,
            selectedManually
        );
    }
});
	ajax.fail(function(xhr) {
		let message = getErrorMessageFromXhr(xhr);
		if (message !== null) {
			jsAlert(message, 'error', false, true);
			
			/* Close the Modal */
			let modalEl = document.querySelector('#browseCategories');
			if (typeof modalEl !== 'undefined' && modalEl !== null) {
				let modalObj = bootstrap.Modal.getInstance(modalEl);
				if (modalObj !== null) {
					modalObj.hide();
				}
			}
		}
	});
}

/**
 * Append the selected category to its field in the form
 *
 * @param siteUrl
 * @param languageCode
 * @param catId
 * @param catType
 * @param outputHtml
 * @param selectedManually
 * @returns {boolean}
 */
function appendSelectedCategory(siteUrl, languageCode, catId, catType, outputHtml, selectedManually) {
	if (!isDefined(catId) || !isDefined(catType) || !isDefined(outputHtml)) {
		return false;
	}
	
	try {
		/* Select the category & append it */
		$('#catsContainer').html(outputHtml);
		
		/* Save data in hidden field */
		const categoryIdEl = document.getElementById('categoryId');
		if (categoryIdEl) {
			categoryIdEl.value = catId;
			if (selectedManually) {
				categoryIdEl.dispatchEvent(new Event('input', {bubbles: true}));
			}
		}
		const categoryTypeEl = document.getElementById('categoryType');
		if (categoryTypeEl) {
			categoryTypeEl.value = catType;
			if (selectedManually) {
				categoryTypeEl.dispatchEvent(new Event('input', {bubbles: true}));
			}
		}
		
		/* Close the Modal */
		let modalEl = document.querySelector('#browseCategories');
		if (isDefined(modalEl) && modalEl !== null) {
			let modalObj = bootstrap.Modal.getInstance(modalEl);
			if (modalObj !== null) {
				modalObj.hide();
			}
		}
		
		/* Apply category's type actions & Get category's custom-fields */
		applyCategoryTypeActions('categoryType', catType, packageIsEnabled);
		getCustomFieldsByCategory(siteUrl, languageCode, catId);
	} catch (e) {
		console.log(e);
	}
	
	return false;
}

/**
 * Get the Custom Fields by Category
 *
 * @param siteUrl
 * @param languageCode
 * @param catId
 * @returns {*}
 */
function getCustomFieldsByCategory(siteUrl, languageCode, catId) {
	/* Check undefined variables */
	if (!isDefined(languageCode) || !isDefined(catId)) {
		return false;
	}
	
	/* Don't make ajax request if any category has selected. */
	if (isEmpty(catId) || catId === 0) {
		return false;
	}
	
	let csrfToken = $('input[name=_token]').val();
	
	let url = `${siteUrl}/browsing/categories/${catId}/fields`;
	
	let dataObj = {
		'_token': csrfToken,
		'languageCode': languageCode,
		'postId': isDefined(postId) ? postId : ''
	};
	if (isDefined(errors)) {
		/* console.log(errors); */
		dataObj.errors = errors;
	}
	if (isDefined(oldInput)) {
		/* console.log(oldInput); */
		dataObj.oldInput = oldInput;
	}
	
	const ajax = $.ajax({
		method: 'POST',
		url: url,
		data: dataObj,
		beforeSend: function() {
			const cfEl = $('#cfContainer');
			
			let spinner = '<i class="spinner-border"></i>';
			cfEl.addClass('text-center mb-3').html(spinner);
		}
	});
	ajax.done(function (xhr) {
		const cfEl = $('#cfContainer');
		
		/* Load Custom Fields */
		cfEl.removeClass('text-center mb-3');
		cfEl.html(xhr.customFields);
		
		/* Apply Fields Components */
		initSelect2(cfEl, languageCode);
	});
	ajax.fail(function(xhr) {
		let message = getErrorMessageFromXhr(xhr);
		if (message !== null) {
			jsAlert(message, 'error', false);
		}
	});
	
	return catId;
}

/**
 * Apply Category Type actions (for Job offer/search & Services for example)
 *
 * @param categoryTypeFieldId
 * @param categoryTypeValue
 * @param packageIsEnabled
 */
function applyCategoryTypeActions(categoryTypeFieldId, categoryTypeValue, packageIsEnabled) {
	$('#' + categoryTypeFieldId).val(categoryTypeValue);
	
	/* Debug */
	/* console.log(categoryTypeFieldId + ': ' + categoryTypeValue); */
	
	if (categoryTypeValue === 'job-offer') {
		$('#postTypeBloc label[for="postTypeId-1"]').show();
		$('#priceBloc label[for="price"]').html(lang.salary);
		$('#priceBloc').show();
	} else if (categoryTypeValue === 'job-search') {
		$('#postTypeBloc label[for="postTypeId-2"]').hide();
		
		$('#postTypeBloc input[value="1"]').attr('checked', 'checked');
		$('#priceBloc label[for="price"]').html(lang.salary);
		$('#priceBloc').show();
	} else if (categoryTypeValue === 'not-salable') {
		$('#priceBloc').hide();
		
		$('#postTypeBloc label[for="postTypeId-2"]').show();
	} else {
		$('#postTypeBloc label[for="postTypeId-2"]').show();
		$('#priceBloc label[for="price"]').html(lang.price);
		$('#priceBloc').show();
	}
	
	$('#nextStepBtn').html(lang.nextStepBtnLabel.next);
}

function initSelect2(selectElementObj, languageCode) {
	const theme = 'bootstrap-5';
	const select2Els = selectElementObj.find('.select2-from-array');
	const largeSelect2Els = selectElementObj.find('.select2-from-large-array');
	
	const options = {
		language: select2Language,
		dropdownAutoWidth: 'true',
		width: '100%',
		minimumResultsForSearch: Infinity /* Hiding the search box */
	};
	
	if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
		options.language = langLayout.select2;
	}
	if (typeof theme !== 'undefined') {
		options.theme = theme;
	}
	
	/* Non-searchable select boxes */
	if (select2Els.length) {
		select2Els.each((index, element) => {
			if (!$(element).hasClass('select2-hidden-accessible')) {
				if (typeof theme !== 'undefined') {
					if (theme === 'bootstrap-5') {
						let widthOption = $(element).hasClass('w-100') ? '100%' : 'style';
						options.width = $(element).data('width') ? $(element).data('width') : widthOption;
						options.placeholder = $(element).data('placeholder');
					}
				}
				
				$(element).select2(options);
				
				/* Indicate that the value of this field has changed */
				$(element).on('select2:select', (e) => {
					element.dispatchEvent(new Event('input', {bubbles: true}));
				});
			}
		});
	}
	
	/* Searchable select boxes */
	if (largeSelect2Els.length) {
		largeSelect2Els.each((index, element) => {
			if (!$(element).hasClass('select2-hidden-accessible')) {
				if (typeof theme !== 'undefined') {
					if (theme === 'bootstrap-5') {
						const widthOption = $(element).hasClass('w-100') ? '100%' : 'style';
						const width = $(element).data('width');
						options.width = width ? width : widthOption;
						options.placeholder = $(element).data('placeholder');
					}
				}
				
				delete options.minimumResultsForSearch;
				$(element).select2(options);
				
				/* Indicate that the value of this field has changed */
				$(element).on('select2:select', (e) => {
					element.dispatchEvent(new Event('input', {bubbles: true}));
				});
			}
		});
	}
}

/**
 * Show the permanent listings option field
 *
 * @param permanentPostsEnabled
 * @param postTypeId
 * @returns {boolean}
 */
function showPermanentPostsOption(permanentPostsEnabled, postTypeId)
{
	if (permanentPostsEnabled === '0' || permanentPostsEnabled === 0) {
		$('#isPermanentBox').empty();
		return false;
	}
	if (permanentPostsEnabled === '1' || permanentPostsEnabled === 1) {
		if (postTypeId === '1' || postTypeId === 1) {
			$('#isPermanentBox').removeClass('hide');
		} else {
			$('#isPermanentBox').addClass('hide');
			$('#isPermanent').prop('checked', false);
		}
	}
	if (permanentPostsEnabled === '2' || permanentPostsEnabled === 2) {
		if (postTypeId === '2' || postTypeId === 2) {
			$('#isPermanentBox').removeClass('hide');
		} else {
			$('#isPermanentBox').addClass('hide');
			$('#isPermanent').prop('checked', false);
		}
	}
	    if (permanentPostsEnabled === '3' || permanentPostsEnabled === 3) {
        // '3' = always permanent when postTypeId = 2
        var isPermanentField = $('#isPermanent');
        if (isPermanentField.length) {
            if (postTypeId === '2' || postTypeId === 2) {
                isPermanentField.val('1');
            } else {
                isPermanentField.val('0');
            }
        }
    }
    if (permanentPostsEnabled === '4' || permanentPostsEnabled === 4) {
        // '4' = always show the checkbox
        $('#isPermanentBox').removeClass('hide');
    }
}  // <-- Close showPermanentPostsOption