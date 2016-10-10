<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 19.08.2016
 * Time: 14:33
 */

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notifications\NotificationsListModel;
use Illuminate\Http\Request;

/**
 * Admin Notifications basic view
 * Getting all notifications and configuration
 */
class NotificationsIndexController extends Controller
{
    /**
     * Getting all notifications
     * Return $view
     */
    public function actionIndex( Request $request ) {

        $list = $this->actionGetNotificationsList();

        return view('admin.notifications.notifications', [
            'list' => $list,
            'success' => $request->input('success'),
        ]);
    }

    /**
     * Getting all notifications
     */
    private function actionGetNotificationsList()
    {
        $list = NotificationsListModel::get(
            ['id', 'notification']
        );

        return $list;
    }

}