<?php

namespace Activity\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

interface IAction
{
    function getActionType(): string;
    function getDescription(): string;
    function performer(): HasOne;
    function subject(): HasOne;
}
