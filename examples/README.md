
This is a set of scripts to demonstrate using various pieces of the Clarify helper library.

This uses the PHP library available here: https://github.com/Clarify/clarify-php

To use these examples,
*  rename creds-dist.php to creds.php and add your API Key;
*  load some audio or video files into your account using code similar to create.php or even using curl as found here: https://github.com/Clarify/clarify-curl

Here is a complete explanation of everything in this package:

| Filename        | Description  |
| ------------- | --- |
| create.php | This sample allows you to create a new bundle with a single audio or video file. |
| creds-dist.php | This file should be renamed to creds.php and updated with your API key |
| delete.php | This deletes a single (the most recent) bundle from your accounts. |
| list.php | This lists the most recent 10 bundles from your account. |
| search.php | The demonstrates simple search functionality and displays the bundle id along with the time offsets from the search results. |
| update.php | This demonstrates how to update the information for a single bundle. |
| metadata-delete.php | This demonstrates how to delete metadata from one of your bundles. |
| metadata-load.php | This retrieves the metadata for a recent bundle. |
| metadata-update.php | This shows you how to update the metadata for a bundle. |
| tracks-create.php | This allows you to add a single track to an existing bundle. |
| tracks-delete.php | This deletes a single track from a bundle. |
| tracks-load.php | This loads all the information for a single track from a bundle. |
| tracks-update.php | This allows you to update information for a single track from a bundle. |
| audio-player.php | This is a sample audio player used to view a search result from the system. |
| css | These are styles for the sample audio and video players. You shouldn't have to do anything with it. |
| scripts | This is the Javascript for the sample audio and video players. You shouldn't have to do anything with it. |
| video-player.php | This is a sample video player used to view a search result from the system. |


This can be improved in a number of ways:

*  this only shows the first resulting file, we could extend it to show all of them;
*  if there are no search results, we could display a more useful/friendly message instead of no player.
