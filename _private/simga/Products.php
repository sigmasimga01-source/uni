<?php
class Products
{
    private ?int $id;
    private string $name;
    private string $size;
    private string $barcode;
 
    public function __construct(?int $id, string $name, string $size, string $barcode)
    {
        $this->name = $name;
        $this->size = $size;
        $this->barcode = $barcode;
        $this->id = $id;
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getName(): string
    {
        return $this->name;
    }
 
    public function getSize(): string
    {
        return $this->size;
    }
 
    public function getBarcode(): string
    {
        return $this->barcode;
    }
 
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
 
    public function setName(string $name): void
    {
        $this->name = $name;
    }
 
    public function setSize(string $size): void
    {
        $this->size = $size;
    }
 
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }
}
?>