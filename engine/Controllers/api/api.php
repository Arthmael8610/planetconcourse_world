<?php
/**
 * Minds API - pseudo router
 *
 * @version 1
 * @author Mark Harding
 *
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="www.planetconcourse.world",
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0",
 *         title="Minds",
 *         description="",
 *         termsOfService="http://helloreverb.com/terms/",
 *         @SWG\Contact(
 *             email="apiteam@wordnik.com"
 *         ),
 *         @SWG\License(
 *             name="To be confirmed",
 *             url="http://www.minds.org/"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about Minds",
 *         url="http://www.minds.org"
 *     )
 * )
 * @SWG\SecurityScheme(
 *   securityDefinition="minds_oauth2",
 *   type="oauth2",
 *   authorizationUrl="https://www.planetconcourse.world/oauth2/authorize",
 *   flow="implicit",
 *   scopes={
 *   }
 * )
 * @SWG\Info(title="Minds Public API", version="1.0")
 */
namespace Minds\Controllers\api;

use Minds\Core;
use Minds\Interfaces;
use Minds\Api\Factory;

class api implements Interfaces\Api
{
    public function get($pages)
    {
        return Factory::build($pages);
    }
    
    public function post($pages)
    {
        return Factory::build($pages);
    }
    
    public function put($pages)
    {
        return Factory::build($pages);
    }
    
    public function delete($pages)
    {
        return Factory::build($pages);
    }
}
