<?php
namespace Controller;

use Service\Page as PageService;

/**
 * Class Page
 */
class Page extends Controller {
    private $flyer;

    /**
     * Page constructor
     * @param PageService $service
     * @param string $requestMethod
     * @param bool $flyer
     * @param string $param
     */
    public function __construct(PageService $service, string $requestMethod, 
                                bool $flyer, string $parameter = null) {
        parent::__construct($service, $requestMethod, $parameter);
        $this->flyer = $flyer;
    }

    /**
     * @return array
     */
    public function get(): array {
        if ($this->flyer) {
            $response = $this->service->getAllById($this->parameter);
        } else if ($this->parameter) {
            $response = $this->service->get($this->parameter);
        } else {
            $response = $this->failResponse(404);
        }
        return $response;
    }

    /**
     * @param array $page
     * @return array
     */
    public function validate(array $page): bool
    {
         if (!isset($page['dateValid']) || empty($page['dateValid'])) 
            return false;
        if (!isset($page['dateExpired']) || empty($page['dateExpired'])) 
            return false;
        if (!isset($page['pageNumber']) || empty($page['pageNumber']))
            return false;
        if (!isset($page['flyerId']) || empty($page['flyerId'])) 
            return false;

        return true;
    }

}