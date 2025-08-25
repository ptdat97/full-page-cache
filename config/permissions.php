<?php

return [
    [
        'name' => 'Full page caches',
        'flag' => 'full-page-cache.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'full-page-cache.create',
        'parent_flag' => 'full-page-cache.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'full-page-cache.edit',
        'parent_flag' => 'full-page-cache.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'full-page-cache.destroy',
        'parent_flag' => 'full-page-cache.index',
    ],
];
