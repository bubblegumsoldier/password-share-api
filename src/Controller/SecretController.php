<?php
namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Secret;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Brand controller.
 *
 */
class SecretController extends FOSRestController
{
    /**
     * Get Secret meta information.
     * @FOSRest\Get("/secrets/{secretId}")
     *
     * @return array
     */
    public function getSecretsAction($secretId)
    {
        $repository = $this->getDoctrine()->getRepository(Secret::class);
        
        // query for a single Product by its primary key (usually "id")
        $secret = $repository->find($secretId);
        if(!$secret)
        {
            return View::create(array("message" => "Not Found"), Response::HTTP_NOT_FOUND, []);
        }
        
        $stripped_secret = array(
            "from_mail" => $secret->getFromMail(),
            "created_at" => $secret->getCreatedAt(),
            "valid_until" => $secret->getValidUntil()
            );

        return View::create($stripped_secret, Response::HTTP_OK , []);
    }

    /**
     * Delete secret and for the only time receive its full content.
     * @FOSRest\Delete("/secrets/{secretId}")
     *
     * @return array
     */
    public function deleteSecretsAction($secretId)
    {
        $repository = $this->getDoctrine()->getRepository(Secret::class);
        
        // query for a single Product by its primary key (usually "id")
        $secret = $repository->find($secretId);
        if(!$secret)
        {
            return View::create(array("message" => "Not Found"), Response::HTTP_NOT_FOUND, []);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($secret);
        $em->flush();

        return View::create($secret, Response::HTTP_OK , []);
    }

    /**
     * Create Secret.
     * @FOSRest\Post("/secrets")
     *
     * @return array
     */
    public function postSecretAction(Request $request)
    {
        $secret = new Secret();
        $secret->setFromMail($request->get('from_mail'));
        $secret->setHash($request->get('hash'));
        $secret->setSecret($request->get('secret'));
        $secret->setCreatedAt(time());
        $secret->setValidUntil(time() + $request->get("valid_for"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($secret);
        $em->flush();
        return View::create($secret, Response::HTTP_CREATED , []);
    }
}