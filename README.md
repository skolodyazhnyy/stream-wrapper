PHP Stream Wrapper Component
============================

PHP stream wrapper for testing classes which interact with files

Usage
-----------------

```php
// Reading
$stream = new Stream("Content");

$fh = fopen($stream->uri(), "r");
echo fgets($fh); // output Content
fclose($fh);
```

```php
// Writing
$stream = new Stream();

$fh = fopen($stream->uri(), "r");
fputs($fh, "Content");
fclose($fh);

echo $stream->content(); // output Content
```