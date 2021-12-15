<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LoggerOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LoggerOrderRepository::class)
 */
class LoggerOrder
{
    

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $state;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="loggerOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderToLog;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loggerOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

  



   



    public function __construct(){
        $this->createdAt = new \DateTimeImmutable();
        $this->loggerOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getState(): ?string
    // {
    //     return $this->state;
    // }

    // public function setState(string $state): self
    // {
    //     $allStates = [self::RECEIVED_ORDER, self::CANCELED_ORDER, self::PROCESSING_ORDER, self::READY_SHIPPING_ORDER, self::SHIPPED_ORDER];
    //     Assert::true(in_array($state, $allStates));
    //     $this->state = $state;

    //     return $this;
    // }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

   

    public function getOrderToLog(): ?Order
    {
        return $this->orderToLog;
    }

    public function setOrderToLog(?Order $orderToLog): self
    {
        $this->orderToLog = $orderToLog;

        return $this;
    }

    // public function getUser(): ?User
    // {
    //     return $this->user;
    // }

    // public function setUser(?User $user): self
    // {
    //     $this->user = $user;

    //     return $this;
    // }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   

   

    
}
