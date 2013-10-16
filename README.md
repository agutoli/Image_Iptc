Image_Iptc
==========

Specific class for manipulating IPTC/EXIF metadata of jpeg images

Includes Demo writing Keywords/Tags and Caption to image.

Examples
----------------

### Writing tags

    require 'Iptc.php';

    $iptc = new Iptc('et_betrayed.jpg');
    
    $iptc->set(Iptc::CAPTION, array(
        'NASA finally managed to contact with extraterrestrials, here are a few excerpts from the chat...',
        'E.T.: Hi Earthlings .\//,',
        'NASA agent: What do you want from us?',
        'E.T.: We want to see a show of Katy Perry',
        'NASA agent: Really? Why?',
        'E.T.: Why E.T. music reminds me of my ex wife',
        'NASA agent: What happened to her?',
        'E.T.: She ran away with the "E.T." protagonist of the movie Steven Spielberg ...',
        'NASA agent: How sad!! '
    ));
    $iptc->write();

    // read tags
    print_r($iptc->fetchAll(Iptc::CAPTION));


Feature Overview
----------------

* Reading and writing IPTC/EXIF tags
* Support for array data, can write a list of tags
* Removing IPTC tags
* Append and Prepend of tags
* Fetch and FethAll tags

Contributors
============

**Special thanks to the following contributors:**

* [Toby Allen](https://github.com/tobya)
* [netboy](https://github.com/netboy)

## License

(The MIT License)

Copyright (c) 2012 Bruno Agutoli &lt;bruno.agutoli@gmail.com&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
