<?php

namespace Parabol\LocaleAdminBundle\Controller\Country;

use Admingenerated\AppLocaleAdminBundle\BaseCountryController\NewController as BaseNewController;
use Symfony\Component\HttpFoundation\Request;
/**
 * NewController
 */
class NewController extends BaseNewController
{
	// public function createAction(Request $request)
	// {
	// 	$this->request = $request;
            

 //        $Country = $this->getNewObject();

 //        $this->preBindRequest($Country);
 //        $form = $this->getNewForm($Country);
 //        $form->handleRequest($this->request);
 //        $this->postBindRequest($form, $Country);

 //        if ($form->isSubmitted() && $form->isValid()) {
 //            try {
 //                $this->preSave($form, $Country);
 //                $this->saveObject($Country);
 //                $this->postSave($form, $Country);

 //                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("action.object.edit.success", array(), 'Admingenerator') );

 //                                $actionAfterSave = "edit";
 //                $pk = $Country->getCode();
 //                if ($this->request->request->has('save-and-add') || ('new' == $actionAfterSave)) {
 //                    return $this->redirect($this->getNewUrl());
 //                } elseif ($this->request->request->has('save-and-list') || ('list' == $actionAfterSave)) {
 //                    return $this->redirect($this->getListUrl());
 //                } elseif ($this->request->request->has('save-and-show') || ('show' == $actionAfterSave)) {
 //                    return $this->redirect($this->getShowUrl($pk));
 //                } else {
 //                    if (('edit' != $actionAfterSave) &&
 //                        method_exists($this,'getEditUrl')) {
 //                        return $this->redirect(call_user_func(array($this, 'getEditUrl'), $pk));

 //                    }
 //                    return $this->redirect($this->getEditUrl($pk));
 //                }
 //            } catch (\Exception $e) {
 //            	$logger = $this->get('logger')->error($e->getMessage());
 //                $this->get('session')->getFlashBag()->add('error',  $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
 //                $this->onException($e, $form, $Country);
 //            }

 //        } else {
 //            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans("action.object.edit.error", array(), 'Admingenerator') );
 //        }

 //        $Country->setCode(null);

 //        return $this->render('ParabolLocaleAdminBundle:CountryNew:index.html.twig', $this->getAdditionalRenderParameters($Country) + array(
 //            'Country' => $Country,
 //            'createUrl' => $this->getCreateUrl(),
 //            'form' => $form->createView(),
 //        ));
	// }
}
