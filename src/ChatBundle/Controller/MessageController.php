<?php

namespace ChatBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use ChatBundle\Entity\Message;
use ChatBundle\Form\MessageType;

class MessageController extends FOSRestController
{
    /**
     * Send a new message.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     *
     * @Route("/send")
     * @Method({"POST"})
     * @Rest\RequestParam(name="author", requirements="\d+", description="The id of the author.")
     * @Rest\RequestParam(name="recipient", requirements="\d+", description="The id of the recipient.")
     * @Rest\RequestParam(name="content", description="The content of the message.")
     * @ApiDoc(
     *  statusCodes={
     *   201="Returned when the message was stored on the server.",
     *   400="The request could not be understood by the server.",
     *   500="Returned when something went horribly wrong."
     *  }
     * )
     */
    public function sendAction(ParamFetcher $paramFetcher)
    {
        $params = $paramFetcher->all();
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->submit($params);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return new Response('The message was successfully created.', Codes::HTTP_CREATED);
        }

        return new Response('The request could not be understood by the server.', Codes::HTTP_BAD_REQUEST);
    }

    /**
     *
     * Get the messages received by a user.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return array
     *
     * @Route("/get-messages")
     * @Method({"GET"})
     *
     * @Rest\View(serializerGroups={"received"})
     * @Rest\QueryParam(name="recipient", requirements="\d+", description="The id of the recipient.", strict=true)
     * @ApiDoc(
     *  resource=true,
     *  output={
     *   "class"="ChatBundle\Entity\Message",
     *   "groups"={"received"}
     *  },
     *  statusCodes={
     *   200="Returned when successful.",
     *   400="The request could not be understood by the server.",
     *   500="Returned when something went horribly wrong."
     *  }
     * )
     */
    public function getMessagesAction(ParamFetcher $paramFetcher)
    {
        $recipient = $paramFetcher->get('recipient');
        $messages = $this->getDoctrine()
            ->getRepository('ChatBundle:Message')
            ->findMessagesByRecipient($recipient);

        return $messages;
    }
}
