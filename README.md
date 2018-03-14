# Personal CV

My personal curriculum vitae (minus some of my contact details, to avoid spam).

## Templating system
I use [Mustache](http://mustache.github.io/) because is a logic-less templating system, easy to implement with any server side language (php in my case).  
The data to populate the cv is the `data.json` file.

## HTML version
I've used HTML5 Boilerplate as the base template, Selectivizr for old IEs CSS3 support and hCard microformat for a little bit of semantic.  
The design is completely responsive.  
Plus there's a little trick if you go with the mouse over my name.

The HTML template is in the `cv-template.html` file, while the compiled version is created by accessing `cv-controller.php`.

Tested on:

- Android Browser
- Chrome for desktop
- Chrome for Android
- Dolphin Browser for Android
- Firefox 3+
- Internet Explorer 8/9
- iPhone / iPad
- Opera 10+
- Opera Mobile
- Safari 5+

## PDF version
The CSS for the printing version makes it really easy to create the PDF file.  
For example in Google Chrome and Firefox select "Print" and then save it as a PDF.

## RTF version
Because I've been asked often in the past to provide the Office Word version of my cv, the best format to create dinamically something compatible with it is RTF (*Rich Text Format*).  
The basic template `cv-template.rtf` has been created using TextEdit on Mac OS X, which provides a clean and simple file to subsequently edit with a text editor like Sublime Text. This last step is necessary because in rtf format the characters `{ }` are escaped, while Mustache templating system requires them to be unescaped.

The compiled version is created by accessing `cv-controller.php?f=rtf`.