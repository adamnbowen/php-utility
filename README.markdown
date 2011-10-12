What is this?
=============
This is where I'm going to keep php classes (or other bits of code) that I make use of on a day-to-day basis, or are at least *very useful* and *nice*.

What is in here?
================
Sanitize.php
------------
Currently, I've only got one class in here---Sanitize.php.  Just as the name suggests, this class is for sanitizing things that you stick into it---it started out as a humble `$_POST` handler, but then I realized that because of the goodness of Dependency Injection, it was much more useful than that.  So it'll clean up any array or object you like, and allow you to access the keys of said array or object like so:

```php
$sanitized = new Sanitize($_POST);
$sanitized->foo; // == $_POST['foo'] OR null
```

### TODO
* Perhaps Sanitize should provide a way to access the entire sanitized array or object all at once, so it may be iterated over, etc.

License
=======
This project is licensed under the [DBAD license](http://dbad-license.org/license).

Credits
=======
I do most of the obsessing over this, but [Russell Stringer](https://github.com/Feodoric) had a fair hand in developing the first version of Sanitize.php, and is always the first person I turn to for code reviewing.
