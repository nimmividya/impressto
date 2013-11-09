# Cloud-Carousel

A simple wrapper for the Cloud Carousel, a 3d Carousel in JavaScript, by Professor Cloud. [http://www.professorcloud.com](http://www.professorcloud.com)

To see a demonstration, go to [http://appunto.net/demo/cloud-carousel/](http://appunto.net/demo/cloud-carousel/)

## Installing

### Get The Spark

For information on installing sparks, go here: [http://getsparks.org/install](http://getsparks.org/install)

If you have the Spark Manager installed, type:

```php tools/spark install cloud-carousel``` (Linux or OSX)

or

```php tools\spark install cloud-carousel``` (Windows)


### Copy Resources Directory
Copy the resources directory to your application directory so your application's
directory structure looks like this: 
```
   .
   |-application
   |-resources
     index.php
```

The files in the resources directory contain required JavaScript and CSS files.  If you put them somewhere else, 
make sure to update the cloud-carousel.php config file.

By default, this spark will look for your image files in the /resources/images directory.  Update the 
cloud-carousel.php config file with the actual location of your images.

## To Do

Currently, the controls and the alt and title boxes are not contained within the carousel div.  
I plan on adding an option that will allow the placement of these elements within the carousel div.
