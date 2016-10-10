<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Models\Discount\DiscountsModel;
use App\Models\User\UsersCategoryModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class AdminPanelDiscountUserController extends Controller
{

    public function showAddingUserCategories($discountId)
    {
        $discount = DiscountsModel::findOrFail($discountId);
        $userCategories = UsersCategoryModel::all();

        return view('admin.panel.discounts.addUserCategories')
            ->with('discount', $discount)
            ->with('userCategories', $userCategories);
    }

    public function addUserCategories(Request $request, $discountId)
    {
        $userCategories = UsersCategoryModel::findOrFail($request->userCategories);
        $discount = DiscountsModel::findOrFail($discountId);
        $discount->usersCategories()->attach($userCategories);

        Session::flash('message', 'Пользовательские категории успешно добавленны к дискаунту');

        return redirect()->route('adminTable.users.searchUser');
    }

    public function addDiscounts(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $userDiscountsIds = $request->userDiscounts;
        $user->discounts()->attach($userDiscountsIds);

        Session::flash('message', 'Дискаунты успешно добавлены');

        return redirect()->route('adminTable.users.index', ['user' => $userId]);

    }

    public function removeDiscounts(Request $request, $userId, $discountId)
    {
        $user = User::findOrFail($userId);
        $discount = DiscountsModel::findOrFail($discountId);
        $user->discounts()->detach($discount);

        Session::flash('message', 'Дискаунт успешно убран');

        return redirect()->route('adminTable.users.index', ['user' => $userId]);
    }
}
