<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 17.08.2016
 * Time: 15:17
 */

namespace App\Http\Controllers\Delivery\Novaposhta;

use App\Http\Controllers\Controller;

class NPInternetDocumentController extends Controller
{
    public function actionGetInternetDocument()
    {
        $np = NPConfigController::getInstance();

        // Перед генерированием ЭН необходимо получить данные отправителя
        // Получение всех отправителей
        $senderInfo = $np->getCounterparties('Sender', 1, '', '');
        // Выбор отправителя в конкретном городе (в данном случае - в первом попавшемся)

        $sender = $senderInfo['data'][0];
        // Информация о складе отправителя

        $senderWarehouses = $np->getWarehouses($sender['City']);
        // Генерирование новой накладной

        $result = $np->newInternetDocument(
        // Данные отправителя
            array(
                // Данные пользователя
                'FirstName' => 'Любовь', //$sender['FirstName'],
                'MiddleName' => 'Владимировна', //$sender['MiddleName'],
                'LastName' => 'Чупахина', //$sender['LastName'],
                // Вместо FirstName, MiddleName, LastName можно ввести зарегистрированные ФИО отправителя или название фирмы для юрлиц
                // (можно получить, вызвав метод getCounterparties('Sender', 1, '', ''))
                // 'Description' => $sender['Description'],
                // Необязательное поле, в случае отсутствия будет использоваться из данных контакта
                // 'Phone' => '0631112233',
                // Город отправления
                // 'City' => 'Белгород-Днестровский',
                // Область отправления
                // 'Region' => 'Одесская',
                'CitySender' => $sender['City'],
                // Отделение отправления по ID (в данном случае - в первом попавшемся)
                'SenderAddress' => $senderWarehouses['data'][0]['Ref'],
                // Отделение отправления по адресу
                // 'Warehouse' => $senderWarehouses['data'][0]['DescriptionRu'],
            ),
            // Данные получателя
            array(
                'FirstName' => 'Сидор',
                'MiddleName' => 'Сидорович',
                'LastName' => 'Сиродов',
                'Phone' => '0509998877',
                'City' => 'Киев',
                'Region' => 'Киевская',
                'Warehouse' => 'Отделение №3: ул. Калачевская, 13 (Старая Дарница)',
            ),
            array(
                // Дата отправления
                'DateTime' => date('d.m.Y'),
                // Тип доставки, дополнительно - getServiceTypes()
                'ServiceType' => 'WarehouseWarehouse',
                // Тип оплаты, дополнительно - getPaymentForms()
                'PaymentMethod' => 'Cash',
                // Кто оплачивает за доставку
                'PayerType' => 'Recipient',
                // Стоимость груза в грн
                'Cost' => '500',
                // Кол-во мест
                'SeatsAmount' => '1',
                // Описание груза
                'Description' => 'Кастрюля',
                // Тип доставки, дополнительно - getCargoTypes
                'CargoType' => 'Cargo',
                // Вес груза
                'Weight' => '10',
                // Объем груза в куб.м.
                'VolumeGeneral' => '0.5',
                // Обратная доставка
                'BackwardDeliveryData' => array(
                    array(
                        // Кто оплачивает обратную доставку
                        'PayerType' => 'Recipient',
                        // Тип доставки
                        'CargoType' => 'Money',
                        // Значение обратной доставки
                        'RedeliveryString' => 4552,
                    )
                )
            )
        );

        var_dump( $result );
    }

}