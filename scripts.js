// Generated by CoffeeScript 2.5.1
(function() {
  var embedSoundcloud, embedYouTubeVideo, setupBarcode;

  embedYouTubeVideo = function(url) {
    var match, regExp, youTubeId;
    regExp = /(?:youtube(?:-nocookie)?\.com\/(?:(?:v|e(?:mbed)?)\/|\S*?[?&]v=|watch\/|)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    match = url.match(regExp);
    if (match && match[1].length === 11) {
      youTubeId = match[1];
    } else {
      return;
    }
    jQuery('#videoembed').html('<div class="youtubepopup"><a class="closex">x</a><iframe width="560" height="315" src="//www.youtube.com/embed/' + youTubeId + '" frameborder="0" allowfullscreen></iframe></div>');
    return jQuery('a.closex').on("click", function() {
      return jQuery('.youtubepopup').remove();
    });
  };

  embedSoundcloud = function(url) {
    var settings;
    settings = {
      "async": true,
      "crossDomain": true,
      "url": "http://soundcloud.com/oembed",
      "method": "POST",
      "headers": {},
      "data": {
        "format": "json",
        "url": url,
        "auto_play": true
      }
    };
    return jQuery.ajax(settings).done(function(response) {
      var oembed_html;
      oembed_html = response.html;
      return jQuery("#videoembed").html(oembed_html);
    });
  };

  setupBarcode = function() {
    var barcode;
    barcode = jQuery("#upc .u-identifier").text();
    JsBarcode("#upc .u-identifier", barcode, {
      height: 30,
      fontSize: 14,
      format: "EAN13"
    });
    return jQuery(".u-identifier").text = "";
  };

  jQuery(function() {
    var $cover, $info, $serviceLinks;
    $serviceLinks = jQuery("#service-links");
    $cover = jQuery("#cover");
    $info = jQuery("#info");
    setupBarcode();
    // jQuery("#youtube .watch").on "click", (e) ->
    //   youtube_url = e.target.parentElement.href
    //   embedYouTubeVideo(youtube_url)
    // jQuery("#soundcloud .play").on "click", (e) ->
    //   soundcloud_url = e.target.parentElement.href
    //   embedSoundcloud(soundcloud_url)
    return jQuery(window).scroll(function() {
      var newHeight, wScroll;
      wScroll = jQuery(this).scrollTop();
      newHeight = 320 - wScroll;
      if (newHeight >= 0) {
        $cover.css({
          height: newHeight + 'px'
        });
        return $serviceLinks.css({
          paddingTop: (newHeight + $info.height) + 'px'
        });
      }
    });
  });

}).call(this);
