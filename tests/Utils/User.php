<?php

declare(strict_types=1);

namespace Activity\Tests\Utils;

use Activity\Traits\PerformsActions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use PerformsActions;

    protected $guarded = [];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
