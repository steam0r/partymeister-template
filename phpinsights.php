<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
    */

    'preset' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind, that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        //  'path/to/directory-or-file'
    ],


    'add' => [
        //  ExampleMetric::class => [
        //      ExampleInsight::class,
        //  ]
    ],

    'remove' => [
        PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class,
        PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\EndFileNewlineSniff::class,
        SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff::class,
        NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits::class,
        NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses::class,
        SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff::class,
                
    ],

    'config' => [
        //  ExampleInsight::class => [
        //      'key' => 'value',
        //  ],
    ],

];
