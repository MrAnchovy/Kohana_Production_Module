<?php
/**
 * Base class for a default controller.
 *
 * Applications can override this; all controllers should extend
 * `Controller_Default`. As this class does not impement any actions we don't
 * have to worry about making a valid route to eg www.mydomain/default/index
 *
 * @package    kpro
 * @category   core
 * @author     [MrAnchovy](http://www.mranchovy.com)
 * @copyright  Copyright © 2013 [MrAnchovy](http://www.mranchovy.com)
 * @license    http://kohanaframework.org/license
 * @link       https://github.com/MrAnchovy/Kohana_Production_Module
**/
abstract class Controller_Default extends Kpro_Controller {
}
