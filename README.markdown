What is this?
=============
This is where I'm going to keep php classes (or other bits of code) that I make use of on a day-to-day basis, or are at least *very useful* and *nice*.

What is in here?
================
Sanitize.php
------------
Just as the name suggests, this class is for sanitizing things that you stick into it---it started out as a humble `$_POST` handler, but then I realized that because of the goodness of Dependency Injection, it was much more useful than that.  So it'll clean up any array or object you like, and allow you to access the keys of said array or object like so:

```php
<?php
$sanitized = Sanitize::Clean($_POST);
$sanitized->foo; // == $_POST['foo'] OR null
```

### TODO
* Perhaps Sanitize should provide a way to access the entire sanitized array or object all at once, so it may be iterated over, etc.

Slideshowpro_Interface.php
------------
Simple class that provides some quick ways of pulling information out of a SlideshowPro Director install. Right now it needs hardcoded connection strings, check $_connectString, $_user and $_pass. Use Slideshowpro_Interface::getActiveAlbums() to get the albums marked 'active' and information about the album thumbnails. Use Slideshowpro_Interface::getImageList() to get the image IDs for a specific album.

### TODO
* Provide a constructor or initializer to set up database connection information.

Csv_Import.php
------------
Quick way to import a csv file into a database table. Use:

```php
<?php
$importer = new Csv_Import($path_to_csv, TRUE);
$importer->setupDatabase($connection_string, $username, $password);
$importer->importTo($table_name);
```

If the second parameter to the constructor is true, the import will use the first line of the csv file as the column names in the database table, and skip that line during the import. If you need to use a different column mapping, do the following:

```php
<?php
$importer = new Csv_Import($path_to_csv, FALSE);
$importer->setupDatabase($connection_string, $username, $password);
$importer->setMapping(array('Column_One', 'Column_Two', 'Column_Three'));
$importer->importTo($table_name);
```

You can also send TRUE to the constructor and set a different mapping if you need to skip the first line of the csv.

Compatibility
=============
Anything I put here should be usable with PHP 5.2 and above, as most of the servers I work with are still on 5.2.x

Coding Standards
================
I'm quite obsessive about how I format my code, though I can't say that I adhere strictly to a specific set of guidelines.  In general, I try to follow guidelines in this order:

1. [Zend Framework Coding Standards](http://framework.zend.com/manual/en/coding-standard.html)
2. [PEAR Coding standards](http://pear.php.net/manual/en/standards.php)

And then sometimes I make decisions that a particular rule is stupid, and choose that.  To my knowledge that has only happened once recently---I don't want to do 4 space tabs anymore.  I have ruby envy, and think that 2 is quite enough.

License
=======
This project is licensed under the [DBAD license](http://dbad-license.org/license).

Credits
=======
* [Russell Stringer](https://github.com/Feodoric)
* [Adam Bowen](https://github.com/adamnbowen)
