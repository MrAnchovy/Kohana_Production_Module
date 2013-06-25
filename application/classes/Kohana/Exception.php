<?php
class Kohana_Exception extends Kohana_Kohana_Exception {

/**
 * Get a Response object representing the exception
 *
 * @uses    Kohana_Exception::text
 * @param   Exception  $e
 * @return  Response
**/
public static function response(Exception $e) {

  try {
    // Get the exception information
    $code     = ($e instanceof HTTP_Exception) ? $e->getCode() : 500; // HTTP status code
    $status   = Response::$messages[$code];                           // HTTP status message
    $message  = htmlspecialchars($e->getMessage());                   // error message
    $extended = (string)$e;                                           // error message plus source location

    $debug    = Kohana::$environment === Kohana::DEVELOPMENT;

    if ( $code === 500 ) {
			Kohana_Exception::log($e);
    }

    // Prepare the response object.
    $response = Response::factory();

    // Set the response status
    $response->status($code);
    
    // Set the response headers
    $response->headers('Content-Type', Kohana_Exception::$error_view_content_type.'; charset='.Kohana::$charset);

    $route = Route::name(Request::current()->route());

    if ( $route === 'api' || $route === 'app' || Request::current()->is_ajax() ) {

      if ( $code === 500 ) {
        // for a true errror, only show the original message if in development
        $response->body(Kohana::$environment === Kohana::DEVELOPMENT ? $status : $extended);
        return $response;
      } else {
        // show a more informative message for HTTP errors
        $response->body($message);
        return $response;
      }

    } else {
      // isHtml
      if ( $code === 500 && $debug ) {
        // return the Kohana debug response
        return parent::response($e);

      } else {

        // show a user-friendly view
        $vars = get_defined_vars();
        $vars['title'] = "Error - $status";

        // first try a code-specific template e.g. views/error/error-404
        try {
          $vars['content'] = View::factory("error/error-$code", $vars)->render();
          $response->body(View::factory("error/error-page", $vars)->render());
          return $response;

        } catch (View_Exception $e) {
        }

        // next try a template for the code class e.g. views/error/error-4xx
        try {
          $vars['content'] = View::factory('error/error-'.substr($code, 0, 1).'xx', $vars)->render();
          $response->body(View::factory("error/error-page", $vars)->render());
          return $response;
        } catch (View_Exception $e) {
        }

        // finally use the default template views/error/error-default which must exist
        $vars['content'] = View::factory('error/error-default', $vars)->render();
        $response->body(View::factory("error/error-page", $vars)->render());
        return $response;

      }
    }

  } catch (Exception $e) {

    // Things are going badly for us, Lets try to keep things under control by
    // generating a simpler response object.
    $response = Response::factory();
    $response->status(500);
    $response->headers('Content-Type', 'text/plain');
    $response->body('Unrecoverable error');
    return $response;
  }

}

}
