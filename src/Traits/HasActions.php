<?php

declare(strict_types=1);

namespace Activity\Traits;

use Activity\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

trait HasActions
{
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class, 'subject_id', 'id');
    }

    public static function bootHasActions(): void
    {
        static::created(function (Model $item) {
            Action::create([
                'performer_id' => auth()->id(),
                'performer_type' => (new User)->getMorphClass(),
                'subject_type' => $item->getMorphCLass(),
                'subject_id' => $item->id,
                'action_type' => 'CREATE',
                'description' => __('activity-package::descriptions.created'),
            ]);
        });

        static::updated(function (Model $item) {
            Action::create([
                'performer_id' => auth()->id(),
                'performer_type' => (new User)->getMorphClass(),
                'subject_type' => $item->getMorphCLass(),
                'subject_id' => $item->id,
                'action_type' => 'UPDATE',
                'description' => __('activity-package::descriptions.updated'),
            ]);
        });

        static::deleted(function (Model $item) {
            Action::create([
                'performer_id' => auth()->id(),
                'performer_type' => (new User)->getMorphClass(),
                'subject_type' => $item->getMorphCLass(),
                'subject_id' => $item->id,
                'action_type' => 'DELETE',
                'description' => __('activity-package::descriptions.deleted'),
            ]);
        });
    }
}
