<?php

declare(strict_types=1);

namespace Activity\Tests\Utils;

use Activity\Traits\HasActions;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasActions;

    protected $guarded = [];
}
