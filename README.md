Stream Wrapper
==============

This library provide a lightweight class which allows substitute PHP streams. It's very useful for Unit Testing when you need
to test a class which interact with files.

Stream class create an unique [stream wrapper](http://www.php.net/manual/en/class.streamwrapper.php) which redirect
file system calls to instance of Stream class, making the process fully controllable.

Usage
-----------------

**Reading**
```php
$stream = new Stream("Content");

// This code use variable instead of using actual file
$fh = fopen($stream, "r");
echo fgets($fh); // output Content
fclose($fh);
```

**Writing**
```php
$stream = new Stream();

// This code write everything into variable
$fh = fopen($stream, "r");
fputs($fh, "Content");
fclose($fh);

// Now you can perform actions on generated content
echo $stream->getContent(); // output Content
```
