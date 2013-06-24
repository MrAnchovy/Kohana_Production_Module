<?php
/**
 * Initialisation for the kpro (Kohana Production) module
 *
 * Sets the routes to be handled by a kpro controller
 *
 * @package    kpro
 * @category   core
 * @author     [MrAnchovy](http://www.mranchovy.com)
 * @copyright  Copyright © 2013 [MrAnchovy](http://www.mranchovy.com)
 * @license    http://kohanaframework.org/license
 * @link       https://github.com/MrAnchovy/Kohana_Production_Module
**/
abstract class Kpro_Controller extends Controller {

protected $requestType;

public function before() {
  //$this->requestType = $this->request->action();
}

protected function call_requested_method() {

  // get the parameters that define the request
  $action = $this->request->action();
  $id = $this->request->param('id');

  // call index method
  if ($id === NULL ) {
    $method = "action_{$action}Index";
    return $this->$method();
  }

  // see if there is a specific method for this id - avoid use of method_exists
  // because of case insensitivity: we do not want /my/Page to hit /my/page
  $method = "action_{$action}_$id";
  try {
    $reflection = new ReflectionMethod($this, $method);
    if ($reflection->name !== $method) {
      $method = FALSE;
    }
  } catch (ReflectionException $e) {
    // method doesn't exist
    $method = FALSE;
  }
  if ($method !== FALSE) {
    return $this->$method();
  }

  // call the basic method for the action e.g. action_pageId($id)
  $method = "action_{$action}Id";
  return $this->$method($id);

}

/**
 * Implement permissions.
 *
 * If permissions are required an application should overload this function in
 * its Controller_Default
 *
 * @return  boolean  TRUE if permitted, otherwise FALSE
**/
protected function isPermitted() {
  return TRUE;
}

/**
 * Send an application package
 *
 * @return  void
**/
function action_app() {

  // see if the user is allowed access
  if ( !$this->isPermitted() ) {
    throw new HTTP_Exception_403('Permission denied');
  }

  // see if the method exists
  $method = '_action_app_'.$this->id;

  $this->set_view_defaults();

  if ( method_exists($this, $method) ) {
    $this->api_response($this->$method());

  } else {
    $this->api_response($this->_action_app($this->id));

  }
    
} // end function action_app()

protected function _action_app($id) {
  if ( $id==='' ) {
    throw HTTP_Exception::factory(404, 
      'The controller :controller does not have a default application package.',
      array(
        ':controller' => get_called_class(),
      ));
  } else {
    throw HTTP_Exception::factory(404, 
      'The requested application package [:id] does not exist in the controller [:controller].',
      array(
        ':id' => $this->id,
        ':controller' => get_called_class(),
      ));
  }
}

/**
 * Show a HTML page.
 * 
 * @return  void
**/
public function action_page() {

  // see if the user is allowed access
  if ( !$this->isPermitted() ) {
    return $this->action_pageDenied();
  }

  $response = $this->call_requested_method();

  // ensure this is a string to avoid a __toString error later
  if (!is_string($response)) {
    throw new Kohana_Exception('Page method should return a string to avoid potential __toString() errors');
  }
    
  $this->response->body($response);
}

/**
 * Show a page response to permission denied
 * 
 * @return  void
**/
protected function action_pageDenied() {
  throw HTTP_Exception::factory(403);
}

/**
 * Process a page request using a page id
 *
 * Override this in a controller to show pages. Example:
 *      $page = ORM::factory('page', $id);
 *      if (!$page->loaded()) {
 *        throw HTTP_Exception::factory(404);
 *      }
 *      return Page::current()
 *        ->title($page->title)
 *        ->content($page->content)
 *        ->render();
 * 
 * @param   string  the requested page id
 * @return  string  the rendered page
**/
protected function action_pageId($id) {
  throw HTTP_Exception::factory(404, 
    'The requested page [:id] does not exist in the :controller controller.',
    array(
      ':id' => $id,
      ':controller' => $this->request->controller(),
    ));
}

/**
 * Process a page request with no id.
 *
 * Override this in a controller to show an index page. Example:
 *     return Page::current()
 *       ->title('My page title')
 *       ->content('My page content')
 *       ->render();
 *
 * @return  string  the rendered page
**/
protected function action_pageIndex() {
  throw HTTP_Exception::factory(404, 
    'The :controller controller does not have an index page.',
    array(
      ':controller' => $this->request->controller(),
    ));
}

}
