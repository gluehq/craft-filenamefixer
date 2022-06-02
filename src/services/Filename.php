<?php
/**
 * Filename Fixer plugin for Craft CMS 3.x
 *
 * Rename a multibyte character filename, such as Japanese, Chinese, Korean, and so on, when assets are uploaded.
 *
 * @link      https://www.glue.co.nz
 * @copyright Copyright (c) 2021 Glue
 */

namespace gluehq\filenamefixer\services;

use gluehq\filenamefixer\FilenameFixer;

use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
use DateTime;

/**
 * Filename Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Glue
 * @package   FilenameFixer
 * @since     1.0.0
 */
class Filename extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     FilenameFixer::$plugin->filename->rename()
     *
     * @param $asset
     * @return mixed
     */
    public function rename(&$asset, $hook)
    {
        
        $filename = $asset->getFilename(false);
        
        // Create a new filename
        $extension = $asset->getExtension();
        $newFilename = preg_replace('/_/', '-', $filename) . '.' . $extension;
        
        // Rename
        if ($hook === 'EVENT_BEFORE_SAVE_ELEMENT') {
            $asset->title = $filename;
            $asset->filename = $newFilename;
        }
        else {
            $folder = $asset->getFolder();
            return Craft::$app->assets->moveAsset($asset, $folder, $newFilename);;
        }

    }

}
