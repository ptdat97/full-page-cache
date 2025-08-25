<?php

namespace Botble\FullPageCache\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\FullPageCache\Http\Requests\FullPageCacheRequest;
use Botble\FullPageCache\Models\FullPageCache;
use Botble\Base\Http\Controllers\BaseController;
use Botble\FullPageCache\Tables\FullPageCacheTable;
use Botble\FullPageCache\Forms\FullPageCacheForm;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class FullPageCacheController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/full page cache::full-page-cache.name')), route('full-page-cache.index'));
    }

    public function index(FullPageCacheTable $table)
    {
        $this->pageTitle(trans('plugins/full page cache::full-page-cache.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/full page cache::full-page-cache.create'));

        return FullPageCacheForm::create()->renderForm();
    }

    public function store(FullPageCacheRequest $request)
    {
        $form = FullPageCacheForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('full-page-cache.index'))
            ->setNextUrl(route('full-page-cache.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(FullPageCache $fullPageCache)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $fullPageCache->name]));

        return FullPageCacheForm::createFromModel($fullPageCache)->renderForm();
    }

    public function update(FullPageCache $fullPageCache, FullPageCacheRequest $request)
    {
        FullPageCacheForm::createFromModel($fullPageCache)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('full-page-cache.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(FullPageCache $fullPageCache)
    {
        return DeleteResourceAction::make($fullPageCache);
    }
        public function clear()
    {
        File::cleanDirectory(public_path('cache/fullpage'));
        return redirect()->back()->with('status', 'Full Page Cache cleared!');
    }
}
