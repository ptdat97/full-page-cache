<?php

namespace Botble\FullPageCache\Tables;

use Botble\FullPageCache\Models\FullPageCache;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class FullPageCacheTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(FullPageCache::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('full-page-cache.create'))
            ->addActions([
                EditAction::make()->route('full-page-cache.edit'),
                DeleteAction::make()->route('full-page-cache.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('full-page-cache.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('full-page-cache.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                ]);
            });
    }
}
