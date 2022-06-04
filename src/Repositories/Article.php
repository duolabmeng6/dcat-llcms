<?php

namespace Ll\llcms\Repositories;

use Ll\llcms\Models\Article as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Article extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
