<?php
namespace Zing\Component\SimpleStoreBundle\Entity;

class ProductCart
{
    private $session = null;

    private $products = array();

    public function __construct($session) {
        $this->session = $session;
    }

    public function getTemporaryProducts()
    {
        return $this->products;
    }

    public function setProducts($product_id, $quantity) {
        $this->products[$product_id] = array(
            'quantity'  => $quantity
        );

        return $this;
    }

    public function getProducts()
    {
        $cart = $this->session->get('cart');

        if(!$cart) {return array();}

        return $cart;
    }

    public function getProductById($product_id)
    {
        $products = $this->getProducts();

        if(isset($products[$product_id])) {
            return array($product_id => $products[$product_id]);
        }

        return array();
    }

    public function persist(ProductCart $product)
    {
        $this->session->set('cart', $product->getTemporaryProducts());
    }

    public function merge(ProductCart $product)
    {
        $this->session->set('cart', $product->getTemporaryProducts() + $this->getProducts());
    }

    public function remove($product)
    {

        /** If an array is given and its not empty */
        if(is_array($product) && count($product) > 0) {

            /** Get all products */
            $cart = $this->getProducts();

            /** Loop in requested products */
            foreach($product as $product_id => $v) {

                /** If the requested products exists in the cart */
                if(isset($cart[$product_id])) {
                    unset($cart[$product_id]);
                }
            }

            /** Save the new cart */
            $this->session->set('cart', $cart);
            return true;
        }

        /** If an object is given */
        if(is_object($product)) {

           /** If the object class name is same as the current class */
           if(get_class($product) == __CLASS__) {

               /** Clear the temporary store products */
               $product->products = array();

               /** Clear the user cart */
               $this->session->remove('cart');
               return true;
           }
        }

        /** If incorrect request is given */
        return false;
    }

}
