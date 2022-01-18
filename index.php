<?php

require_once ('User.php');
require_once ('Product.php');
require_once ('Repository.php');

function print_data($data) {
    echo '<pre>'; var_dump($data);
    echo '</pre> </br>';
    echo "----------------------------------------------------</br>";
}

$repo = new Repository();
$fileName = 'example.json';
$user = new User();

$users = $repo->getList($fileName, $user);
echo "----------------------------------------------------</br>";
echo "просто юзеры </br>";
print_data($users);

$user_1 = $repo->getById($fileName, $user, 1);
$user_1->setData('qwewqe', 123);


$repo->save($fileName, $user_1);

$user_new = new User();
$user_new->setData(['name' => 'Yanis', 'sec_n' => 'Yeltsyn']);
$user_new->telephone = 'NETU!';
print_data($user_new);
$repo->save($fileName, $user_new);

$users = $repo->getList($fileName, $user);
echo "добавили юзера </br>";
print_data($users);

$product = new Product();
$product->setData(['name'=> '123', 'sku'=>'321']);
$repo->save($fileName, $product);


$products = $repo->getList($fileName, $product);
echo "добавили продукт </br>";
print_data($products);

$repo->delete($fileName, $user_new);
echo "удалили юзера </br>";
$users = $repo->getList($fileName, $user);
print_data($users);

$repo->delete($fileName, $product);
echo "удалили продукт </br>";
$products = $repo->getList($fileName, $product);
print_data($products);