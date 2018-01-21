<?php

namespace Zing\Core\CoreBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;
use Zing\Core\CoreBundle\Plugin\CryptIT;

class CoreManager extends CoreController {

    /** @var array $mapper Map form fields for validation */
    protected $mapper = array();
    protected $pagination_per_page = 10;

    /** Validate an request by the mapped fields
     * @param array $request Form submitted request
     * @return array If errors are caught from field validation else empty array
     */
    public function validateRequest($request)
    {
        /** If mapper is not set return an empty array */
        if(!count($this->mapper) > 0) {
            return array();
        }

        $errors = array();

        /** Loop every mapped field */
        foreach($this->mapper as $field => $item) {

            if(!isset($item['label'])) {
                $errors = array_merge($errors, $this->_validateTwoLevel($field, $item, $request));
                continue;
            }

            /** If a mapped field is not submitted, create a validation error */
            if(!isset($request[$field])) {
                $errors[$field] = $this->translate('validation_empty_field', array($this->translate($item['label'])));
            }

            /** Check if field is not blank */
            if(isset($item['not_blank'])) {
                if($item['not_blank'] == true) {
                    if(empty($request[$field])) {
                        $errors[$field] = $this->translate('validation_empty_field', array($this->translate($item['label'])));
                    }
                }
            }

            /** If an error is not set on the current mapped field continue with the next level validation */
            if(!isset($errors[$field])) {
                if($item['validation']) {
                    if(preg_match('/[^'.$item['validation'].']/ui', $request[$field])) {
                        $errors[$field] = $this->translate('validation_incorrect_field', array($this->translate($item['label'])));
                    }
                }
            }
        }

        return $errors;
    }

    private function _validateTwoLevel($last_field, $item_pack, $request)
    {
        $errors = array();
        foreach($item_pack as $field => $item) {
            /** If a mapped field is not submitted, create a validation error */
            if(!isset($request[$last_field][$field])) {
                $errors[$field] = $this->translate('validation_empty_field', array($this->translate($item['label'])));
            }

            /** Check if field is not blank */
            if(isset($item['not_blank'])) {
                if($item['not_blank'] == true) {
                    if(empty($request[$last_field][$field])) {
                        $errors[$field] = $this->translate('validation_empty_field', array($this->translate($item['label'])));
                    }
                }
            }

            /** If an error is not set on the current mapped field continue with the next level validation */
            if(!isset($errors[$field])) {
                if($item['validation']) {
                    if(preg_match('/[^'.$item['validation'].']/ui', $request[$last_field][$field])) {
                        $errors[$field] = $this->translate('validation_incorrect_field', array($this->translate($item['label'])));
                    }
                }
            }
        }
        return $errors;
    }

    /** Handle table action
     * @param array $post_request The table form request
     * @return bool True on succes else false on error
     */
    public function multiplyTableAction($post_request = array())
    {
        if(!count($post_request) > 0) {
            return false;
        }

        if(!isset($post_request['zing_table_multiply'])) {
            return false;
        }

        if(!isset($post_request['zing_table_action'])) {
            return false;
        }

        if(!count($post_request['zing_table_multiply']) > 0) {
            return false;
        }

        /** Loop chosen items */
        foreach($post_request['zing_table_multiply'] as $object_id) {

            /** Cast the object id to integer */
            $object_id = (int)$object_id;

            /** Get object */
            $object = $this->getObjectFromTable((int)$object_id);

            /** If a no object is found continue */
            if($object != null) {

                $object->setDateModified(time());

                if($post_request['zing_table_action'] == 'active') {

                    /** Active a object if is action is set to active */
                    $this->updateObjectFromTable($object->setStatus(1));
                } elseif($post_request['zing_table_action'] == 'unactive') {

                    /** Unactive a object if is action is set to unactive */
                    $this->updateObjectFromTable($object->setStatus(0));
                } elseif($post_request['zing_table_action'] == 'delete') {

                    /** Remove object if is action is set ot delete */
                    $this->removeObjectFromTable($object);
                }
            }
        }

        return true;
    }

    public function filterGetRequest($without = array())
    {
        $request = $this->getGetRequestInArray();
        if(count($without) > 0) {
            foreach($without as $w) {
                if(isset($request[$w])) {
                    unset($request[$w]);
                }
            }
        }

        return $request;
    }

    public function getPaginationOrderFromGet()
    {
        $request = $this->getGetRequestInArray();

        if(isset($request['order'])) {
            return $request['order'];
        }

        return 'promoted'; // was 'newest'
    }

    public function setPaginationPerPageDefault($value)
    {
        $this->pagination_per_page = $value;
    }

    public function getPaginationPerPageFromGet()
    {
        $request = $this->getGetRequestInArray();

        if(isset($request['perpage'])) {
            return (int)$request['perpage'];
        }

        return $this->pagination_per_page;
    }

    public function pagination($per_page = 10, $range = 3)
    {
        $pages = $this->fixPaginationUrl($this->paginate($this->countProducts(), $per_page, $this->getCurrentPage(), $range));

        $offset     = $pages['offset'];
        $limit      = $pages['perpage'];

        unset($pages['offset']);
        unset($pages['perpage']);

        return array(
            'offset'        => $offset,
            'limit'         => $limit,
            'pagination'    => $pages
        );
    }

