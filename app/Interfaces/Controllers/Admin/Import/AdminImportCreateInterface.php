<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:30
 */

namespace App\Interfaces\Controllers\Admin\Import;

use Illuminate\Http\Request;

/**
 * Main interface for creation of any
 * element in system
 * Including view and method to create
 * Based on Request
 * Interface AdminImportCreateInterface
 * @package app\Interfaces\Controllers\Admin\Import
 */
interface AdminImportCreateInterface
{
    /**
     * Getting create view for UI
     * @param Request $request
     * @return mixed
     */
    public function actionGetCreateView( Request $request );

    /**
     * Handling create from
     * create Form
     * @param Request $request
     * @return mixed
     */
    public function actionCreate( Request $request );

}