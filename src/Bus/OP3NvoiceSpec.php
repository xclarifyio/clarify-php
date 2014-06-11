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
                'createBundle' => [
                    'httpMethod' => 'POST',
                    'description' => 'Create a new bundle with the specified name, media url, and optional JSON metadata.',
                    'uri' => 'bundles',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'name' => [
                            'description' => 'Name of the bundle. Up to 128 characters.',
                            'type' => 'string',
                            'location' => 'form',
                            'required' => false,
                        ],
                        'media_url' => [
                            'description' => 'URL of a media (audio or video) file for this bundle. Up to 256 characters.',
                            'type' => 'string',
                            'location' => 'form',
                            'required' => false,
                        ],
                        'audio_channel' => [
                            'description' => 'The audio channel to use for the track ( "" | left | right | split ). Default is empty string which means all channels of audio in the media file are used for the track.',
                            'type' => 'string',
                            'location' => 'form',
                            'required' => false,
                        ],
                        'metadata' => [
                            'description' => 'User-defined JSON data associated with the bundle. Must be valid JSON, up to 4000 characters.',
                            'type' => 'string',
                            'location' => 'form',
                            'required' => false,
                        ],
                        'notify_url' => [
                            'description' => 'URL for notifications on this bundle. Up to 256 characters.',
                            'type' => 'string',
                            'location' => 'form',
                            'required' => false,
                        ]
                    ]
                ],
                'deleteBundle' => [
                    'httpMethod' => 'DELETE',
                    'description' => 'Delete a bundle and its related metadata and tracks. This will only delete media stored on OP3Nvoice systems and not delete the source media on remote systems.',
                    'uri' => 'bundles/{bundle_id}',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'bundle_id' => [
                            'description' => 'id of a bundle',
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true,
                        ]
                    ]
                ],
                'getBundle' => [
                    'httpMethod' => 'GET',
                    'description' => 'Get a bundle that has previously been created.',
                    'uri' => 'bundles/{bundle_id}',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'bundle_id' => [
                            'description' => 'id of a bundle',
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true,
                        ],
                        'embed' => [
                            'description' => 'list of link relations to embed in the result bundle. Zero or more of: tracks, metadata. List is space or comma separated single string or an array of strings',
                            'type' => 'string',
                            'location' => 'query',
                            'required' => false,
                        ]
                    ]
                ],
                'updateBundle' => [
                    'httpMethod' => 'PUT',
                    'description' => 'Update a bundle. Note that this call will not update the media or metadata.',
                    'uri' => 'bundles/{bundle_id}',
                    'responseModel' => 'getResponse',
                    'parameters' => [
                        'bundle_id' => [
                            'description' => 'id of a bundle',
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true,
                        ],
                        'embed' => [
                            'description' => 'list of link relations to embed in the result bundle. Zero or more of: tracks, metadata. List is space or comma separated single string or an array of strings',
                            'type' => 'string',
                            'location' => 'query',
                            'required' => false,
                        ]
                    ]
                ]
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
