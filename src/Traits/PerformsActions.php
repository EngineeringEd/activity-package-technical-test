<?php

declare(strict_types=1);

namespace Activity\Traits;

use Activity\Action;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait PerformsActions
{
    public function performedActions(): HasMany
    {
        return $this->hasMany(Action::class, 'performer_id', 'id');
    }
}
