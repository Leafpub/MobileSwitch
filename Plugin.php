<?php
/**
 * Leafpub: Simple, beautiful publishing. (https://leafpub.org)
 *
 * @link      https://github.com/Leafpub/leafpub
 * @copyright Copyright (c) 2016 Leafpub Team
 * @license   https://github.com/Leafpub/leafpub/blob/master/LICENSE.md (GPL License)
 */

namespace Leafpub\Plugins\MobileSwitch;

use Leafpub\Leafpub,
    Leafpub\Plugin\APlugin;

class Plugin extends APlugin {
    public function __construct(\Slim\App $app){
        $app->getContainer()['settings']['determineRouteBeforeAppMiddleware'] = true;
        parent::__construct($app);
    }
    public function __invoke($request, $response, $next){
        $route = $request->getAttribute('route');
        if ($route && $route->getPattern() === '/{post}'){
            $uri = $request->getUri();
            $s = "/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|PlayBook|Kindle|Windows Phone/i";
            if (preg_match($s, $request->getServerParam('HTTP_USER_AGENT'))){
                return $response->withRedirect($uri . '/amp');
            }
        }
        return $next($request, $response);
    }    
}
