<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\BaseList;

/**
 * Class Groups
 *
 * @package MessageBird\Resources
 */
class Groups extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'groups');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Group::class;
    }

    /**
     * @param Objects\Arrayable $params
     * @param string $id
     * @return Objects\Group|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function update(Objects\Arrayable $params, string $id): Objects\Group
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
    public function fetchContacts(string $id, array $params = []): BaseList
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$id/contacts?" . http_build_query($params)
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
            $responseObject = new Objects\Contact();

            foreach ($item as $key => $value) {
                $responseObject->$key = $value;
            }

            $list->items[] = $responseObject;
        }

        return $list;
    }

    /**
     * @param string $id
     * @param array $contacts
     * @return Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function addContacts(string $id, array $contacts): Objects\Base
    {
        if (empty($contacts) === true) {
            throw new InvalidArgumentException('The ID of the contacts required');
        }

        $response = $this->httpClient->request(
            HttpClient::REQUEST_PUT,
            "{$this->getResourceName()}/$id/contacts",
            ['body' => ["ids" => $contacts]]
        );

        return $this->handleDeleteResponse($response);
    }

    /**
     * @param string $groupId
     * @param string $contactId
     * @return Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function removeContact(string $groupId, string $contactId): Objects\Base
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_DELETE,
            "{$this->getResourceName()}/$groupId/contacts/$contactId"
        );

        return $this->handleDeleteResponse($response);
    }
}
