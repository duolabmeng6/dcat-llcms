<?php

namespace Ll\llcms\Models;


use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;

/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class Category extends Model implements Sortable
{
    protected $table = 'cms_category';

    use HasDateTimeFormatter,
        CategoryCache,
        ModelTree {
            ModelTree::allNodes as treeAllNodes;
            ModelTree::boot as treeBoot;
        }

    /**
     * @var array
     */
    protected $sortable = [
        'sort_when_creating' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri', 'extension', 'show'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Get all elements.
     *
     * @param  bool  $force
     * @return static[]|\Illuminate\Support\Collection
     */
    public function allNodes(bool $force = false)
    {
        if ($force || $this->queryCallbacks) {
            return $this->fetchAll();
        }

        return $this->remember(function () {
            return $this->fetchAll();
        });
    }

    /**
     * Fetch all elements.
     *
     * @return static[]|\Illuminate\Support\Collection
     */
    public function fetchAll()
    {
        return $this->withQuery(function ($query) {
            return $query;
        })->treeAllNodes();
    }

    /**
     * Determine if enable menu bind permission.
     *
     * @return bool
     */
    public static function withPermission()
    {
        return false;
    }

    /**
     * Determine if enable menu bind role.
     *
     * @return bool
     */
    public static function withRole()
    {
        return false;
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        static::treeBoot();

        static::deleting(function ($model) {
            $model->flushCache();
        });

        static::saved(function ($model) {
            $model->flushCache();
        });
    }
}
