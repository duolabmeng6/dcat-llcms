<?php

namespace Ll\llcms\Repositories;

use Ll\llcms\Models\Tag as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Tag extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
