<?php

namespace Parabol\LocaleAdminBundle\Controller\Locale;

use Admingenerated\AppLocaleAdminBundle\BaseLocaleController\ActionsController as BaseActionsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{
	public function attemptObjectTranslations($pk)
	{
		$country = $this->getObject($pk);
		$request = $this->get('request_stack')->getCurrentRequest();


		$defaultsFile = $this->container->getParameter('parabol_locale_admin.source_transaltions_file');

		if(!file_exists($defaultsFile)) throw new \Exception(sprintf("File %s defined in parabol_locale_admin.source_transaltions_file does not exist.", $defaultsFile));
		

		$transaltionsFile = preg_replace('#\.[\w]{2}\.yml$#', '.' . $country->getCode() . '.yml', $defaultsFile);

		if($request->isMethod(Request::METHOD_POST))
		{
			try
			{
				$yaml = Yaml::dump($request->get('translations'));
				file_put_contents($transaltionsFile, $yaml);
				
				$success = true;
			}
			catch(\Exception $e)
			{
				$success = false; 
			}

			$this->cc($country);

			if(!$success)
			{
				$this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
				return $this->redirect($request->getUri());
			} 
			else return $this->redirectToRoute('Parabol_LocaleAdminBundle_Locale_object', array('pk' => $pk, 'action' => 'clearCache'));
		}


		$defaults = Yaml::parse(file_get_contents($defaultsFile));


		if(file_exists($transaltionsFile))
		{
			$translations = Yaml::parse(file_get_contents($transaltionsFile));
		}
		else $translations = array();

		return $this->render('ParabolLocaleAdminBundle:LocaleActions:translations.html.twig', array('defaults' => $defaults, 'translations' => $translations, 'title' => 'Translations for locale: ' . $country->getCode()));
	}

	public function attemptObjectClearCache($pk)
	{
		$country = $this->getObject($pk);
		
		$this->cc($country);

		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("action.object.edit.success", array(), 'Admingenerator') );

		return $this->redirectToRoute('Parabol_LocaleAdminBundle_Locale_object', array('pk' => $pk, 'action' => 'translations'));
	}

	private function cc($country)
	{
		$cachedFiles = $this->container->getParameter('kernel.root_dir').'/cache/prod/appProdUrl*';

		foreach (glob($cachedFiles) as $file) {
			 unlink($file);
		}

		$containerCache = $this->container->getParameter('kernel.root_dir').'/cache/prod/appProdProjectContainer.php';
		if(file_exists($containerCache)) unlink($containerCache);

		$cachedFiles = $this->container->getParameter('kernel.root_dir').'/cache/*/translations/catalogue.'. $country->getCode().'.*';

		foreach (glob($cachedFiles) as $file) {
			 unlink($file);
		}
	}

	public function translationsEnablerAction()
	{
		$countriesJsonMap = json_encode(array_reduce($this->getDoctrine()->getRepository('AppBundle:Country')->createQueryBuilder('c')->select('c.id, c.code')->getQuery()->getArrayResult(), 
			function($arr, $v){ $arr[$v['id']] = $v['code']; return $arr;}
			, array()));
		
		return $this->render('ParabolLocaleAdminBundle:CountryActions:_translationsEnabler.html.twig', array('countriesJsonMap' => $countriesJsonMap));
	}

}
