<?php

namespace Parabol\LocaleAdminBundle\Controller\Country;

use Admingenerated\AppLocaleAdminBundle\BaseCountryController\ActionsController as BaseActionsController;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{
	public function countryInfoAction($code)
	{
		return new JsonResponse(file_get_contents('https://restcountries.eu/rest/v1/alpha/' . $code), 200, array(), true);
	}
}
