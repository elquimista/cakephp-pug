<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace clthck\JadeView\Test\TestCase\View;

use Cake\Controller\Controller;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use clthck\JadeView\View\JadeView;

/**
 * JadeViewTest
 */
class JadeViewTest extends TestCase
{
    // public $fixtures = ['core.Articles', 'core.Authors'];

    public function setUp()
    {
        Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new JadeView($this->request, $this->response);
    }

    /**
     * testRender method
     *
     * @return void
     */
    public function testRender()
    {
        $data = 'Testing';
        $this->view->set(['data' => $data, '_serialize' => 'data']);
        $output = $this->view->render('index', false);
        $this->assertSame('<h1>Hello</h1>', $output);
        $this->assertSame('text/html', $this->response->type());
    }
}