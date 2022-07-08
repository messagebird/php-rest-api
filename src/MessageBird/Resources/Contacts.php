<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\BaseList;

/**
 * Class Contacts
 *
 * @package MessageBird\Resources
 */
class Contacts extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'contacts');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Contact::class;
    }

    /**
     * @param Objects\Arrayable $params
     * @param string $id
     * @return Objects\Base|Objects\Contact
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function update(Objects\Arrayable $params, string $id): Objects\Contact
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_PATCH,
            "{$this->getResourceName()}/$id",
            ['body' => $params->toArray()]
        );

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $id
     * @param array $params
     * @return BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchMessages(string $id, array $params = []): BaseList
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$id/messages?" . http_build_query($params)
        );

        $responseArray = json_decode($response->getBody(), true);

        $list = new BaseList();
        $list->limit = $responseArray['limit'] ?? 0;
        $list->offset = $responseArray['offset'] ?? 0;
        $list->count = $responseArray['count'] ?? 0;
        $list->totalCount = $responseArray['totalCount'] ?? 0;
        $list->links = $responseArray['links'] ?? [];

        $list->items = [];

        foreach ($responseArray['items'] as $item) {
            $responseObject = new Objects\Messages\Message();

            foreach ($item as $key => $value) {
                $responseObject->$key = $value;
            }

            $list->items[] = $responseObject;
        }

        return $list;
    }


    /**
     * @param string $id
     * @param array $params
     * @return BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchGroups(string $id, array $params = []): BaseList
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$id/groups?" . http_build_query($params)
        );

        $responseArray = json_decode($response->getBody(), true);

        $list = new BaseList();
        $list->limit = $responseArray['limit'] ?? 0;
        $list->offset = $responseArray['offset'] ?? 0;
        $list->count = $responseArray['count'] ?? 0;
        $list->totalCount = $responseArray['totalCount'] ?? 0;
        $list->links = $responseArray['links'] ?? [];

        $list->items = [];

        foreach ($responseArray['items'] as $item) {
            $responseObject = new Objects\Group();

            foreach ($item as $key => $value) {
                $responseObject->$key = $value;
            }

            $list->items[] = $responseObject;
        }

        return $list;
    }
}
