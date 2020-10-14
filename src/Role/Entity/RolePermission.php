<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Role\Entity;

use Ares\Framework\Entity\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolePermission
 *
 * @package Ares\Role\Entity
 *
 * @ORM\Table(name="ares_roles_permission",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="ares_role_permission_unique",
 *      columns={"role_id", "permission_id"})}
 *     )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class RolePermission extends Entity
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    private int $roleId;

    /**
     * @ORM\Column(name="permission_id", type="integer", nullable=false)
     */
    private int $permissionId;

    /**
     * @ORM\ManyToOne(targetEntity="Ares\Role\Entity\Permission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     * })
     */
    private Permission $permission;

    /**
     * @ORM\ManyToOne(targetEntity="Ares\Role\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private Role $role;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param   int  $id
     *
     * @return RolePermission
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    /**
     * @param   int  $roleId
     *
     * @return RolePermission
     */
    public function setRoleId($roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permissionId;
    }

    /**
     * @param   int  $permissionId
     *
     * @return RolePermission
     */
    public function setPermissionId($permissionId): self
    {
        $this->permissionId = $permissionId;

        return $this;
    }

    /**
     * @return Permission
     */
    public function getPermission(): Permission
    {
        return $this->permission;
    }

    /**
     * @param   Permission  $permission
     *
     * @return RolePermission
     */
    public function setPermission($permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param   Role  $role
     *
     * @return RolePermission
     */
    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param   DateTime  $createdAt
     *
     * @return RolePermission
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     *
     * @throws \Exception
     */
    public function prePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'role_id' => $this->getRole()->getId(),
            'role_name' => $this->getRole()->getName(),
            'permission_id' => $this->getPermission()->getId(),
            'permission_name' => $this->getPermission()->getName(),
            'created_at' => $this->getCreatedAt()
        ];
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize(get_object_vars($this));
    }

    /**
     * @param   string  $data
     */
    public function unserialize($data): void
    {
        $values = unserialize($data);

        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }
}
