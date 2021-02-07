<?php


class CProducts
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProducts($limit = null)
    {
        $count = $this->count();
        $this->db->query('SELECT * FROM products WHERE is_hidden=0 ORDER BY date_create DESC LIMIT :limit');

        if (isset($limit)) {
            $this->db->bind(':limit', $limit);
        }

        if (is_null($limit)) {
            $this->db->bind(':limit', $count);
        }

        return $this->db->resultSet();
    }

    public function increaseProduct($id)
    {
        $this->db->query('UPDATE products SET product_quantity = product_quantity + 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function decreaseProduct($id)
    {
        $this->db->query('UPDATE products SET product_quantity = product_quantity - 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function hideProduct($id)
    {
        $this->db->query('UPDATE products SET is_hidden=1 WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function seedProductsTable($productCount)
    {
        if ($this->count() == 0) {
            $this->db->query('INSERT INTO products(
                     id, 
                     product_id, 
                     product_price,
                     product_quantity,
                     product_name, 
                     product_article, 
                     date_create
                     ) VALUES (
                             DEFAULT, 
                             :product_id,
                             :product_price,
                             :product_quantity,
                             :product_name,
                             :product_article,
                             :date_create
                             )'
            );

            for ($i = 0; $i < $productCount; $i++) {
                $this->db->bind(':product_id', rand(1, 18));
                $this->db->bind(':product_price', rand(10000, 100000));
                $this->db->bind(':product_quantity', rand(0, 500));
                $this->db->bind(':product_name', $this->data['name'][array_rand($this->data['name'])]);
                $this->db->bind(':product_article', $this->data['article'][array_rand($this->data['article'])]);
                $this->db->bind(':date_create', $this->getRandomDatetime());
                $this->db->execute();
            }
        }
    }

    private function count()
    {
        $this->db->query('SELECT id FROM products');
        $this->db->execute();

        return $this->db->rowCount();
    }

    private function getRandomDatetime()
    {
        $timestamp = mt_rand(1, time());

        return date('Y-m-d H:i:s', $timestamp);
    }

    private $data = [
        'name' => [
            'Corepoint',
            'Goldgreen',
            'Owlsun',
            'Shadedale',
            'Tigerways',
            'Ganzcone',
            'Gnomeshade',
            'Honeyphone',
            'Howstreet',
            'Spidershack',
            'Dwarfmobile',
            'Spikeman',
            'Viavivala',
            'Lionways',
            'Pinkbeat',
            'Yellowpoint',
            'Zoomplanet',
            'Toughflex',
        ],
        'article' => [
            'Songs Of The Jungle',
            'Searching At The Abyss',
            'Temptations Of The Nation',
            'Accepting The Mist',
            'Calling The Town',
            'Traces In The Animals',
            'Challenging My Dreams',
            'Taste Of The Immortals',
            'Welcome To The Hunter',
            'Walking The Emperor',
            'Delaying The Immortals',
            'Screams At The Depths',
            'Eating At The East',
            'Jumping Into The City',
            'Laughing At My Future',
            'Walking My School',
            'Challenging The Swamp',
            'Guarded By The Immortals',
        ],
    ];

}