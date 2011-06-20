(function($) {
  
  $('#dm_page div.dm_widget.content_nivo_gallery').live('dmWidgetLaunch', function()
  {
    var $gallerycontainer = $(this).find('div#dm_widget_nivo_gallery_container');
    var $gallery = $($gallerycontainer).find('div#dm_widget_nivo_gallery');

    // only if elements in gallery
    if(!$gallery.find('>img').length)
    {
      return;
    }

    // get options from gallery metadata
    var options = $gallery.metadata();
    
    $gallery.css({ "width": options.width, "height": options.height});
    $gallerycontainer.css({ "width": options.width, "height": parseInt(options.height) + 40});

    $gallery.nivoSlider({
        effect:     options.fx,                    
        animSpeed:  options.animspeed * 1000,
        pauseTime:  options.pausetime * 1000
      });
    
    var $navcontrol = $gallery.find('.nivo-controlNav');
    var awidth = $navcontrol.width();
    var mediacount = options.count;
    var leftplacement = options.width/2 - awidth/2;
    $navcontrol.css("left", leftplacement);
  });

})(jQuery);