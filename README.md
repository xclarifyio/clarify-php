[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/OP3Nvoice/op3nvoice-php/badges/quality-score.png?s=461ba0663e453941a097d9b8049ba865c4512617)](https://scrutinizer-ci.com/g/OP3Nvoice/op3nvoice-php/)

PHP Helper Library for Op3nVoice
=============

### Installing via Composer

The recommended way to install the OP3Nvoice library is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add OP3Nvoice as a dependency
php composer.phar require op3nvoice/op3nvoice-helper dev-master
```

or alternatively, you can add it directly to your `composer.json` file.

```json
{
  "require": {
    "op3nvoice/op3nvoice-helper": "dev-master"
  }
}
```

After installing, you need to require Composer's autoloader in your PHP script:

```php
require 'vendor/autoload.php';
```

### Usage

To begin using this library, initialize the OP3Nvoice object with your API key:

```php
$audio = new OP3Nvoice\Audio($apikey);
```

Then add an audio or video file to your search index:

```php
$audio->create('http://example.com/', "My awesome audio file");
```

Within minutes your file will be added to your index and available via a simple search:

```php
$audio = new OP3Nvoice\Audio($apikey);
$result = $audio->search('close');
$results = $result['item_results'];
```

#### Todo List

* ~~Include Guzzle via Composer~~
* ~~Authentication~~
* Audio
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
* Video
  * create a bundle
  * list all bundles
  * load a specific bundle
  * delete a bundle
  * update a bundle
  * get metadata
  * update metadata
  * delete metadata
  * add a track
  * update a track
  * get track information
  * delete a track
* ~~Search~~

### Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
