dmWidgetNivoGalleryPlugin packages a Diem front widget for displaying image galleries based on the [Nivo Slider](http://nivo.dev7studios.com/) jQuery Plugin.
dmWidgetNivoGalleryPlugin is partly based on [dmWdigetGalleryPlugin](http://diem-project.org/plugins/dmwidgetgalleryplugin) by Thibault Duplessis.

Add a gallery on the site
-------------
Just click the add button in the front toolbar and drag a Nivo Gallery into the site.
*Important*:Click the refresh button after adding the gallery for the first time. Otherwise it doesn't load the custom css and js properly, and you'll be stuck with an ugly looking gallery :)

Manage gallery images
-------------
### Medias tab

Open the MEDIA right panel, then drag&drop images into gallery dialog.
You can set an alt attribute to each image.
To add a link to an image, you can :

* drag&drop a link to the field from the left PAGES panel
* write a full url to another site

### Thumbnails tab
Contrary to it's inspiration, [dmWdigetGalleryPlugin](http://diem-project.org/plugins/dmwidgetgalleryplugin), here you are required to add width and height, because of the internal workings of Nivo Gallery in combination with Diem.
JPEG Quality works just like all other media in Diem.

###Effects tab
####Effect
Pick a transition effect here. Choose random to make the transition different each time, it's my favorite setting personally. For a demonstration of all effects, have a look at [the Nivo Slider homepage](http://nivo.dev7studios.com/)
####Animation Speed
This determines the speed at which the transitions play out. Time is in seconds.
####Pauze Time
Here you can set how long the gallery must wait before playing the next transition.

###Advanced
Set a custom css class here