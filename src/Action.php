<?php

declare(strict_types=1);

namespace Activity;

use Activity\Contracts\IAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User;

/**
 * @property $action_type
 * @property $description
 * @property $subject_type
 * @property $subject_id
 * @property $performer_id
 * @property $performer_type
 */
class Action extends Model implements IAction
{
    protected $table = 'actions';
    protected $guarded = [];
    protected array $allowedActionTypes = ['CREATE', 'UPDATE', 'DELETE'];

    public function getActionType(): string
    {
        return $this->action_type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function performer(): HasOne
    {
        /**
         * Using the Illuminate class rather than the package class will mean that this
         * will work in any laravel app that uses it
         */
        return $this->hasOne(User::class, 'id', 'performer_id');
    }

    public function subject(): HasOne
    {
        return $this->hasOne($this->subject_type, 'id', 'subject_id');
    }

    // TODO: Write logic for actions model
}
