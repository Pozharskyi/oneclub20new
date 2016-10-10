<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 18:06
 */

namespace App\Http\Controllers\Admin\Departments;

use Illuminate\Http\Request;

trait AdminDepartmentPhotographyFileHandlerTrait
{
    public function actionHandleFile(Request $request, $i)
    {
        $input = $request->file('file_' . $i);

        // SET UPLOAD PATH
        $destinationPath = 'images';

        // GET THE FILE EXTENSION
        $extension = $input->getClientOriginalExtension();

        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = date('Y-m-d') . 'V' . rand(1000, 9999) . '.' . $extension;

        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $input->move($destinationPath, $fileName);

        $file = '/' . $destinationPath . '/' . $fileName;

        return $file;
    }

}