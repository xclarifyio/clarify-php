OP3Nvoice Audio Player
======================

This is a set of scripts to demonstrate using various pieces of the OP3Nvoice helper library.

This uses the PHP library available here: https://github.com/OP3Nvoice/op3nvoice-php

To use these examples,
*  rename creds-dist.php to creds.php and add your API Key;
*  load some audio or video files into your account using code similar to create.php or even using curl as found here: https://github.com/OP3Nvoice/op3nvoice-curl

This can be improved in a number of ways:

*  this only shows the first resulting file, we could extend it to show all of them;
*  if there are no search results, we could display a more useful/friendly message instead of no player.