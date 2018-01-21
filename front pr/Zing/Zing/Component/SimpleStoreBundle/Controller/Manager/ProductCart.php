<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\ProductCart as Entity;
use Zing\Core\CoreBundle\Plugin\CryptIT;

/** SimpleStore product crud manager */
class ProductCart extends CoreManager
{
    private $session;
    /** @var object $repository SimpleStore product cart repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */

    protected $mapper = array(
        'zing_menu_name' => array(
            'label'       => 'Quantity',
            'validation'  => '0-9',
            'not_blank'   => true
        )
    );

    public function __construct($session, $service_container)
    {
        $this->session      = $session;
        $this->repository   = $this->_entity();
        $this->container = $service_container;
    }

    public function getCurrency()
    {
        // if (count($this->requestService('zing.component.simplestore.product')->getAllProducts()) > 0) {
        //     return $this->requestService('zing.component.simplestore.product')->getAllProducts()[0]->getCurrency();
        // }

        return 'лв.';
    }

    public function getTotalPrice($custom_cart = array())
    {
        $cart = $this->getCart();
        
        if(count($custom_cart) > 0) {
            $cart = $custom_cart;
        }

        if(!count($cart) > 0) {return 0.00;}

        $total_price = 0.00 + $this->getShipping();
        foreach($cart as $product_id => $specification) {
            $product = $this->requestService('zing.component.simplestore.product')->getProduct($product_id);
            $total_price = $total_price + ($product->calculatePrice() * $specification['quantity']);
        }

        return $total_price;
    }

    public function getShipping()
    {
        return 5;
    }

    /** Get current step on checkout */
    public function getCurrentCheckoutStep()
    {
        if($this->session->get('step')) {
            return (int)$this->session->get('step');
        }
        return 0;
    }

    public function handleRequest()
    {
        /** Clear checkout errors */
        $this->session->remove('checkout_errors');

        $request = $this->postZingRequest();
        $get_request = $this->getGetRequestInArray();

        if(isset($get_request['forcecart'])) {
            $this->session->remove('step');
            $this->zingRedirect('/store/checkout');exit;
        }

        if(isset($request['bkwstep'])) {
            if($this->session->get('step')) {
                if($this->session->get('step') > 1) {
                    $this->session->set('step', $this->session->get('step') - 1);
                } else {
                    $this->session->remove('step');
                }
            }
        }

        if(isset($request['product']) && isset($request['quantity'])) {
                $this->addProduct((int)$request['product'], (int)$request['quantity']);
                $this->zingRedirect('/store/checkout');
                return true;
        }
        elseif(isset($_GET['product']) && isset($_GET['remove'])) {
                $this->removeProduct((int)$_GET['product']);
                $this->zingRedirect('/store/checkout');
                return true;
        }
        elseif(isset($_GET['remove'])) {
                $this->clearCart($this->repository);
                $this->zingRedirect('/store/checkout');
                return true;
        }
        elseif(isset($request['checkout'])) {
            if(isset($request['checkout']['step_one']) && isset($request['item_quantity'])) {
                $products = array();

                foreach($this->getCart() as $product_id => $specification) {
                    if(isset($request['item_quantity'][$product_id])) {
                        $products[(int)$product_id] = array('quantity' => (int)$request['item_quantity'][$product_id]);

                        /** Update the current cart */
                        $this->addProduct((int)$product_id, (int)$request['item_quantity'][$product_id]);
                    }
                }

                /** Set calculations */
                $this->setCalculate($this->getCart());

                /** Set current step to be 1 */
                $this->session->set('step', 1);
                return true;
            }
            elseif(isset($request['checkout']['step_two'])) {

                /** Check if current checkout step is 1 (if we are coming from step 1) */
                if($this->getCurrentCheckoutStep() != 1) {
                    $this->resetCheckout();
                    return false;
                }

                $response            = $this->validateCheckoutUserData($request);
                $errors              = $response['errors'];
                $user_data_collector = $response['user_data_collector'];

                $this->session->set('checkout_user_inputed_data', $request);

                /** If errors occurred */
                if(count($errors) > 0) {
                    $this->setErrorsFromStepOne($errors);
                    return $errors;
                }

                $this->session->set('checkout_user', $user_data_collector);
                $this->session->set('step', 2);
                return true;
            } elseif(isset($request['checkout']['step_three'])) {

                /** Check if current checkout step is 1 (if we are coming from step 2) */
                if($this->getCurrentCheckoutStep() != 2) {
                    $this->resetCheckout();
                    return false;
                }

                $response            = $this->validateCheckoutUserData($this->session->get('checkout_user'));
                $errors              = $response['errors'];
                $user_data_collector = $response['user_data_collector'];

                /** If errors occurred */
                if(count($errors) > 0) {
                    $this->resetCheckout();
                    return false;
                }

                $user = null;

                if((int)$user_data_collector['user_type'] == 2) {
                    $user = $this->getCurrentUser();

                    /** If user is not found redirect to login form */
                    if($user == null) {
                        $crypt_it = new CryptIT();
                        $this->zingRedirect('/login?r='.$crypt_it->encryptUrl('store/checkout'));exit;
                    }
                }

                $user_data_collector['af'] = $this->getFromCookie();

                $order_id = $this->requestService('zing.component.simplestore.product_order')->setProductOrder(
                    array(
                        'user'                  => $user,
                        'user_checkout_cart'    => json_encode($this->getCart()),
                        'user_data'             => json_encode($user_data_collector, JSON_UNESCAPED_UNICODE),
                        'user_order_calculation'=> json_encode($this->getCalculations())
                    )
                );

                $this->zing_mail(
                    $user_data_collector['user_email'],
                    'Успешна поръчка с номер '.$order_id.' в '.$this->currentHttpHost(),
                    array(
                        'domein'    => $this->currentProtocol().'://'.$this->currentHttpHost(),
                        'order' => $this->requestService('zing.component.simplestore.product_order')->getProductOrder($order_id)),
                     'ZingComponentSimpleStoreBundle:Default/mail:checkout_mail.html.twig'
                );

                $this->session->set('step', 3);
                return true;
            }
        }

        return true;
    }

