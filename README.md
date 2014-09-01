[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Clarify/clarify-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Clarify/clarify-php/?branch=master)

PHP Helper Library for Clarify
================================

### Installing via Composer

The recommended way to install the Clarify library is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Clarify as a dependency
php composer.phar require clarify/clarify-helper dev-master@dev
```

or alternatively, you can add it directly to your `composer.json` file.

```json
{
    "require": {
        "clarify/clarify-helper": "dev-master@dev"
    }
}
```

Then install the libraries via Composer:

```bash
composer install
```

Finally, require Composer's autoloader in your PHP script:

```php
require __DIR__.'/vendor/autoload.php';
```

### Usage

To begin using this library, initialize the Clarify object with your API key:

```php
$bundle = new \Clarify\Bundle($apikey);
```

Then add an audio or video file to your search index:

```php
$bundle->create('http://example.com/', "My awesome audio file");
```

Within minutes your file will be added to your index and available via a simple search:

```php
$bundle = new \Clarify\Bundle($apikey);
$result = $bundle->search('close');
$results = $result['item_results'];
```

## Quickstart Guide

### Getting Started

This quickstart demonstrates a simple way to get started using the Clarify API. Following these steps, it should take you no more than 5-10 minutes to have a fully functional search for your audio.

### Creating the object

While you can use any programming language you choose, we provide helper libraries in a couple to get you started. In PHP, you simply include the library and create a new \Clarify\Audio object using your API Key:

```php
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle('my-api-key');
```

### Loading Audio

Once you've created the object, you can use the object to load each one of your audio files as shown:

```php
$result = $bundle->create("optional bundle name", 'http://example.com/sample-audio-file.wav');
```

Here are some audio files you can use for testing:

```bash
http://media.clarify.io/audio/samples/harvard-sentences-1.wav

http://media.clarify.io/audio/samples/harvard-sentences-2.wav

http://media.clarify.io/audio/books/dorothyandthewizardinoz_01_baum_64kb.mp3
```

Hint: You don't have to download these files. Instead you can pass us these urls via the create method shown above.

### Searching Audio

To search, you use the same \Clarify\Bundle object and search using your keywords. This can be accomplished in a single line of code:

```php
$result = $bundle->search('my-keyword');
```

Then you can process and interact the results however you wish. The code below simply shows the resulting bundle id, bundle name, and the start/end offsets for each occurrence of the search terms.

```php
$results = $result['item_results'];
$items = $result['_links']['items'];
foreach ($items as $index => $item) {
    $_bundle = $audio->load($item['href']);

    echo $_bundle['_links']['self']['href'] . "\n";
    echo $_bundle['name'] . "\n";

    $search_hits = $results[$index]['term_results'][0]['matches'][0]['hits'];
    foreach ($search_hits as $search_hit) {
        echo $search_hit['start'] . ' -- ' . $search_hit['end'] . "\n";
    }
}
```

And here are the results using the first audio file above with "close" as the search term:

```bash
/v1/audio/8ee0e56929c248ba895d19ead47c9993
name453
16.34 -- 16.69
17.36 -- 17.71
18.71 -- 19.04
19.67 -- 20.03
```

### Putting it All Together

From here, we can visualize our search results with our [audio player](https://github.com/Clarify/clarify-audio-player)
or our [video player](https://github.com/Clarify/clarify-video-player) for video. The player should work with no
additional configuration but the bulk of the logic is here:

```php
$bundle = new \Clarify\Bundle($apikey);
$items = $bundle->search($terms);

$search_terms = json_encode($items['search_terms']);
$item_results = json_encode($items['item_results']);

$bundlekey = $items['_links']['items'][0]['href'];
$tracks = $bundle->tracks($bundlekey)['tracks'];
$mediaUrl = $tracks[0]['media_url'];
```

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request from github
