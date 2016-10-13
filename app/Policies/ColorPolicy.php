<?php

namespace App\Policies;

use App\Models\Product\ProductColorModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColorPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRoles([
            'СуперАдмин',
            'Маркетинг',
            'Контент',
            'Контент Руководитель',
        ])) {
            return true;
        }
    }

    public function actionGetCreateView(User $user, ProductColorModel $color)
    {
        return false;
    }

    public function actionCreate(User $user, ProductColorModel $color)
    {
        return false;
    }

    public function actionGetUpdateView(User $user, ProductColorModel $color)
    {
        return false;
    }

    public function actionDelete(User $user, ProductColorModel $color)
    {
        return false;
    }

    public function actionRead(User $user, ProductColorModel $color)
    {
        return false;
    }

    public function actionUpdate(User $user, ProductColorModel $color)
    {
        return false;
    }

}
