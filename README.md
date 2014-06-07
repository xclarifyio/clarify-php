[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/OP3Nvoice/op3nvoice-php/badges/quality-score.png?s=461ba0663e453941a097d9b8049ba865c4512617)](https://scrutinizer-ci.com/g/OP3Nvoice/op3nvoice-php/)

PHP Helper Library for OP3Nvoice
================================

### Installing via Composer

The recommended way to install the OP3Nvoice library is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add OP3Nvoice as a dependency
php composer.phar require op3nvoice/op3nvoice-helper dev-master@dev
```

or alternatively, you can add it directly to your `composer.json` file.

```json
{
    "require": {
        "op3nvoice/op3nvoice-helper": "dev-master@dev"
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

To begin using this library, initialize the OP3Nvoice object with your API key:

```php
$audio = new \OP3Nvoice\Bundle($apikey);
```

Then add an audio or video file to your search index:

```php
$audio->create('http://example.com/', "My awesome audio file");
```

Within minutes your file will be added to your index and available via a simple search:

```php
$audio = new \OP3Nvoice\Bundle($apikey);
$result = $audio->search('close');
$results = $result['item_results'];
```

## Quickstart Guide

### Getting Started
This quickstart demonstrates a simple way to get started using the OP3Nvoice API. Following these steps, it should take you no more than 5-10 minutes to have a fully functional search for your audio.

### Creating the object

While you can use any programming language you choose, we provide helper libraries in a couple to get you started. In PHP, you simply include the library and create a new \OP3Nvoice\Audio object using your API Key:

```php
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle('my-api-key');
```

### Loading Audio

Once you've created the object, you can use the object to load each one of your audio files as shown:

```php
$result = $audio->create('http://example.com/sample-audio-file.wav', "optional bundle name");
```

Here are some audio files you can use for testing:

```bash
https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav

https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-2.wav

https://s3-us-west-2.amazonaws.com/op3nvoice/dorothyandthewizardinoz_01_baum_64kb.mp3
```

Hint: You don't have to download these files. Instead you can pass us these urls via the create method shown above.

### Searching Audio

To search, you use the same \OP3Nvoice\Audio object and search using your keywords. This can be accomplished in a single line of code:

```php
$result = $audio->search('my-keyword');
```

Then you can process and interact the results however you wish. The code below simply shows the resulting bundle id, bundle name, and the start/end offsets for each occurrence of the search terms.

```php
$results = $result['item_results'];
$items = $result['_links']['items'];
foreach ($items as $index => $item) {
    $bundle = $audio->load($item['href']);

    echo $bundle['_links']['self']['href'] . "\n";
    echo $bundle['name'] . "\n";

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

From here, we can visualize our search results with our [audio player](https://github.com/OP3Nvoice/op3nvoice-audio-player)
or our [video player](https://github.com/OP3Nvoice/op3nvoice-video-player) for video. The player should work with no
additional configuration but the bulk of the logic is here:

```php
$audio = new \OP3Nvoice\Bundle($apikey);
$items = $audio->search($terms);

$search_terms = json_encode($items['search_terms']);
$item_results = json_encode($items['item_results']);

$audiokey = $items['_links']['items'][0]['href'];
$tracks = $audio->tracks($audiokey)['tracks'];
$mediaUrl = $tracks[0]['media_url'];
```

## Todo List

* ~~Include Guzzle via Composer~~
* ~~Authentication~~
* Bundle
  * ~~create a bundle~~
  * ~~list all bundles~~
  * ~~load a specific bundle~~
  * ~~delete a bundle~~
  * ~~update a bundle~~
  * ~~get metadata~~
  * ~~update metadata~~
  * ~~delete metadata~~
  * ~~add a track~~
  * ~~update a track~~
  * ~~get track information~~
  * ~~delete a track~~
* ~~Refactor the existing Audio/Video classes to a single Bundle resource~~
* ~~Search~~

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request from github
