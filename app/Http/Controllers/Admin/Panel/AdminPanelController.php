<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Discount\DiscountsModel;
use App\Models\Loging\LogUserModel;
use App\Models\User\UsersBonusesModel;
use App\Models\User\UsersCategoryModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use View;

/**
 * Class AdminPanelController
 * @package App\Http\Controllers\Admin\Panel
 *
 * Class represent show all user's info
 * url /admin/users
 * ability to choose user
 * update user's info
 * delete user
 * select user's order
 * show all user's logs
 */
class AdminPanelController extends Controller
{
    public function searchUser()
    {
        return view('admin.panel.users.index');
    }

    public function showUsers(Request $request)
    {
        $users = User::filterByQuery($request->searchString)->get();
        return response()->json($users);
    }

    public function getUser(Request $request, $userId)
    {

        $userLogs = LogUserModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->with(['logAction', 'author', 'user', 'fromto'])->paginate(5);
        $this->changeLogsToRussian($userLogs);

        //ajax paginate order logs
        if ($request->ajax()) {
            return response()->json(View::make('admin.panel.users.logs', compact('userLogs'))->render());
        }

        $user = User::where('id', $userId)->with(['orders', 'usersCategories', 'bonuses', 'balances'])->first();

        $usersCategories = UsersCategoryModel::all();

        //get discounts from userCategories for current user
        $user->load(['usersCategories.discounts' => function ($q) use (&$discounts) {
            $discounts = $q->get()->unique();
        }]);

        $user['categoriesDiscounts'] = $discounts;

        $user['discounts'] = $user->discounts()->get();

        //get all ids of user's discount
        $userDiscountsIds = [];
        foreach($user['discounts'] as $discount){
            array_push($userDiscountsIds, $discount->id);
        }
        foreach($user['categoriesDiscounts'] as $discount){
            array_push($userDiscountsIds, $discount->id);
        }

        $allDiscounts = DiscountsModel::whereNotIn('id', $userDiscountsIds)->get();


        return view('admin.panel.users.show', compact('user', 'userId', 'userLogs', 'usersCategories', 'allDiscounts'));
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $userId = (int)$request->get('id');

        $oldUser = User::findOrFail($userId);
        $isUpdated = $oldUser->update($request->all());
        if (!$isUpdated) {
            return response()->json($oldUser);
        }

        //get user with the last record in dev_users_log
        $user = User::with(['orders', 'usersCategories', 'userLogs' => function ($query) use ($oldUser) {
            $query->where('created_at', '>=', $oldUser->updated_at)->with(['logAction', 'author', 'user', 'fromto'])->get();
        }])->findOrFail($userId);

        $usersLogs = $user->userLogs;
        $this->changeLogsToRussian($usersLogs);

        return response()->json($user);

    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUsersCategories(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $usersCategoryIds = $request->data;
        $user->usersCategories()->sync($usersCategoryIds);
        $userCategories = $user->usersCategories()->get();

        return response()->json($userCategories);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * return new userBonuses with it's new log
     */
    public function updateUsersBonuses(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $bonuses = $user->bonuses()->firstOrFail();
        $bonuses->bonuses_amount = $request->bonuses_amount;
        $bonuses->bonuses_comment = $request->bonus_comment;
        $isUpdated = $bonuses->update();

        if (!$isUpdated) {
            return response()->json($bonuses);
        }
        $userLogs = LogUserModel::where('user_id', $userId)
            ->where('created_at', '>=', $bonuses->updated_at)
            ->with(['logAction', 'author', 'user', 'fromto'])->get();
        $this->changeLogsToRussian($userLogs);

        $bonuses['user_logs'] = $userLogs;
        return response()->json($bonuses);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * return new userBalance with it's new log
     */
    public function updateUsersBalance(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $balance = $user->balances()->firstOrFail();
        $balance->balance_amount = $request->balance_amount;
        $balance->balance_comment = $request->balance_comment;
        $isUpdated = $balance->update();

        if (!$isUpdated) {
            return response()->json($balance);
        }
        $userLogs = LogUserModel::where('user_id', $userId)
            ->where('created_at', '>=', $balance->updated_at)
            ->with(['logAction', 'author', 'user', 'fromto'])->get();
        $this->changeLogsToRussian($userLogs);

        $balance['user_logs'] = $userLogs;
        return response()->json($balance);
    }

    public function destroyUser(Request $request)
    {
        $userId = $request->get('id');
        $user = User::findOrFail($userId);
        $user->delete();
        return response()->json(['msg' => 'User has been deleted successfully']);
    }

    private function getRussianFieldName($field)
    {
        switch ($field) {
            case ('l_name'):
                return 'фамилия';
                break;
            case ('f_name'):
                return 'имя';
                break;
            case ('city'):
                return 'город';
                break;
            case ('phone'):
                return 'телефон';
                break;
            case ('name'):
                return 'полное имя';
                break;
            case ('gender'):
                return 'полное имя';
                break;
            case ('date_of_birth'):
                return 'дата рождения';
                break;
            case ('bonuses_amount'):
                return 'количество бонусов';
                break;
            case ('balance_amount'):
                return 'количество на личном счете';
                break;
            case ('bonuses_comment'):
                return 'комментарий к бонусам';
                break;
            case ('balance_comment'):
                return 'комментарий на личном счете';
                break;

            default:
                return $field;
        }
    }

    /**
     * @param $usersLogs
     * @internal param $user
     */
    private function changeLogsToRussian($usersLogs)
    {
        foreach ($usersLogs as $userLog) {
            $userLog['field_changed'] = $this->getRussianFieldName($userLog['field_changed']);
        }
    }
}
