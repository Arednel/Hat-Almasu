<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use VoyagerBread\Traits\BreadSeeder;

class SupportTicketsBreadSeeder extends Seeder
{
    use BreadSeeder;

    public function bread()
    {
        return [
            // usually the name of the table
            'name'                  => 'supporttickets',
            'slug'                  => 'supporttickets',
            'display_name_singular' => 'Заявки',
            'display_name_plural'   => 'Заявки',
            'icon'                  => 'voyager-categories',
            'model_name'            => 'App\Models\SupportTicket',
            'controller'            => null,
            'generate_permissions'  => 1,
            'description'           => null,
            'details'               => [
                "order_column" => "supportTicketStatus",
                "order_display_column" => null,
                "order_direction" => "asc",
                "default_search_key" => null
            ]
        ];
    }

    public function inputFields()
    {
        return [
            'id' => [
                'type'         => 'number',
                'display_name' => 'ID',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 1,
            ],
            'fullName' => [
                'type'         => 'text',
                'display_name' => 'ФИО',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 2,
            ],
            'testType' => [
                'type'         => 'select_dropdown',
                'display_name' => 'Вид теста',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      =>
                [
                    'options' => [
                        'РК1' => 'РК1',
                        'РК2' => 'РК2',
                        'Экзамен' => 'Экзамен',
                    ],
                ],
                'order'        => 3,
            ],
            'course' => [
                'type'         => 'number',
                'display_name' => 'Курс',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 4,
            ],
            'department' => [
                'type'         => 'select_dropdown',
                'display_name' => 'Отделение',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      =>
                [
                    'options' => [
                        'Каз.' => 'Каз.',
                        'Рус.' => 'Рус.',
                        'Анг.' => 'Анг.',
                    ],
                ],
                'order'        => 5,
            ],
            'subject' => [
                'type'         => 'text',
                'display_name' => 'Дисциплина',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 6,
            ],
            'email' => [
                'type'         => 'text',
                'display_name' => 'Почта',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 7,
            ],
            'phoneNumber' => [
                'type'         => 'text',
                'display_name' => 'Телефон',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 8,
            ],
            'extraTextInfo' => [
                'type'         => 'text',
                'display_name' => 'Дополнительная информация',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 9,
            ],
            'reason' => [
                'type'         => 'text',
                'display_name' => 'Причина',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 10,
            ],
            'confirmationImages' => [
                'type'         => 'multiple_images',
                'display_name' => 'Файл подтверждения',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '',
                'order'        => 11,
            ],
            'supportTicketStatus' => [
                'type'         => 'select_dropdown',
                'display_name' => 'Статус заявки',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      =>
                [
                    'options' => [
                        'На рассмотрении' => 'На рассмотрении',
                        'Одобрена' => 'Одобрена',
                        'Отклонена' => 'Отклонена',
                    ],
                ],
                'order'        => 12,
            ],
            'created_at' => [
                'type'         => 'timestamp',
                'display_name' => 'Создана',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 13,
            ],
            'updated_at' => [
                'type'         => 'timestamp',
                'display_name' => 'Изменена',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 14,
            ],
        ];
    }

    public function menuEntry()
    {
        return [
            'role'        => 'admin',
            'title'       => 'Заявки',
            'url'         => '',
            'route'       => 'voyager.supporttickets.index',
            'target'      => '_self',
            'icon_class'  => 'voyager-categories',
            'color'       => null,
            'parent_id'   => null,
            'parameters' => null,
            'order'       => 6,
        ];
    }
}
