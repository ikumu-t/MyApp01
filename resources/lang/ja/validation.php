<?php

return [
    'required' => ':attribute は必須です。',
    'string' => ':attribute は文字列である必要があります。',
    'max' => [
        'string' => ':attribute は最大 :max 文字までです。',
    ],
    'integer' => ':attribute は整数である必要があります。',
    'min' => [
        'numeric' => ':attribute は :min 以上である必要があります。',
    ],
    'max' => [
        'numeric' => ':attribute は :max 以下である必要があります。',
    ],
    'exists' => ':attribute は存在しません。',
    'attributes' => [
        'tags' => 'タグ',
        'comment' => 'コメント',
        'score' => 'スコア',
        'movie_id' => '映画ID',
    ],
];
