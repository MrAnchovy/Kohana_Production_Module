<?php
/**
 * This is a demonstration of the way kpro works - applications should override it.
 *
 * @package    kpro
 * @category   demo
 * @author     [MrAnchovy](http://www.mranchovy.com)
 * @copyright  Copyright © 2013 [MrAnchovy](http://www.mranchovy.com)
 * @license    http://kohanaframework.org/license
 * @link       https://github.com/MrAnchovy/Kohana_Production_Module
**/
class Controller_Main extends Controller_Default {

/**
 * Demonstrates an exception in development mode
**/
protected function action_page_debug() {
  Kohana::$environment = Kohana::DEVELOPMENT;
  throw new Kohana_Exception('This demonstrates an exception in development mode');
}

/**
 * Demonstrates an exception in production mode
**/
protected function action_page_error() {
  Kohana::$environment = Kohana::PRODUCTION;
  throw new Kohana_Exception('This demonstrates an exception in production mode');
}

/**
 * Example implementation of a specific page
**/
protected function action_page_help() {
  return 'Here is some help';
}

/**
 * Exemple of retrieving a page from a database
**/
protected function action_pageId($id) {
  $resource = $this->resource_retrieve($id);
  if ($resource === NULL) {
    throw HTTP_Exception::factory(404,
      'Page :id not found',
      array(':id' => $id));
  }
  return $resource;
}

/**
 * Example implementation of an index page
**/
protected function action_pageIndex() {
  return 'This is the index page';
}

/**
 * Exemple of retrieving a page from a database
**/
protected function resource_retrieve($id) {
  $resources = array(
    'This is the first item',
    'This is the second item',
    'This is the third item',
    'This is the last item',
  );
  if (!isset($resources[$id])) {
    return NULL;
  }
  return $resources[$id];
}

}
