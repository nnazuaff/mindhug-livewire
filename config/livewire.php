<?php

return [
    'component_locations' => [
        resource_path('views/components'),
        resource_path('views/livewire'),
    ],

    'component_namespaces' => [
        'layouts' => resource_path('views/layouts'),
        'pages' => resource_path('views/pages'),
    ],

    'component_layout' => 'layouts::app',

    'component_placeholder' => null,

    'make_command' => [
        'type' => 'class',
        'emoji' => false,
    ],

    'class_namespace' => 'App\\Http\\Livewire',

    'class_path' => app_path('Http/Livewire'),

    'view_path' => resource_path('views/livewire'),
];
