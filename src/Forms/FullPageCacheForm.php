<?php

namespace Botble\FullPageCache\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\FullPageCache\Http\Requests\FullPageCacheRequest;
use Botble\FullPageCache\Models\FullPageCache;

class FullPageCacheForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(FullPageCache::class)
            ->setValidatorClass(FullPageCacheRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
