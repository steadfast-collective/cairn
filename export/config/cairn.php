<?php

return [
    'commands' => [
        'makeBlock' => [
            // path for CMS icons
            'icon_path' => 'vendor/statamic/cms/resources/svg/icons/plump',

            // Default fields to apply to blocks
            'default_fields' => [
                [
                    'handle' => 'anchor_id',
                    'field' =>  'common.anchor_id'
                ],
                // [
                //     'handle' => 'example_text_field',
                //     'field' => [
                //         'type' => 'text',
                //         'display' => 'Example Text Field'
                //     ]
                // ]
            ],
            // Handle for Page Builder Fieldset
            'page_builder_fieldset_handle' => 'page_builder',

            // Handle for page builder field, within page builder fieldset
            'page_builder_field_handle' => 'page_builder',
        ]
    ]
];
