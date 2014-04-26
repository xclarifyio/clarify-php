OP3Nvoice Audio Player
======================

This is a proof of concept audio player that integrates with the OP3Nvoice search library.

This uses the PHP library available here: https://github.com/OP3Nvoice/op3nvoice-php

To use this:
*  load some audio files into your account using code similar to audio-create.php or even using curl;
*  rename creds-dist.php to creds.php and add your API Key;

This can be improved in a number of ways:

*  this only shows the first resulting file, we could extend it to show all of them;
*  the duration should be included in the API call so we don't have to hardcode it here (line 57);
*  if there are no search results, we could display a more useful/friendly message instead of no player.