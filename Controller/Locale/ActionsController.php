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
		$locale = $this->getObject($pk);
		$request = $this->get('request_stack')->getCurrentRequest();


		$defaultsFile = $this->container->getParameter('parabol_locale_admin.source_transaltions_file');

		if(!file_exists($defaultsFile)) throw new \Exception(sprintf("File %s defined in parabol_locale_admin.source_transaltions_file does not exist.", $defaultsFile));
		

		$transaltionsFile = preg_replace('#\.[\w]+\.yml$#', '.' . $locale->getCode() . '.yml', $defaultsFile);
		
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

			
			$this->cc($locale);

			if(!$success)
			{
				$this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
				return $this->redirect($request->getUri());
			} 
			else return $this->redirectToRoute('App_LocaleAdminBundle_Locale_object', array('pk' => $pk, 'action' => 'clearCache'));
		}


		$defaults = Yaml::parse(file_get_contents($defaultsFile));


		if(file_exists($transaltionsFile))
		{
			$translations = Yaml::parse(file_get_contents($transaltionsFile));
		}
		else $translations = array();

		return $this->render('AppLocaleAdminBundle:LocaleActions:translations.html.twig', array('defaults' => $defaults, 'translations' => $translations, 'title' => 'Translations for locale: ' . $locale->getCode()));
	}

	public function attemptObjectClearCache($pk)
	{
		$locale = $this->getObject($pk);
		
		$this->cc($locale);

		$this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("action.object.edit.success", array(), 'Admingenerator') );

		return $this->redirectToRoute('App_LocaleAdminBundle_Locale_object', array('pk' => $pk, 'action' => 'translations'));
	}

	private function cc($locale)
	{

		$cachedFiles = $this->container->getParameter('kernel.cache_dir').'/appProd*';

		foreach (glob($cachedFiles) as $file) {
			 unlink($file);
		}

		$cachedFiles = $this->container->getParameter('kernel.cache_dir').'/translations/catalogue.'. $locale->getCode().'.*';

		foreach (glob($cachedFiles) as $file) {
			 unlink($file);
		}
	}

	public function translationsEnablerAction()
	{
		$countriesJsonMap = json_encode(array_reduce($this->getDoctrine()->getRepository('AppBundle:Country')->createQueryBuilder('c')->select('c.id, c.code')->getQuery()->getArrayResult(), 
			function($arr, $v){ $arr[$v['id']] = $v['code']; return $arr;}
			, array()));
		
		return $this->render('AppLocaleAdminBundle:CountryActions:_translationsEnabler.html.twig', array('countriesJsonMap' => $countriesJsonMap));
	}

}
