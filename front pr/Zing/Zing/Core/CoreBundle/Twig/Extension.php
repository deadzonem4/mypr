<?php
namespace Zing\Core\CoreBundle\Twig;

use Symfony\Component\HttpKernel\KernelInterface;

class Extension extends \Twig_Extension
{

    private $kernel;
    private $layout_manager;

    public function __construct(KernelInterface $kernel, $layout_manager)
    {
        $this->kernel = $kernel;
        $this->layout_manager = $layout_manager;
    }


    public function getFunctions()
    {
        return array(
            'productHasRate' => new \Twig_Function_Method($this, 'productHasRate'),
            'myLocale' => new \Twig_Function_Method($this, 'myLocale'),
            'zing_debug' => new \Twig_Function_Method($this, 'zing_debug'),
            'request_service' => new \Twig_Function_Method($this, 'request_service'),
            'has_service' => new \Twig_Function_Method($this, 'has_service'),
            'file_exists_in_web' => new \Twig_Function_Method($this, 'file_exists_in_web'),
            'file_exists' => new \Twig_Function_Method($this, 'file_exists'),
            'to_string' => new \Twig_Function_Method($this, 'toString'),
        );
    }

    public function productHasRate($product_id) {
        return $this->request_service('zing.component.simplestore.product')->hasRate($product_id);
    }

    public function myLocale() {
        return $this->request_service('zing.core.page.block')->myLocale();
    }

    public function zing_debug($data)
    {
        return $this->request_service('zing.core.page.block')->debug($data);
    }

    public function toString($data) {
        if(is_array($data)) {
            return '';
        }
        return $data;
    }

    public function has_service($service_name)
    {
        /** Check service existing */
        if(!$this->layout_manager->has($service_name)) {
            return false;
        }

        return true;
    }

    public function request_service($service_name)
    {
        try {
            /** Check service existing */
            if(!$this->layout_manager->has($service_name)) {
                throw new \Exception('You have requested a non-existent service "'.$service_name. '"');
            }
            return $this->layout_manager->get($service_name);
        } catch (\Exception $e) {
            /** Save to log file */
            return false;
        }
    }

    public function file_exists_in_web($path) {
        if(!file_exists(WEB_DIR.$path)) {
            return false;
        }
        if(!is_file(WEB_DIR.$path)) {
            return false;
        }
        return true;
    }

    public function file_exists($path) {
        if(!file_exists($path)) {
            return false;
        }
        if(!is_file($path)) {
            return false;
        }
        return true;
    }

    public function getName()
    {
        return 'file_exists';
    }

} 