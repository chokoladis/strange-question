<?php

return [
    'questions' => [
        'fields' => [
            'category' => 'Раздел',
            'title' => 'Заголовок',
            'img' => 'Прикрепляемая картинка',
        ]
    ],
    'categories' => [
        'fields' => [
            'category_parent_id' => 'Родительский раздел',
            'title' => 'Заголовок',
            'sort' => 'Сортировка',
            'img' => 'Прикрепляемая картинка',
        ]
    ],
    'comments' => [
        'fields' => [
            'text' => 'Коммент',
        ]
    ],
];

?>