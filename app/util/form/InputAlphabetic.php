<?php
/**
 * InputAlphabetic.php
 */

namespace SoftnCMS\util\form;

use SoftnCMS\util\form\inputs\types\InputText;
use SoftnCMS\util\Sanitize;
use SoftnCMS\util\Validate;

/**
 * Class InputAlphabetic
 * @author Nicolás Marulanda P.
 */
class InputAlphabetic extends InputText {
    
    /**
     * InputAlphabetic constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    public function filter() {
        $output = Sanitize::alphabetic($this->value, $this->accents, $this->withoutSpace, $this->replaceSpace, $this->specialChar);
        
        if (!Validate::alphabetic($output, $this->lenMax, $this->accents, $this->lenStrict, $this->specialChar)) {
            $output = '';
        }
        
        return $output;
    }
    
}
