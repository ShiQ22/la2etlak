<?php
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

namespace App\Http\Controllers\Web\Front\Post\CreateOrEdit\MultiSteps\Create;

use App\Helpers\Common\Files\TmpUpload;
use App\Http\Requests\Front\PostRequest;
use App\Models\CategoryField;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
class PostController extends BaseController
{
	/**
	 * Listing's step
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function showForm(Request $request): View|RedirectResponse
{
    // Check if the 'Pricing Page' must be started first, and make redirection to it.
    $pricingUrl = $this->getPricingPage($this->getSelectedPackage());
    if (!empty($pricingUrl)) {
        return redirect()->to($pricingUrl)->withHeaders(config('larapen.core.noCacheHeaders'));
    }

    // Check if the form type is 'Single-Step Form' and make redirection to it (permanently).
    if (isSingleStepFormEnabled()) {
        $url = urlGen()->addPost();
        if ($url != request()->fullUrl()) {
            return redirect()->to($url, 301)->withHeaders(config('larapen.core.noCacheHeaders'));
        }
    }

    // Create a unique temporary ID
    if (!session()->has('cfUid')) {
        session()->put('cfUid', 'cf-' . generateUniqueCode(9));
    }

    $postInput = session('postInput');

    // Ensure that the country data stored in the session corresponds to the current selection
    $this->syncSessionCountryData();

    // Get steps URLs & labels
    $previousStepUrl   = null;
    $previousStepLabel = null;
    $formActionUrl     = request()->fullUrl();
    $nextStepUrl       = null;
    $nextStepLabel     = t('Next') . '  <i class="bi bi-chevron-right"></i>';

    // Capture the Lost/Found type (default to 'lost')
    $type = $request->query('type', 'lost');

    // Share steps URLs & label variables
    view()->share('previousStepUrl', $previousStepUrl);
    view()->share('previousStepLabel', $previousStepLabel);
    view()->share('formActionUrl', $formActionUrl);
    view()->share('nextStepUrl', $nextStepUrl);
    view()->share('nextStepLabel', $nextStepLabel);

    // ◆◆◆ Load all categories so the modal has data on first open ◆◆◆
        $categories = Category::all();

        // Render the view, passing postInput, type, and categories
        return view(
            'front.post.createOrEdit.multiSteps.create.post',
            [
                'postInput'  => $postInput,
                'type'       => $type,
                'categories' => $categories,    // ← Newly passed variable
            ]
        );
}

	
	/**
 * Listing's step (POST)
 *
 * @param \App\Http\Requests\Front\PostRequest $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function postForm(PostRequest $request): RedirectResponse
{
    // 1) Grab everything _except_ unwanted, but then ensure we include 'type'
    $postInput = $request->except($this->unwantedFields());

    // 2) FORCE in the Lost/Found choice
    $postInput['type'] = $request->input('type', 'lost');

    // 3) Use unique ID to store post's pictures
    if (session()->has('cfUid')) {
        $this->cfTmpUploadDir = $this->cfTmpUploadDir . '/' . session('cfUid');
    }

    // 4) Save uploaded files for *all* selected categories
    //    Retrieve the array of selected category IDs
    $categoryIds = $request->input('categories', []);

    //    Merge fields for each selected category
    /** @var \Illuminate\Support\Collection $fieldsCollection */
    $fieldsCollection = collect();
    foreach ($categoryIds as $catId) {
        $fieldsCollection = $fieldsCollection->merge(
            CategoryField::getFields($catId)
        );
    }
    //    Remove duplicates by field ID
    $fields = $fieldsCollection->unique('id');

    if ($fields->count() > 0) {
        foreach ($fields as $field) {
            if ($field->type == 'file' && $request->hasFile('cf.' . $field->id)) {
                $file = $request->file('cf.' . $field->id);
                if (!$file->isValid()) {
                    continue;
                }
                $postInput['cf'][$field->id] = TmpUpload::file($file, $this->cfTmpUploadDir);
            }
        }
    }

    // 5) LEGACY COMPATIBILITY: ensure category_id is set for the next-step URL
    if (!empty($categoryIds)) {
        $postInput['category_id'] = $categoryIds[0];
    } elseif ($request->filled('category_id')) {
        $postInput['category_id'] = $request->input('category_id');
    }

    // 6) Persist all form data (including categories[] and category_id) to session
    session()->put('postInput', $postInput);

    // 7) Compute next URL & redirect
    $currentStep = $this->getStepByKey(get_class($this));
    $nextUrl     = $this->getNextStepUrl($currentStep);

    return redirect()->to($nextUrl);
}

}
