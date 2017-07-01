<?php

namespace ApiBundle\Controller;

use CoreBundle\Entity\Note;
use CoreBundle\Entity\User;
use CoreBundle\Manager\NoteManager;
use CoreBundle\Manager\UserManager;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/v1")
 */

class NoteController extends FOSRestController
{

    /**
     * @ApiDoc(
     *  description="Return a Hello World for testing api config",
     * )
     *
     * @Get("/test")
     */
    public function testAction(Request $request)
    {

        $view = View::create("Test");
        $view
            ->setData('HOLA MUNDO!!')
            ->setStatusCode(Codes::HTTP_OK);

        return $view;

    }

    /**
     * @ApiDoc(
     *  description="Create note",
     *
     *     headers={
     *      {
     *          "name"="idUser",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="user id"
     *      }
     *  },
     *     parameters={
     *      {
     *          "name"="message",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="message"
     *      },
     * }
     * )
     *
     * @Post("/note")
     */
    public function createNoteAction(Request $request)
    {

        $request=$this->getRequest();
        $data = $request->request->all();

        if(!$request->headers->has('idUser'))
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idUser'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        if (!$request->request->has('message') | $request->request->get('message') == "")
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro message'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        /** @var NoteManager $noteManager */
        $noteManager = $this->get("core.manager.note");
        /** @var Note $note */
        $note = new Note();
        $note->setMessage($data['message']);
        $note->setUser($user);
        $noteManager->add($note);
        $noteManager->applyChanges();

        $view = View::create("Nueva nota");
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $serializationContext->setGroups(array('message'));
        $view
            ->setData($note)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;

    }

    /**
     * @ApiDoc(
     *  description="Get notes",
     *
     *  headers={
     *      {
     *          "name"="idUser",
     *          "dataType"="string",
     *          "description"="user id",
     *          "required"=true,
     *      }
     *  },
     *
     * )
     *
     * @Get("/note")
     */
    public function noteListAction(Request $request)
    {

        if (!$request->headers->has('idUser'))
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idUser'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        /** @var NoteManager $noteManager */
        $noteManager = $this->get("core.manager.note");
        /** @var ArrayCollection<Note> $notes */
        $notes = $noteManager->findAll();

        if (count($notes) == 0)
        {
            $notes = 'No se encontraron elementos';
        }

        $view = View::create("Lista Completa de Noticias");
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $serializationContext->setGroups(array('messages'));
        $view
            ->setData($notes)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;

    }

    /**
     * @ApiDoc(
     *  description="Get note by id",
     *
     *  requirements={
     *      {
     *          "name"="idNote",
     *          "dataType"="string",
     *          "description"="note id",
     *          "required"=true,
     *      }
     *  },
     *  headers={
     *      {
     *          "name"="idUser",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="user id"
     *      },
     *  },
     * )
     *
     * @Get("/note/{idNote}")
     */
    public function noteByIdAction(Request $request)
    {

        $request=$this->getRequest();

        if(!$request->headers->has('idUser'))
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idUser'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        $request=$this->getRequest();
        $idNote = $request->get('idNote');

        /** @var NoteManager $noteManager */
        $noteManager = $this->get("core.manager.note");
        /** @var Note $note */
        $note = $noteManager->findById($idNote);

        $view = View::create("Nota por id");
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $serializationContext->setGroups(array('message'));
        $view
            ->setData($note)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;

    }

    /**
     * @ApiDoc(
     *  description="Mark note as favourite",
     *
     *   headers={
     *      {
     *          "name"="idUser",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="user id"
     *      },
     *  },
     *   parameters={
     *      {
     *          "name"="idNote",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="note id"
     *      }
     *
     *  }
     * )
     *
     * @Post("/note/fav")
     */
    public function markNoteFavAction(Request $request)
    {
        $request=$this->getRequest();
        if(!$request->headers->has('idUser'))
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idUser'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        if(!$request->request->has('idNote')| $request->request->get('idNote') == "")
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idNote'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var NoteManager $noteManager */
        $noteManager = $this->get("core.manager.note");
        /** @var Note $note */
        $note = $noteManager->findById($request->request->get('idNote'));

        if (is_null($note))
        {
            $note = 'No se encontraron resultados';
        }
        else
        {
            $note->setIsFav(true);
            $noteManager->update($note);
            $noteManager->applyChanges();

            $view = View::create("Marcada nota como favorita");
            $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
            $serializationContext->setGroups(array('message'));
            $view
                ->setData($note)
                ->setStatusCode(Codes::HTTP_OK)
                ->setSerializationContext($serializationContext);

            return $view;
        }

    }

    /**
     * @ApiDoc(
     *  description="Get fav notes",
     *
     *  headers={
     *      {
     *          "name"="idUser",
     *          "dataType"="string",
     *          "description"="user id",
     *          "required"=true,
     *      }
     *  },
     *
     * )
     *
     * @Get("/favourites")
     */
    public function favListAction(Request $request)
    {

        if (!$request->headers->has('idUser'))
        {
            $view = View::create(array('error'=> Codes::HTTP_BAD_REQUEST,"message"=>'Falta el parámetro idUser'), Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        /** @var UserManager $userManager */
        $userManager = $this->get("core.manager.user");
        $user = $userManager->findById($request->headers->get('idUser'));

        if (!$user)
        {
            $view = View::create(array('error' => "404", "message" => "Usuario no encontrado."),404);
            return $this->handleView($view);
        }

        /** @var NoteManager $noteManager */
        $noteManager = $this->get("core.manager.note");
        /** @var ArrayCollection<Note> $notes */
        $notes = $noteManager->findFavourites();

        if (count($notes) == 0)
        {
            $notes = 'No se encontraron elementos';
        }

        $view = View::create("Lista Completa de Noticias");
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $serializationContext->setGroups(array('messages'));
        $view
            ->setData($notes)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;

    }

}
