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
* Add Docblocks

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
I do most of the obsessing over this, but [Russell Stringer](https://github.com/Feodoric) had a fair hand in developing the first version of Sanitize.php, and is always the first person I turn to for code reviewing.
