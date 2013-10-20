WPToolkit 2
===========

Includes various tools for simplifying your theme and plugin development. Used classes are autoloaded so it keeps the server load to a minimum. The two big usages of this plugin is to create new posttypes with a single function call and to create post meta boxes with various types of input possibilities.

This is a new improved version of the old WP Toolkit, which was only a drop-in code library for WordPress themes. This one is a plugin which enable it's functions to be used by both the theme and other plugins. It activates itself so all you need to do is to make sure the plugin is activated and then call its functions.

Post Type
---------

Register a new custom post type with one simple function call. It has some default settings which you can easily override. 

```php
new PostType($post_type, $name_singular, $name_plural, $options = array());
```

It requires three of four arguments:
* __$post_type__ The internal post type name, will be used to connect other functionality to it.
* __$name_singular__ The singular name, will be shown in the admin panel.
* __$name_plural__ The name in plural form, will be shown in the admin panel.
* __$options__ Optional post type settings, will override defaults. 

Example:
```php
new PostType('posttype', 'Posttype', 'Posttypes', array('menu_position' => 5));
```

