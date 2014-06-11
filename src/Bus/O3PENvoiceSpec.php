<?php

namespace OP3Nvoice\Bus;

class OP3NvoiceSpec
{
    public static function getDescription($apiBaseUrl)
    {
        return [
            'baseUrl' => $apiBaseUrl,
            'operations' => [
                'read' => [
                    'httpMethod' => 'GET',
                    'description' => 'Gets a bundle',
                    'uri' => 'dsa/ds',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'yey' => [
                            'description' => 'x',
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true,
                        ]
                    ]
                ],
            ],
            'models' => [
                'getResponse' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ]
            ]
        ];
    }
}
