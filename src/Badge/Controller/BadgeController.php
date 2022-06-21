<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Badge\Controller;

use Ares\Badge\Service\BadgeAlbumService;
use Ares\Framework\Controller\BaseController;
use Ares\Framework\Exception\NoSuchEntityException;
use Ares\Framework\Mapping\Annotation as AR;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BadgeController
 *
 * @AR\Router
 * @AR\Group(
 *     prefix="badges",
 *     pattern="badges",
 * )
 *
 * @package Ares\Badge\Controller
 */
class BadgeController extends BaseController
{
    /**
     * BadgeController constructor.
     *
     * @param BadgeAlbumService    $badgeAlbumService
     */
    public function __construct(
        private readonly BadgeAlbumService    $badgeAlbumService
    ) {}

    /**
     * @AR\Route(
     *     methods={"GET"},
     *     placeholders={"rpp": "[0-9]+"},
     *     pattern="/list/{rpp}"
     * )
     *
     * @param Request $request
     * @param Response $response
     *
     * @param array $args
     *
     * @return Response
     * @throws NoSuchEntityException
     */
    public function list(Request $request, Response $response, array $args): Response
    {
        $rpp = $args['rpp'];

        $badges = $this->badgeAlbumService->execute($rpp);

        return $this->respond(
            $response,
            response()
                ->setData($badges)
        );
    }

}
