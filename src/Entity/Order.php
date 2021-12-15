<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ApiResource(
 *      normalizationContext={"groups"={"order:read"}},
 *      denormalizationContext={"groups"={"order:write"}},
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    
    // const RECEIVED_ORDER ="received";
    // const PROCESSING_ORDER ="processing";
    // const CANCELED_ORDER ="canceled";
    // const READY_SHIPPING_ORDER ="ready to shipping";
    // const SHIPPED_ORDER ="shipped";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"order:read", "order:write"})
     */
    private $total;

    /**
     * @ORM\Column(type="float")
     * @Groups({"order:read", "order:write"})
     */
    private $discount;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"order:read", "order:write"})
     */
    private $items;

    /**
     * @ORM\Column(type="text")
     * @Groups({"order:read", "order:write"})
     */
    private $shippingDetails;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $state;

    /**
     * @ORM\OneToMany(targetEntity=LoggerOrder::class, mappedBy="orderToLog")
     */
    private $loggerOrders;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order:read", "order:write", "state:read"})
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

   

    // /**
    //  * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // private $user;

    public function __construct()
    {
        $this->loggerOrders = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getItems(): ?int
    {
        return $this->items;
    }

    public function setItems(int $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getShippingDetails(): ?string
    {
        return $this->shippingDetails;
    }

    public function setShippingDetails(string $shippingDetails): self
    {
        $this->shippingDetails = $shippingDetails;

        return $this;
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

    /**
     * @return Collection|LoggerOrder[]
     */
    public function getLoggerOrders(): Collection
    {
        return $this->loggerOrders;
    }

    public function addLoggerOrder(LoggerOrder $loggerOrder): self
    {
        if (!$this->loggerOrders->contains($loggerOrder)) {
            $this->loggerOrders[] = $loggerOrder;
            $loggerOrder->setOrderToLog($this);
        }

        return $this;
    }

    public function removeLoggerOrder(LoggerOrder $loggerOrder): self
    {
        if ($this->loggerOrders->removeElement($loggerOrder)) {
            // set the owning side to null (unless already changed)
            if ($loggerOrder->getOrderToLog() === $this) {
                $loggerOrder->setOrderToLog(null);
            }
        }

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

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function __toString():string
    {
        return $this->id;
    }
}
