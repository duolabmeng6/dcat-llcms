<?php

namespace Ll\llcms\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

}
