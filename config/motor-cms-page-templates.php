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
    'default-three-col' => [
        'meta'  => [
            'name' => 'Default 3 columns',
        ],
        'items' => [
            [
                [
                    'alias'     => 'content-left',
                    'class'     => 'content-left',
                    'container' => 'first-row-left',
                    'width'     => 3
                ],
                [
                    'alias'     => 'content-center',
                    'class'     => 'content-center',
                    'container' => 'first-row-center',
                    'width'     => 6
                ],
                [
                    'alias'     => 'content-right',
                    'class'     => 'content-right',
                    'container' => 'first-row-right',
                    'width'     => 3
                ],
            ],
        ]
    ],
];
