<?php
/**
 * Copyright (c) clthck (http://github.com/clthck)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) clthck (http://github.com/clthck)
 * @link      http://github.com/clthck/cakephp-jade
 * @since     0.0.1
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace clthck\JadeView\View;

use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\View\View;
use Tale\Jade;

/**
 * Jade View
 *
 * View class to preprocess Jade template language
 *
 */
class JadeView extends View
{

    /**
     * Constants
     */
    const EXT = '.ctp.jade';
    const TEMPLATE_PATH = APP . 'Template';

    /**
     * Template file extension.
     * @override
     */
    protected $_ext = self::EXT;

    // Array of file extensions
    protected $extensions = [
        self::EXT,
        '.ctp',
    ];

    // Instance of Tale\Jade\Renderer
    protected $renderer;

    /**
     * Constructor
     *
     * @param Request|null       $request
     * @param Response|null      $response
     * @param EventManager|null  $eventManager
     * @param array              $viewOptions
     */
    public function __construct(Request $request = null, Response $response = null, EventManager $eventManager = null, array $viewOptions = [])
    {
        if ($eventManager === null) {
            $eventManager = EventManager::instance();
        }

        parent::__construct($request, $response, $eventManager, $viewOptions);
    }

    /**
     * Initialize method
     *
     */
    public function initialize()
    {
        $options = [
            'paths' => [
                self::TEMPLATE_PATH
            ],
            'adapterOptions' => [
                'path' => CACHE . 'views'
            ],
            'lexerOptions' => [
                'indentStyle' => ' ',
                'indentWidth' => 2,
            ]
        ];
        $options = array_merge($options, $this->viewOptions());

        $this->renderer = new Jade\Renderer($options);
        $this->_ext = self::EXT;
    }

    /**
     * Renders and returns output for given template filename with its array of data.
     * Handles parent/extended templates.
     *
     * @param string    $viewFile
     * @param array     $data
     * @return string
     */
    protected function _render($viewFile, $data = [])
    {
        if (empty($data)) {
            $data = $this->viewVars;
        }

        if (substr($viewFile, -3) === 'ctp') {
            $out = parent::_render($viewFile, $data);
        } else {
            $viewFile = str_replace(self::TEMPLATE_PATH, '', $viewFile);
            $data = array_merge($data, [
                'view' => $this,
            ]);
            $out = $this->renderer->render($viewFile, $data);
        }
        
        return $out;
    }

    /**
     * Returns filename of given action's template file (.ctp.jade) as a string.
     * CamelCased action names will be under_scored by default.
     * This means that you can have LongActionNames that refer to long_action_names.ctp.jade view.
     * You can change the inflection rule by overriding _inflectViewFileName.
     *
     * @param string|null $name
     * @return string
     */
    protected function _getViewFileName($name = null)
    {
        $rethrow = new \Exception("You're not supposed to get here.");
        foreach ($this->extensions as $extension) {
            $this->_ext = $extension;
            try {
                return parent::_getViewFileName($name);
            } catch (\Exception $e) {
                $rethrow = $e;
            }
        }

        throw $rethrow;
    }

    /**
     * Returns layout filename for this template as a string.
     *
     * @param string|null $name
     * @return string
     */
    protected function _getLayoutFileName($name = null)
    {
        $rethrow = new \Exception("You're not supposed to get here.");
        foreach ($this->extensions as $extension) {
            $this->_ext = $extension;
            try {
                return parent::_getLayoutFileName($name);
            } catch (\Exception $e) {
                $rethrow = $e;
            }
        }

        throw $rethrow;
    }
}
