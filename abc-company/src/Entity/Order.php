<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`orders`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

   
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $shippingDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $productId;

    // Getter ve setter metotları...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderCode(): ?string
    {
        return $this->orderCode;
    }

    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getShippingDate(): ?\DateTimeInterface
    {
        return $this->shippingDate;
    }

    public function setShippingDate(\DateTimeInterface $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function getUser(): array
    {
        $user = $this->user;
        if ($user instanceof User) {
            return [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ];
        }

        return [];
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   

    public function getProduct(): array
    {
        $product = $this->productId;
        if ($product instanceof Product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
            ];
        }

        return [];
    }

    

    public function setProduct(?Product $product): self
    {
        $this->productId = $product;

        return $this;
    }
   
    
}