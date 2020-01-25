<?php

return [
    'default-website-no-nav' => [
        'meta'  => [
            'name' => 'Default No-Nav',
        ],
        'items' => [
            [
                [
                    'alias'     => 'content-full',
                    'class'     => 'full-content',
                    'container' => 'first-row-content',
                    'width'     => 12
                ],
            ],
        ]
    ],
    'default-website' => [
        'meta'  => [
            'name' => 'Default',
        ],
        'items' => [
            [
                [
                    'alias'     => 'content-full',
                    'class'     => 'full-content',
                    'container' => 'first-row-content',
                    'width'     => 8
                ],
                [
                    'alias'     => 'content-sidebar',
                    'class'     => 'content-sidebar',
                    'container' => 'first-row-sidebar',
                    'width'     => 4
                ],
            ],
        ]
    ],
];
