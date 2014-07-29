/*
 * Clarify video player
 *
 * Copyright (c) 2014 Clarify, Inc. All rights reserved.
 *
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Makes use of:
 *  jquery - GPL/MIT license
 *  jquery-ui - GPL/MIT license
 *  jplayer - GPL/MIT license
 *
 */

var o3vPlayer = (function() {

    /* WARNING: Due to flash security, running this from html as a local file
     (ie. file:// URL) will not allow the flash to run properly.
     This affects IE8 and Firefox which require Flash to play mp3.
     */

    /* Format the time displayed in the player. */
    $.jPlayer.convertTime = (function(seconds)
    {
        var d = Number(seconds);
        var ms = d % 3600;
        var h = Math.floor(d / 3600);
        var m = Math.floor(ms / 60);
        var s = Math.floor(ms % 60);
        return ((h > 0 ? h + ":" : "") + (m < 10 && h > 0 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s);
    });

    return {

        /* Set swfPath to set the path to the jplayer swf file.
         Relative paths are relative to the HTML file that includes
         this js file.
         Therefore you should probably use an absolute path,
         for example '/scripts/jquery'.
         This can be set from another file using:
         o3vPlayer.jPlayerOptions.swfPath = '/scripts/jquery';
         */
        jPlayerOptions: {
            swfPath: '/assets/scripts', // ex. '/scripts/jquery',
            solution: 'html,flash',
            supplied: 'm4v',
            preload: 'none', /* do the request only when play clicked*/
            volume: 0.9,
            muted: false,
            backgroundColor: '#000000',
            cssSelector: {
                videoPlay: '',
                play: '.o3v-jp-play',
                pause: '.o3v-jp-pause',
                stop: '.o3v-jp-stop',
                seekBar: '.o3v-jp-seek-bar',
                playBar: '.o3v-jp-play-bar',
                mute: '.o3v-jp-mute',
                unmute: '.o3v-jp-unmute',
                volumeBar: '.o3v-jp-volume-bar',
                volumeBarValue: '.o3v-jp-volume-bar-value',
                currentTime: '.o3v-jp-current-time',
                duration: '.o3v-jp-duration'
            },
            errorAlerts: true,
            warningAlerts: false
        },

        /* The html that makes up the player and controls.
         This is used if createPlayer is called on a container that
         does not contain a o3v-jplayer class. */
        playerHTML:  '<div class="o3v-jplayer"></div> \
                <div class="o3v-jp-audio-controls"> \
                <div class="o3v-jp-play-controls"> \
                <a href="#" class="o3v-jp-play" onclick="return false;"></a> \
                <a href="#" class="o3v-jp-pause" onclick="return false;"></a> \
               	<div class="o3v-jp-playbg"></div> \
            </div> \
                <a href="#" class="o3v-jp-mute" onclick="return false;"></a> \
                <div class="o3v-jp-current-time"></div> \
                <div class="o3v-slider-playback"></div> \
                <div class="o3v-jp-remaining"></div> \
                <div class="o3v-jp-volume"> \
                <div class="o3v-jp-volume-pop o3v-jp-volume-pop-down"> \
                <div class="o3v-slider-volume"></div> \
            </div> \
            </div> \
            </div>',

        /* Create an audio player. This can be called multiple times on a
         * page to create each player.
         *
         * Args:
         *
         * ancestorSelector is the selector for the outer div that contains
         *       the player and controls.
         *
         * mediaURL is an object with urls to the video (m4v) files.
         *   example: { m4v:"http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v"}
         *
         * audioDurSeconds (OPTIONAL) is the length in seconds of the
         *       recording. Since metadata is not retrieved (for efficiency),
         *       this duration is displayed as the duration until the file is
         *       downloaded and the actual duration is determined.
         *
         * extraOptions (OPTIONAL) is an object containing jPlayer
         * configuration options that will override the defaults.
         */
        createPlayer: function(ancestorSelector,mediaURLs,audioDurSeconds,extraOptions)
        {
            var fullPlayerSelector = ancestorSelector + " .o3v-jplayer";

            if ($(fullPlayerSelector).size() == 0) {
                $(ancestorSelector).append(this.playerHTML);
            } else {
                return undefined; // Player already created!
            }

            var jPlayerConfig = {
                cssSelectorAncestor: ancestorSelector,
                ready: function () {
                    var thisp = $(this);
                    thisp.jPlayer('setMedia',mediaURLs);
                    _setupVolumeControl();
                    thisp.bind(jQuery.jPlayer.event.seeking + ".progress",_onLoadingHandler);
                    thisp.bind(jQuery.jPlayer.event.seeked + ".progress",_onLoadedHandler);
                    thisp.bind(jQuery.jPlayer.event.loadstart + ".progress",_onLoadingHandler);
                    thisp.bind(jQuery.jPlayer.event.loadeddata + ".progress",_onLoadedHandler);
                    if (audioDurSeconds !== undefined) {
                        $(ancestorSelector + " div.o3v-jp-duration").text($.jPlayer.convertTime(Number(audioDurSeconds)));
                        $(ancestorSelector + " div.o3v-jp-remaining").text("-" + $.jPlayer.convertTime(Number(audioDurSeconds)));
                    }
                },
                play: function() { // To avoid both jPlayers playing together.
                    $(this).jPlayer("pauseOthers");
                },
                timeupdate: function(event) {
                    _updateRemaining(event);
                    if (!event.jPlayer.status.waitForPlay)  {
                        if ($(ancestorSelector + " div.o3v-slider-playback .ui-state-active").size() == 0) {
                            // event.jPlayer.status.currentPercentAbsolute is 0 with flash v 2.2.0
                            var curPerc = event.jPlayer.status.duration > 0 ? event.jPlayer.status.currentTime / event.jPlayer.status.duration * 100.0 : 0;
                            $(ancestorSelector + " div.o3v-slider-playback").slider('value',curPerc);
                        }
                    }
                    // With flash, we don't always get the loadeddata event.
                    if (event.jPlayer.flash.active && !event.jPlayer.status.waitForPlay) {
                        _onLoadedHandler(event);
                    }
                },
                ended: function(event) {
                    _updateRemaining(event);
                    $(ancestorSelector + " div.o3v-slider-playback").slider('value', 0);
                }
            };

            $.extend(jPlayerConfig,this.jPlayerOptions);

            // Generate supplied based on what we were passed
            var supplied = '';
            for (var key in mediaURLs) {
                if (mediaURLs.hasOwnProperty(key) && key !== 'poster' && key !== 'title' && key !== 'duration' &&
                    key !== 'track') {
                    if (supplied.length) supplied += ',';
                    supplied += key;
                }
            }
            jPlayerConfig.supplied = supplied;

            if (extraOptions) {
                $.extend(jPlayerConfig,extraOptions);
            }

            var player = $(fullPlayerSelector).jPlayer(jPlayerConfig);

            $(ancestorSelector + " a.o3v-jp-mute").click( function() {
                $(ancestorSelector + " div.o3v-slider-volume").slider({ disabled: true });
                return false;
            });
            $(ancestorSelector + " a.o3v-jp-unmute").click( function() {
                $(ancestorSelector + " div.o3v-slider-volume").slider({ disabled: false });
                return false;
            });

            $(ancestorSelector + " div.o3v-slider-playback").slider({
                value: 0,
                max: 100,
                step: 0.1,
                range: 'min',
                animate: 200,
                slide: function(event, ui) {
                    var player = $(fullPlayerSelector);
                    var lp = player.data("jPlayer").status.seekPercent;
                    player.jPlayer("playHead", (lp > 0) ? ui.value*(100.0/lp) : ui.value);
                }
            });

            function _updateRemaining(event)
            {
                if (event.jPlayer.status.duration)
                {
                    var remSec = event.jPlayer.status.duration - event.jPlayer.status.currentTime;
                    if (event.jPlayer.status.currentTime > 0)
                    {
                        remSec = Math.ceil(remSec);
                    }
                    $(ancestorSelector + " div.o3v-jp-remaining").text("-" + $.jPlayer.convertTime(remSec));
                }
            }

            function _onLoadingHandler(event)
            {
                if (!event.jPlayer.status.waitForLoad)
                {
                    $(ancestorSelector + " div.o3v-jp-playbg").addClass("o3v-jp-loading");
                }
            }

            function _onLoadedHandler(event)
            {
                $(ancestorSelector + " div.o3v-jp-playbg").removeClass("o3v-jp-loading");
            }

            function _setupVolumeControl()
            {
                /* If mute button is hidden, this device does not support
                 volume control so we don't create the volume slider. */
                if ($(ancestorSelector + " a.o3v-jp-mute").is(':visible')) {
                    $(ancestorSelector + " a.o3v-jp-mute").remove();

                    var curVol=$(fullPlayerSelector).jPlayer("option").volume;
                    $(ancestorSelector + " div.o3v-slider-volume").slider({
                        value : curVol*100.0,
                        max: 100,
                        range: 'min',
                        orientation: 'vertical',
                        animate: true,
                        slide: function(event, ui) {
                            $(fullPlayerSelector).jPlayer("volume", ui.value/100.0);
                            var quadVol = Math.ceil(ui.value/34.0);
                            $(event.target).closest(".o3v-jp-volume").removeClass("v0 v1 v2 v3").addClass("v" + quadVol);
                        }
                    });
                } else {
                    $(ancestorSelector + " div.o3v-jp-volume").removeClass("o3v-jp-volume").addClass("o3v-jp-right-cap");
                }
            }
            return player;
        },

        addItemResultMarkers: function(player,audioDurSeconds,itemResult,searchTerms) {
            if (player && itemResult && itemResult.term_results) {
                // Insert the overlay over the slider so mouse events are
                // bubbled properly
                var parent = player.parent();
                parent.find(".o3v-slider-playback .ui-slider-handle").before('<div class="o3v-scrubber-search-overlay"></div>');
                var overlay = parent.find("div.o3v-scrubber-search-overlay");
                $.each(itemResult.term_results,function(index,val) {
                    $.each(val.matches,function(mindex,match) {
                        if (match.type === 'audio') {
                            $.each(match.hits,function(hindex,hit,hitlist) {
                                overlay.append('<div class="o3v-scrubber-search-mark o3v-search-color-' + (index % 10) + '" style="margin-left:'+ (hit.start/audioDurSeconds)*100.0 + '%;"><a href="#" title="'+ (searchTerms?searchTerms[index].term+' ':'') + $.jPlayer.convertTime(hit.start) + '"></a></div>');
                            });
                        }
                    });
                });
            }
        }

    }; // end of return statement

})();


