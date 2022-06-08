<?php

namespace Ll\llcms\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Category extends EloquentRepository
{
    public function __construct($modelOrRelations = [])
    {
        $this->eloquentClass = \Ll\llcms\Models\Category::class;

        parent::__construct($modelOrRelations);
    }
}
