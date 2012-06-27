<?php
/**
 * Stab for app://sandbox/posts
 */
return [
    'sandbox\Resource\App\Posts' =>
        [
            [
                'id' => 0,
                'title' => 'Alan Kay 1',
                'body' => 'People who are really serious about software should make their own hardware.',
                'created' => '2011-05-07 16:13:11'
            ],
            [
                'id' => 1,
                'title' => 'Alan Kay 2',
                'body' => 'Perspective is worth 80 IQ points.',
                'created' => '2011-05-07 16:13:22'
            ],
            [
                'id' => 2,
                'title' => 'Alan Kay 3',
                'body' => 'The best way to predict the future is to invent it.',
                'created' => '2011-05-07 16:13:33'
            ]
         ],
    'sandbox\Resource\Page\Blog\Posts\Post' =>
            [
                'post' => [
                    'title' => 'PHP とはなんでしょう?',
                    'body' => 'PHP (PHP: Hypertext Preprocessor を再帰的に略したものです) は、広く使われているオープンソースの汎用スクリプト言語です。 PHP は、特に Web 開発に適しており、HTML に埋め込むことができます。で、結局のところどういう意味なのでしょう? 以下に例を示します。',
                    'created' => '2011-05-11 08:08:01'
                 ]
            ],

    'sandbox\Resource\Page\Blog\Posts\Edit' =>
            [
                'id' => '1',
                'submit' => [
                    'title' => 'default title',
                    'body' => 'default body',
                    'created' => '2011-05-11 08:08:01'
                 ]
            ],
];
