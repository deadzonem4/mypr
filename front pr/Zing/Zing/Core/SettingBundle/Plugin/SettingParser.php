<?php
namespace Zing\Core\SettingBundle\Plugin;

use Symfony\Component\Finder\Finder;
use Zing\Core\SettingBundle\Exception\SettingFileException;
use Zing\Core\SettingBundle\Exception\SettingNotFoundException;

class SettingParser {

    /** Default file name for all bundle settings */
    protected $file_name = 'setting_built.json';
    /** Default settings for all bundles */
    protected $default_settings = array('name', 'version', 'status');
    /** Type of bundles */
    private $bundle_types = array(
        'Core'      => 'Core',
        'Component' => 'Component'
    );
    
    private $bundle_default_built = array();

    public function __construct() {
        $this->_find();
    }

    /** Get specific bundle settings from a built
     * @param string $built. Json.
     * @param string $bundle_name
     * @return mixed. Bundle setting or false if is not found
     */
    public function getBundleFromBuilt($built = null, $bundle_name = null)
    {

        if($built == null || $bundle_name == null) {
            return false;
        }

        /** Decode built */
        $built = $this->decode_setting($built);
        if(isset($built[$bundle_name])) {
            return $built[$bundle_name];
        }

        $default_built = $this->getDefaultBuilt();
        if(isset($default_built[$bundle_name])) {
            return $default_built[$bundle_name];
        }

        return false;
    }

    /** Parse requested built
     * @param string $built. The last built that is created, it can be false then default bundle setting will be parsed
     * @param array $request. The new settings for merging with current built
     * @param bool $flush. If flush is set to true, then the built will not be merged, it will be overwritten from the requested built
     * @return string. Json string
     */
    public function parse($built = false, $request = array(), $flush = false)
    {
       /** If they are no buildings, set default bundle settings */
       if(!$built) {
           return $this->encode_setting($this->bundle_default_built);
       }

        /** If a built is given but setting for merging are not then return given built */
        if(!count($request) > 0) {
            return $built;
        }

        /** Decode built */
        $built = $this->decode_setting($built);

        $built = array_merge($built, array_merge($this->bundle_default_built, $built));

        foreach($built as $key => $setting) {
            if(isset($request[$key])) {

                if($flush != true) {
                    /** Merge new requested settings with the built settings */
                    $built = array_merge($built, array($key => array_merge($built[$key], $request[$key])));
                } else {
                    $built = array_merge($built, array($key => $request[$key]));
                }

            }
        }

       /** Encode and return the new merged built */
       return $this->encode_setting($built);
    }

    public function getDefaultBuilt() {
        return $this->bundle_default_built;
    }


    public function findOneBy($type, $bundle_name)
    {

        if(!isset($this->bundle_types[$type])) {
            throw new SettingNotFoundException($type, $bundle_name);
        }

        $bundle_built = array('file_data' => '[]', 'real_path' => '');

        /** Initilize symfony2 finder component */
        $finder = new Finder();

        foreach($finder->name($this->file_name)->in(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR.$this->bundle_types[$type].DIRECTORY_SEPARATOR.$bundle_name) as $file){

            /** Parse bundle setting file */
            $file_data = $this->decode_setting(file_get_contents($file->getRealpath()), true);

            /** Verify if file data is correct */
            $this->_verifyFile($file, $file_data);

            return array('file_data' => $file_data, 'real_path' => $file->getRealpath());
        }

        return $bundle_built;
    }

    /** Find all setting files of installed zing bundles
     * @return object. $this
     */
    private function _find()
    {
        /** Initilize symfony2 finder component */
        $finder = new Finder();

        /** Loop setting files */
        foreach($finder->name($this->file_name)->in(dirname(dirname(dirname(__DIR__)))) as $file) {

            /** Parse bundle setting file */
            $file_data = $this->decode_setting(file_get_contents($file->getRealpath()));

            /** Verify if file data is correct */
            $this->_verifyFile($file, $file_data);

            /** Save to setting array */
            $this->bundle_default_built[$file_data['name']] = $file_data;
        }

        return $this;
    }

    /** Verify setting file data
     * @param string $file. Real path to file
     * @param array $file_data. File data in array
     * @return bool. On success return true
     * @throws SettingFileException if the file data is not correct
     */
    private function _verifyFile($file, $file_data)
    {
        foreach($this->default_settings as $default_setting) {
            if(!isset($file_data[$default_setting])) {
                throw new SettingFileException($default_setting, $file);
            }
        }
        return true;
    }

    /** Encode built with json
     * @param array $setting
     * @return string. Json array
     */
    protected function encode_setting($setting = array()) {
        return json_encode($setting, JSON_UNESCAPED_UNICODE);
    }

    /** Decode built from json
     * @param string. Json formated array
     * @return array. Parsed json string to array
     */
    protected function decode_setting($setting) {
        return json_decode($setting, true);
    }


}