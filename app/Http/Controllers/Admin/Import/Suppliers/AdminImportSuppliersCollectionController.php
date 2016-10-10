<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 09.10.2016
 * Time: 13:36
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminImportSuppliersCollectionController extends Controller
{
    public static function actionHandleRequest(Request $request)
    {
        $creationFields = array(
            'name', 'shop', 'contact_person', 'brands', 'phones', 'email',
            'coefficient', 'product_marga', 'time_of_returns',
            'work_status', 'work_comment', 'agreement', 'start_working',
            'payment_form', 'payment_postpone', 'ecommerce_comment',
            'address_sending', 'logistic_comment', 'address_return',
            'products_category', 'buyer_id',
        );

        $fields = array();

        foreach ($creationFields as $creationField) {
            $field = $request->input($creationField);

            $fields[$creationField] = $field;
        }

        return $fields;
    }

    public static function actionGetAllocationsForSuppliers()
    {
        $allocation = array(
            'name' => 'Поставщик, компания',
            'shop' => 'Магазин',
            'contact_person' => 'Контактное лицо',
            'brands' => 'Бренды',
            'phones' => 'Телефоны',
            'email' => 'E-mail',
            'coefficient' => 'Плановая наценка, коэффициент',
            'product_marga' => 'Плановая маржа, %',
            'time_of_returns' => 'Срок возвратов',
            'work_status' => 'Статус',
            'work_comment' => 'комментарий к статусу в процессе переговоров, с датой статуса',
            'agreement' => 'Наличие договора',
            'start_working' => 'Дата старта сотрудничества',
            'payment_form' => 'Форма расчета',
            'payment_postpone' => 'Отстрочка платежа, в днях',
            'ecommerce_comment' => 'Комментарии по коммерческой части',
            'address_sending' => 'Адрес забора и отправки образцов',
            'logistic_comment' => 'Комментарий для логистики',
            'address_return' => 'Адрес забора заказов и отправки возвратов',
            'products_category' => 'Товарная категория',
            'buyer_id' => 'Отвественный байер',
        );

        return $allocation;
    }

}