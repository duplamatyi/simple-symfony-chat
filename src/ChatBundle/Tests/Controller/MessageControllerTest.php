<?php

namespace ChatBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use ChatBundle\Tests\ChatTestCase;


class MessageControllerTest extends ChatTestCase
{
    /**
     * A message containing valid content and the application/json Content-type header
     * should be successfully created on the server.
     */
    public function testMessageSentWithSuccess()
    {
        $content = $this->createRawContent(1, 2, 'Hello World!');
        $server = $this->getServerParams();

        static::$client->request('POST', '/message/send', array(), array(), $server, $content);

        $status = static::$client->getResponse()->getStatusCode();

        $this->assertEquals($status, Codes::HTTP_CREATED);
    }

    /**
     * If the Content-type header is not set to application/json
     * the server should return a HTTP_BAD_REQUEST status code.
     */
    public function testMessageSentWithoutContentHeader()
    {
        $content = $this->createRawContent(1, 2, 'Hello World!');

        static::$client->request('POST', '/message/send', array(), array(), array(), $content);

        $status = static::$client->getResponse()->getStatusCode();

        $this->assertEquals($status, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * It the users referenced by the server do not exist the server should return a HTTP_BAD_REQUEST status code.
     */
    public function testMessageSentWithNotExistingUsers()
    {
        $content = $this->createRawContent(4, 5, 'Hello World!');
        $server = $this->getServerParams();

        static::$client->request('POST', '/message/send', array(), array(), $server, $content);

        $status = static::$client->getResponse()->getStatusCode();

        $this->assertEquals($status, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * The messages of an existing user should be returned by the server in json format.
     */
    public function testGetMessagesSuccess()
    {
        $server = $this->getServerParams();

        static::$client->request('GET', '/message/get-messages', array('recipient_id' => 2), array(), $server);

        $status = static::$client->getResponse()->getStatusCode();
        $content = static::$client->getResponse()->getContent();
        $content_array = json_decode($content, true);

        $this->assertEquals($status, Codes::HTTP_OK);
        $this->assertEquals(count($content_array), 1);
        $this->assertEquals($content_array[0]['author_id'], '1');
        $this->assertEquals($content_array[0]['author_username'], 'user1');
        $this->assertEquals($content_array[0]['content'], 'Hello World!');
    }

    /**
     * If no recipient user was specified the server should return a HTTP_BAD_REQUEST status code.
     */
    public function testGetMessagesWithoutRecipientParam()
    {
        $server = $this->getServerParams();

        static::$client->request('GET', '/message/get-messages', array(), array(), $server);

        $status = static::$client->getResponse()->getStatusCode();

        $this->assertEquals($status, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * Returns the json encoded raw content of a send message request.
     *
     * @param $author int
     * @param $recipient int
     * @param $message string
     * @return string
     */
    private function createRawContent($author, $recipient, $message)
    {
        $content = new \stdClass();
        $content->author_id = $author;
        $content->recipient_id = $recipient;
        $content->content = $message;

        return json_encode($content);
    }

    /**
     * Return the list of the parameters stored in $_SERVER.
     *
     * @return array
     */
    private function getServerParams()
    {
        return array(
            'CONTENT_TYPE' => 'application/json',
        );
    }
}
