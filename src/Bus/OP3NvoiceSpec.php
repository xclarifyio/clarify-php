<?php

namespace OP3Nvoice\Bus;

class OP3NvoiceSpec
{
    public static function getDescription($apiBaseUrl)
    {
        return [
            'baseUrl' => $apiBaseUrl,
            'operations' => [
                'getBundles' => [
                    'httpMethod' => 'GET',
                    'description' => 'Gets the list of bundles. Links to each item are in the _links with link relation items.',
                    'uri' => 'bundles',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'limit' => [
                            'description' => 'limit results to specified number of bundles. Default is 10. Max 100.',
                            'type' => 'integer',
                            'location' => 'query',
                            'required' => false,
                        ],
                        'embed' => [
                            'description' => 'list of link relations to embed in the result collection. Zero or more of: items, tracks, metadata. List is space or comma separated single string or an array of strings',
                            'type' => 'string',
                            'location' => 'query',
                            'required' => false,
                        ],
                        'iterator' => [
                            'description' => 'opaque value, automatically provided in next/prev links',
                            'type' => 'string',
                            'location' => 'query',
                            'required' => false,
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
