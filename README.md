# Type Collection


### Usage StringCollection and IntegerCollection


```php
(new IntegerCollection([1, 2, 3]))
->filter(function(int $item) {
    return $item > 2;
})->map(function(int $item) {
    return (string)$item;
});
```

### Usage InstanceCollection

```php
use Collection\InstanceCollection;
use Collection\Tests\Stub\Customer;

final class CustomerCollection extends InstanceCollection
{
    protected function getType(): string
    {
        return Customer::class;
    }

    public function offsetGet($key): ?Customer
    {
        return $this->getItem($key);
    }

    public function add(Customer $item, $key): void
    {
        $this->addItem($item, $key);
    }

}

$items = [
    new Customer(1, 'first'),
    new Customer(2, 'two'),
];

$collection = new CustomerCollection($items);
$collection->add(new Customer(3, 'three'), 3);

$collection->filter(static function(Customer $item) {
    return $item->getId() !== 1;
})->toArray();

```
