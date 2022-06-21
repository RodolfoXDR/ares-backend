<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Permission\Controller;

use Ares\Framework\Mapping\Annotation as AR;
use Ares\Framework\Controller\BaseController;
use Ares\Framework\Exception\DataObjectManagerException;
use Ares\Permission\Repository\PermissionRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class PermissionController
 *
 * @AR\Router
 * @AR\Group(
 *     prefix="permissions",
 *     pattern="permissions"
 * )
 *
 * @package Ares\Permission\Controller
 */
class PermissionController extends BaseController
{
    /**
     * PermissionController constructor.
     *
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        private readonly PermissionRepository $permissionRepository
    ) {}

    /**
     *  @AR\Route(
     *     methods={"GET"},
     *     pattern="/list"
     * )
     *
     * @param Request     $request
     * @param Response    $response
     *
     * @return Response
     * @throws DataObjectManagerException
     */
    public function listUserWithRank(Request $request, Response $response): Response
    {
        $users = $this->permissionRepository->getListOfUserWithRanks();

        return $this->respond(
            $response,
            response()
                ->setData($users)
        );
    }
}
