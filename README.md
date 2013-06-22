Kohana_Production_Module
========================

A module for the Kohana PHP framework to help rapidly create and deploy a  production-ready site.

Kohana is a great framework for rapidly developing lightweight, robust PHP applications but it is not so good when it comes to deploying a live application. This module helps fill in some of the gaps by providing:

- suitable responses to error conditions instead of the dreaded Kohana_Exception error dump
  - template pages for 404 Not Found and other 4xx errors
  - appropriate HTTP response headers and payload for API/JSON/JSONP/AJAX requests and <form> posts
- routes and a controller base class to separate and deal appropriately with 
  - requests for HTML pages
  - Posts from HTML <form>s
  - public API requests
  - JSON/JSONP requests from a client-side application
- a skeleton for authentication
  - cookie-based sessions for HTML pages
  - anti-CSRF tokens for HTML <form>s
  - HTTP header authentication keys for public API requests
  - HTTP header session tokens for JSON/JSONP requests from a client-side application

### Version: 0.9.1-unstable

Important Information
---------------------

The Kohana Production Module is Copyright © 2013 [MrAnchovy](http://www.mranchovy.com) and is distributed under the [MIT License](http://opensource.org/licenses/MIT) - see the included [LICENSE.md](LICENSE.md) file.
