<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Progress helper
 */
class ProgressHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    public function bar($value)
    {
        $width = round($value/100,2) * 100;
        return sprintf(
            '<div class="progress-container">
                      <div class="progress-bar" style="width: %s%%"></div>
                    </div>  
            ', $width);
    }

}
