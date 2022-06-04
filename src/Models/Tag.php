<?php

namespace Ll\llcms\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Ll\llcms\Models\Article;

class Tag extends Model
{
    use HasDateTimeFormatter;
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
