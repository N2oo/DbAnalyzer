<?php
namespace App\Entity\ValueObject;

class SearchTableQuery
{
    private ?string $user_query = null;

    /**
     * @var ?string[] $owners
     */
    private ?array $owners = null;

    /**
     * Get the value of owner
     *
     * @return ?string[]
     */
    public function getOwners(): ?array
    {
        return $this->owners;
    }

    /**
     * Set the value of owner
     *
     * @param ?string[] $owners
     *
     * @return self
     */
    public function setOwners(?array $owners): self
    {
        $this->owners = $owners;

        return $this;
    }

    public function addOwner(string $owner):self
    {
        $this->owners[] = $owner;
        return $this;
    }

    /**
     * Get the value of user_query
     *
     * @return string
     */
    public function getUserQuery(): ?string
    {
        return $this->user_query;
    }

    /**
     * Set the value of user_query
     *
     * @param ?string $user_query
     *
     * @return self
     */
    public function setUserQuery(?string $user_query): self
    {
        if(isset($user_query)){
            $this->user_query = trim($user_query);
        }
        return $this;
    }
}