    public function getPaginationTemplate($pagination, $custom_class = '')
    {
        return $this->container->get('templating')->render('ZingCorePageBundle:Default:Pagination/pagination.html.twig', array(
            'pagination'    => $pagination,
            'custom_class'  => $custom_class
        ));
    }

    /** HBphp
     * Calculate pages.
     *
     * @return Calculated pages.
     */
    protected function paginate($numrows, $perpage, $current_page, $range) {
        /** Collector */
        $data = array();
        /** Calculate pages for result */
        $pages = ceil($numrows / $perpage);
        /** Comes from outside(user input), so must be escaped, gets on what page is the user */
        $current_page = (int) $current_page;
        /** If user had inputed for current page a page that is bigger than total pages,
         * make current page to be the last page.
         */
        if ($current_page > $pages) {
            $current_page = $pages;
        }
        /** If the current page is lower than 1, fixed the current page to be 1 */
        if ($current_page < 1) {
            $current_page = 1;
        } else {
            if ($current_page > 1) {
                /** If the current page is bigger than 1, make previous link */
                $data['pagination_links']['prev'] = $current_page - 1;
            }
        }
        /** Calculate offset */
        $data['offset'] = ($current_page - 1) * $perpage;

        $gx = ($current_page - $range);
        if($gx == 2) {$gx = 3;}

        /** Generate links */
        for ($x = $gx; $x < (($current_page + $range) + 1); $x++) {
            if (($x > 0) && ($x <= $pages)) {
                if ($x == $current_page) {
                    $data['pagination_links']['x'][] = array('link' => $x, 'current' => true);
                } else {
                    $data['pagination_links']['x'][] = array('link' => $x, 'current' => false);
                }
            }
        }
        /** If they are no generated links, set only page 1 and mark it as current page */
        if (!isset($data['pagination_links']['x'])) {
            $data['pagination_links']['x'][] = array('link' => 1, 'current' => true);
        }
        /** Generate last page link */
        $c = count($data['pagination_links']['x']) - 1;
        if ($data['pagination_links']['x'][$c]['link'] != $current_page AND $data['pagination_links']['x'][$c]['link'] < $pages) {
            $data['pagination_links']['last_page'] = $pages;
        }
        /** Generate first page link if we are out of range, so the user can jump to page 1 */
        if ($current_page - $range > 1) {
            $data['pagination_links']['first_page'] = 1;
        }

        /** Generate forward link */
        if ($current_page < $pages) {
            $data['pagination_links']['frw'] = $current_page + 1;
        }
        /** Resend the perpage value with data array */
        $data['perpage'] = $perpage;
        return $data;
    }

    protected function fixPaginationUrl($pages)
    {

        $request = $this->getGetRequestInArray();

        foreach($pages['pagination_links']['x'] as $k => $page) {

            $request = array_merge($request, array('page' => $page['link']));

            $url = array();
            foreach($request as $request_key => $request_value) {
                $url[] = urlencode($request_key).'='.urlencode($request_value);
            }

            $pages['pagination_links']['x'][$k]['extended_link'] = $this->currentPath().'?'.implode('&', $url);
        }

        if(isset($pages['pagination_links']['prev'])) {
            $request = $this->getGetRequestInArray();
            $request = array_merge($request, array('page' => $pages['pagination_links']['prev']));
            $url = array();
            foreach($request as $request_key => $request_value) {
                $url[] = urlencode($request_key).'='.urlencode($request_value);
            }
            $pages['pagination_links']['prev'] = array(
                'link'          => $pages['pagination_links']['prev'],
                'extended_link' => $this->currentPath().'?'.implode('&', $url)
            );
        }

        if(isset($pages['pagination_links']['frw'])) {
            $request = $this->getGetRequestInArray();
            $request = array_merge($request, array('page' => $pages['pagination_links']['frw']));
            $url = array();
            foreach($request as $request_key => $request_value) {
                $url[] = urlencode($request_key).'='.urlencode($request_value);
            }
            $pages['pagination_links']['frw'] = array(
                'link'          => $pages['pagination_links']['frw'],
                'extended_link' => $this->currentPath().'?'.implode('&', $url)
            );
        }

        if(isset($pages['pagination_links']['last_page'])) {
            $request = $this->getGetRequestInArray();
            $request = array_merge($request, array('page' => $pages['pagination_links']['last_page']));
            $url = array();
            foreach($request as $request_key => $request_value) {
                $url[] = urlencode($request_key).'='.urlencode($request_value);
            }
            $pages['pagination_links']['last_page'] = array(
                'link'          => $pages['pagination_links']['last_page'],
                'extended_link' => $this->currentPath().'?'.implode('&', $url)
            );
        }

        if(isset($pages['pagination_links']['first_page'])) {
            $request = $this->getGetRequestInArray();
            $request = array_merge($request, array('page' => $pages['pagination_links']['first_page']));
            $url = array();
            foreach($request as $request_key => $request_value) {
                $url[] = urlencode($request_key).'='.urlencode($request_value);
            }
            $pages['pagination_links']['first_page'] = array(
                'link'          => $pages['pagination_links']['first_page'],
                'extended_link' => $this->currentPath().'?'.implode('&', $url)
            );
        }

        return $pages;
    }

    protected function getCurrentPage()
    {
        $request = $this->getGetRequestInArray();
        if(isset($request['page'])) {
            return (int)$request['page'];
        }
        return 1;
    }

    public function convertRedirect($path)
    {
        $crypt_it = new CryptIT();
        return $crypt_it->encryptUrl($path);
                
    }

}