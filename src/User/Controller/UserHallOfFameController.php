<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\User\Controller;

use Ares\Framework\Mapping\Annotation as AR;
use Ares\Framework\Controller\BaseController;
use Ares\Framework\Exception\DataObjectManagerException;
use Ares\User\Repository\UserCurrencyRepository;
use Ares\User\Repository\UserRepository;
use Ares\User\Repository\UserSettingRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class UserHallOfFameController
 *
 * @AR\Router
 * @AR\Group(
 *     prefix="hall-of-fame",
 *     pattern="hall-of-fame",
 * )
 *
 * @package Ares\User\Controller
 */
class UserHallOfFameController extends BaseController
{
    /**
     * UserHallOfFameController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserSettingRepository  $userSettingRepository
     * @param UserCurrencyRepository $userCurrencyRepository
     */
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserSettingRepository $userSettingRepository,
        private readonly UserCurrencyRepository $userCurrencyRepository
    ) {}

    /**
     * @AR\Route(
     *     methods={"GET"},
     *     pattern="/top-users"
     * )
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     * @throws DataObjectManagerException
     */
    public function topUsers(Request $request, Response $response): Response
    {
        $topUsers = [
            //'credits'       => $this->userRepository->getTopCredits(),
            'diamonds'      => $this->userCurrencyRepository->getTopDiamonds(),
            'duckets'       => $this->userCurrencyRepository->getTopDuckets(),
            'achievements'  => $this->userCurrencyRepository->getTopDuckets(),
            'online'        => $this->userSettingRepository->getTopOnlineTime()
        ];

        return $this->respond(
            $response,
            response()
                ->setData($topUsers)
        );
    }
}
