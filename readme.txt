=== Debug Bar Tracer ===
Contributors: welcher
Donate link: http://www.ryanwelcher.com/donate/
Tags: theme development, plugin development, debug bar addon
Requires at least: 3.1
Tested up to: 3.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Trace messages/data to a Debug Bar window from your theme or plugin. Requires the Debug Bar plugin

== Description ==

Many times when creating a custom theme or plugin there is need to view a piece of data you are working with. Sending it out to the browser is ugly and can break layout.
This plugin adds a new tab to the Debug Bar plugin that allows you to "trace" the data to a window and displays not only the data, but where the call came from and optionally a description.

Plus, it's green like the Matrix.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Be sure you have Debug Bar installed and active

== Frequently Asked Questions ==

= I don't see anything in the Debug Bar window =

The Tracer tab only appears where there are items to trace.

= How do I trace an item? =

Place a call to debug_trace( $param ) into your theme or plugin.


== Changelog ==

= 1.0 =
* First Release


== About debug_trace ==

The method debug_trace() takes one parameter that can be of any data type. 
If you want to pass a descriptor for the debug_trace(), pass an array with the following indices:

* 'key' => The descriptor
* 'data' => What you want to trace - can be any data type.

Behind the scenes, each trace is actually an array containing the location of the call, the data and optionally a custom key.
If the parameter passed to debug_trace() is an array that has a key of 'key' or 'data', then the method overrides the defaults with it.
Otherwise, the method assumes you want to trace the passed parameter as the 'data'.
