<?php

namespace Zing\Core\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Zing\Core\CoreBundle\Plugin\Generator;
use Doctrine\Common\Util\Debug;

class CoreController extends Controller
{

    /** First we call the project name then type of bundle then the bundle name and the service we want to get. */
    private $language_service = 'zing.components.language.picker';
    private $translator = null;


    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->containerInitialized();
    }

    private function containerInitialized()
    {
        if(!$this->myLocale()) {
            $this->modifyLocale($this->requestService('zing.core.setting.setting')->bundle('SettingBundle')['zing_setting_default_language']);
        }
    }

    protected function setFromCookie()
    {
        if(isset($_GET['af']) && !in_array($_GET['af'], $this->getFromCookie())) {
            setcookie('af', json_encode(array_merge($this->getFromCookie(), array($_GET['af'])), JSON_UNESCAPED_UNICODE), time()+(60*60*24*30), "/");
        }

        return true;
    }

    protected function getFromCookie()
    {
        if(isset($_COOKIE['af'])) {
            return json_decode($_COOKIE['af'], true);
        }

        return array();
    }

    protected function defaultRender($template, $data = array())
    {
        $this->setFromCookie();

        $default_data = array(
            'zing_verify_code' => $this->_generateZingFormVerificationCode(),
            'uri' => $this->currentUri(),
            'path' => $this->currentPath()
        );

       return $this->render($template, array_merge($default_data, $data));
    }

    protected function getPostRequest()
    {
        return new Request($_POST);
    }

    protected function getGetRequest()
    {
        return new Request($_GET);
    }

    protected function getGetRequestInArray()
    {
        return $_GET;
    }

    protected function getCookie()
    {
        return new Request($_COOKIE);
    }

    /** Get post data from zing forms. If a from has a field zing_verify_code, that form will be procceed with postZingRequest()
     * @return array() Zing post form request
     * @throws Exception If the zing form verification code is not correct
     */
    protected function postZingRequest()
    {
        $request = $this->getPostRequest();

        /** If the form is not submitted or the form is not a zing form */
        if (!$request->get('zing_verify_code')) {
            return array();
        }

        if(!$this->_zingFormVerification($request)) {
            throw new Exception('Zing verify form code error');
        }

        $post_data = $this->container->get('request')->request->all();

        /** Remove the verification code, it is no more need it */
        unset($post_data['zing_verify_code']);

        return $post_data;
    }

    /** TODO: getZingRequest */

    /** Check submitted verification code
     * @param object $request Symfony2 request object
     * @return bool
     */
    private function _zingFormVerification($request)
    {

        if(!$this->container->get('session')->get('_zing_verify_code') ||
           !is_array($this->container->get('session')->get('_zing_verify_code'))
        ) {
            return false;
        }

        $status = false;
        $verification_codes = $this->container->get('session')->get('_zing_verify_code');

        foreach($verification_codes as $k => $code) {
            if($code == $request->get('zing_verify_code')) {
                unset($verification_codes[$k]);
                $status = true;
            }
        }

        $this->container->get('session')->set('_zing_verify_code', $verification_codes);
        return $status;
    }

    private function _generateZingFormVerificationCode()
    {
        $generator = new Generator();
        $unique_string = $generator->uniqueString();

        $verification_codes = array();

        if($this->container->get('session')->get('_zing_verify_code') &&
           is_array($this->container->get('session')->get('_zing_verify_code'))
        ) {
            $verification_codes = $this->container->get('session')->get('_zing_verify_code');
        }

        array_push($verification_codes, $unique_string);

        $this->container->get('session')->set('_zing_verify_code', $verification_codes);

        return $unique_string;
    }

    protected function isServiceAvailable($service_name) {
        /** Check service existing */
        if(!$this->container->has($service_name)) {
            return false;
        }
        return true;
    }


    /** Request a service if exists
     * @param string $service_name. The name of the service
     * @return mixed. Return service if exists else return boolen false
     */
    protected function requestService($service_name)
    {
        try {
            /** Check service existing */
            if(!$this->container->has($service_name)) {
                throw new Exception('You have requested a non-existent service "'.$service_name. '"');
            }
            return $this->container->get($service_name);
        } catch (Exception $e) {
            /** Save to log file */
            return false;
        }
    }

    /** Get default language.
     * @return array. Array of the default language options. (language => value, language_name => value) */
    protected function defaultLanguage()
    {

        if(!$this->requestService($this->language_service)) {
            return $this->container->getParameter('zing_settings')['language'];
        }

        return $this->requestService($this->language_service)->getDefaultLanguage();
    }

    /** Get active languages
     * @return array. Array of active languages. (key => (language => value, language_name => value))
     */
    protected function activeLanguages()
    {

        if(!$this->requestService($this->language_service)) {
            return array($this->defaultLanguage());
        }

        return $this->requestService($this->language_service)->getActiveLanguages();
    }

    protected function currentProtocolHttpHost()
    {
        return $this->currentProtocol().'://'.$this->currentHttpHost();
    }

    protected function currentProtocol()
    {
        $settings = $this->container->get('zing.core.setting.setting')->bundle('SettingBundle');
        if(isset($settings['zing_setting_domain_protocol'])) {
            if(strlen($settings['zing_setting_domain_protocol']) > 0) {
                return $settings['zing_setting_domain_protocol'];
            }
        }

        return $this->container->get('request')->getScheme();
    }

    protected function currentHttpHost()
    {
        $settings = $this->container->get('zing.core.setting.setting')->bundle('SettingBundle');
        if(isset($settings['zing_setting_domain'])) {
            if(strlen($settings['zing_setting_domain']) > 0) {
                return $settings['zing_setting_domain'];
            }
        }

        return $this->container->get('request')->getHttpHost();
    }

    protected function currentUri()
    {
        return $this->container->get('request')->getUri();
    }

    protected function currentPath()
    {
        return $this->container->get('request')->getPathInfo();
    }

    protected function getTranslationFile($locale)
    {
        return $this->container->get('kernel')->getRootDir().DS.'Resources'.DS.'translations'.DS.'zing.'.$locale.'.json';
    }

    protected function modifyLocale($locale = 'en', $redirect = true)
    {
        $old_locale = $this->myLocale();
        $this->container->get('session')->set('_locale', $locale);

        if($old_locale != $this->myLocale() && $redirect == true) {
           header('Location: '.$this->currentPath());exit;
        }

        if($this->myLocale() != $locale) {
            return false;
        }
        return true;
    }

    public function myLocale()
    {
        if(!$this->container->get('session')->get('_locale')) {
            return $this->defaultLanguage()['language'];
        }

        return $this->container->get('session')->get('_locale');
    }

    protected function translate($string = null, $replaced_word = array())
    {
        if($string == null || !strlen($string) > 0) {
            return $string;
        }

        return vsprintf($this->translator()->trans($string), $replaced_word);
    }

    protected function rollBackDefaultLocale()
    {
        return $this->modifyLocale($this->container->getParameter('locale'), false);
    }

    protected  function translator()
    {
        if($this->translator == null) {

            if(!file_exists($this->getTranslationFile($this->myLocale()))) {
               $this->rollBackDefaultLocale();
            }

            $translator = new Translator($this->myLocale());
            $translator->setLocale($this->myLocale());
            $translator->addLoader('json', new JsonFileLoader());
            $translator->addResource('json', $this->getTranslationFile($this->myLocale()), $this->myLocale());

            $this->translator = $translator;
        }

        return $this->translator;
    }

    protected function regexMatch($regex, $value)
    {
        if(preg_match('/[^'.$regex.']/ui', $value)) {
            return false;
        }
        return true;
    }

    protected function zingRedirect($path) {
        header('Location: '.$path);exit;
    }

    /** Usage
     * $this->debug($this->zing_mail(
     *       'example@email.dd',
     *       'Subject',
     *       array('Data for template'),
     *       'ZingCoreCoreBundle:Default/Mail:default_template.html.twig', true
     *   ));
     */
    public function zing_mail($to, $subject, $data, $template, $debug = false)
    {
        $settings = $this->requestService('zing.core.setting.setting');
        $last_build = $settings->bundle('SettingBundle');

        $smtp = array();
        $smtp['email'] = $last_build['zing_setting_email'];
        $smtp['host'] = $last_build['zing_setting_smtp_host'];
        $smtp['user'] = $last_build['zing_setting_smtp_user'];
        $smtp['password'] = $last_build['zing_setting_smtp_password'];
        $smtp['port'] = $last_build['zing_setting_smtp_port'];
        $smtp['encryption'] = $last_build['zing_setting_smtp_encryption'];
        $smtp['auth_mode'] = $last_build['zing_setting_smtp_auth_mode'];

        try {
            $transport = new \Swift_SmtpTransport();
            $transport  ->setHost($smtp['host'])
                        ->setUsername($smtp['user'])
                        ->setPassword($smtp['password'])
                        ->setPort($smtp['port'])
                        ->setEncryption($smtp['encryption'])
                        ->setAuthMode($smtp['auth_mode']);

            $message = \Swift_Message::newInstance();
            $message->setSubject($subject)
                    ->setFrom($smtp['email'])
                    ->setTo($to)
                    ->setBody($this->renderView($template, $data))
                    ->setContentType("text/html");

            $mailer = new \Swift_Mailer($transport);

            $mailer->send($message);
        } catch(\Exception $e) {

            if($debug) {throw new \Exception($e->getMessage());}

            return false;
        }

        return true;
    }

    /** var_dump */
    public function dump($data)
    {
        echo '<pre style="overflow: auto; position: relative; z-index: 99999; width: 100%; background-color: #fff;">';
        var_dump($data);
        echo '</pre>';
    }

    /** Doctrine dump */
    public function debug($data)
    {
        echo '<pre style="overflow: auto; position: relative; z-index: 99999; width: 100%; background-color: #fff;">';
        $this->dump(Debug::dump($data, 3));
        echo '</pre>';
    }


}