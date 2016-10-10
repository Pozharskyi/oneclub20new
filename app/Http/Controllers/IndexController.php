<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.10.2016
 * Time: 12:56
 */

namespace App\Http\Controllers;

use App\Models\Category\CategoryModel;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $categories = CategoryModel::parents()
            ->get();

        return view('index', [
            'categories' => $categories,
        ]);
    }

}