    public function setCalculate($cart)
    {
        $calculate = array();
        $total_price = 0;
        foreach($cart as $product_id => $specification) {
            $product = $this->requestService('zing.component.simplestore.product')->getProduct($product_id);
            $item_total_price = $product->calculatePrice() * $specification['quantity'];
            $calculate['items'][$product_id] = array(
                'item_price'            => round($product->calculatePrice(), 2),
                'item_total_price'      => round($item_total_price, 2),
                'item_quantity'         => (int)$specification['quantity']
            );

            $total_price = $total_price +  $item_total_price;
            $calculate['total_price'] = $total_price;
        }
        $calculate['total_price'] = round($calculate['total_price'] + $this->getShipping(), 2);

        $this->session->set('calculations', $calculate);
        return $calculate;
    }


    public function getCalculations()
    {
        if(!$this->session->get('calculations')) {
            return array();
        }
        return $this->session->get('calculations');
    }

    public function resetCalculations()
    {
        return $this->session->remove('calculations');
    }

    public function setErrorsFromStepOne($errors)
    {
        $this->session->set('checkout_errors', $errors);
        return true;
    }

    public function getErrorsFromStepOne()
    {
        $errors = $this->session->get('checkout_errors');
        $this->session->remove('checkout_errors');
        return $errors;
    }

    public function getUserInputedDataFromStepOne()
    {
        $data = $this->session->get('checkout_user_inputed_data');
        $this->session->remove('checkout_user_inputed_data');
        return $data;
    }


    public function getCurrentUser()
    {
        if(is_object($this->requestService('security.context')->getToken()->getUser())) {
            return $this->requestService('security.context')->getToken()->getUser();
        }

        return null;
    }

    public function validateCheckoutUserData($request)
    {
        $user_data_fields = array(
            'user_type' => '0-9',
            'user_name' => 'а-яА-Яa-zA-Z0-9_\-\s',
            'user_country' => 'а-яА-Яa-zA-Z0-9_\-\s',
            'user_region' => 'а-яА-Яa-zA-Z0-9_\-\s',
            'user_city' => 'а-яА-Яa-zA-Z0-9_\-\s\'',
            'user_sub_city' => 'а-яА-Яa-zA-Z0-9_\-\s',
            'user_street' => 'а-яА-Яa-zA-Z0-9_\-\s\'\,\.\№\/\()',
            'user_street_num' => 'а-яА-Яa-zA-Z0-9_\-\s',
            'user_email' => false,
            'user_phone' => 'а-яА-Яa-zA-Z0-9\+_\-\s'
        );

        $user_data_collector = array();
        $errors = array();
        foreach($user_data_fields as $field => $regex_validation) {
            if(!isset($request[$field])) {
                $errors[$field] = $this->translate('validation_empty_field', array($this->translate(strtolower(str_replace('user_', ' ', $field)))));
                continue;
            }

            if(empty($request[$field])) {
                $errors[$field] = $this->translate('validation_empty_field', array($this->translate(strtolower(str_replace('user_', ' ', $field)))));
                continue;
            }

            if($field == 'user_email') {
                /** User email match */
                if(!preg_match('/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/', $request[$field])) {
                    $errors['user_email'] = $this->translate('validation_incorrect_field', array($this->translate('User email')));
                    continue;
                }
            }

           if($regex_validation != false) {
            if(preg_match('/[^'.$regex_validation.']/ui', $request[$field])) {
                $errors[$field] = $this->translate('validation_incorrect_field', array($this->translate(strtolower(str_replace('user_', ' ', $field)))));
                continue;
            }
           }

            $user_data_collector[$field] = htmlspecialchars($request[$field]);
        }

        return array('errors' => $errors, 'user_data_collector' => $user_data_collector);
    }

    public function resetCheckout()
    {
        $this->clearCart($this->repository);
        $this->session->remove('checkout_user');
        $this->session->remove('step');
        $this->session->remove('checkout_errors');
        $this->resetCalculations();
        return;
    }

    public function getCheckoutUserData()
    {
        if($this->session->get('checkout_user')) {
            return $this->session->get('checkout_user');
        }

        return array();
    }

    public function getCart()
    {
        $cart = $this->repository->getProducts();

        foreach($cart as $product_id => $q) {
            $cart[(int)$product_id] = array('quantity' => (int)$q['quantity']);
        }

        return $cart;
    }

    public function addProduct($product_id, $quantity)
    {

        /** Clear the checkout steps */
        $this->session->remove('step');

        $this->repository->merge(
            $this->repository->setProducts((int)$product_id, (int)$quantity)
        );
    }

    public function clearCart()
    {
        /** Clear the checkout steps */
        $this->session->remove('step');

        return $this->repository->remove($this->repository);
    }

    public function removeProduct($product_id)
    {
        /** Clear the checkout steps */
        $this->session->remove('step');

        return $this->repository->remove(
            $this->repository->getProductById((int)$product_id)
        );
    }

    private function _entity()
    {
        return new Entity($this->session);
    }

}