<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => [
            'encoding'         => 'utf-8',
            'page-size'        => 'A4',
            'margin-top'       => 0,
            'margin-left'      => 0,
            'margin-right'     => 0,
            'margin-bottom'    => 20,
            'footer-spacing'   => 0,
            'footer-font-size' => 8,
            'footer-html'      => resource_path('views/components/attestation/footer.html'),
        ],
        'env' => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
