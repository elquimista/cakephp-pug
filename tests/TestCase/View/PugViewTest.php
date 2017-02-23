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
namespace PugView\Test\TestCase\View;

use Cake\Controller\Controller;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PugView\View\PugView;

/**
 * PugViewTest
 */
class PugViewTest extends TestCase
{
    // public $fixtures = ['core.Articles', 'core.Authors'];

    public function setUp()
    {
        Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new PugView($this->request, $this->response);
    }

    /**
     * testResponseType method
     *
     * @return void
     */
    public function testResponseType()
    {
        $this->view->render('index', false);
        $this->assertSame('text/html', $this->response->type());
    }

    /**
     * testRenderIndex method
     *
     * @return void
     */
    public function testRenderIndex()
    {
        $output = $this->view->render('index', false);

        $expected = <<<EXPECTED
<h1>
  Welcome to Pug!
</h1>
<p>
  This shit is awesome, really.
  Hack in here, try stuff or take a look at our 
  <strong class="class">
    Examples
  </strong>
</p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderClasses method
     *
     * @return void
     */
    public function testRenderClasses()
    {
        $output = $this->view->render('classes', false);

        $expected = <<<EXPECTED
<a class="btn btn-default">
  My awesome button!
</a>
<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-6"></div>
    <div class="col-md-3 col-sm-6"></div>
    <div class="col-md-3 col-sm-12"></div>
  </div>
</div>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderIds method
     *
     * @return void
     */
    public function testRenderIds()
    {
        $output = $this->view->render('ids', false);

        $expected = <<<EXPECTED
<input id="passwordInput" type="password">
<div id="someDiv"></div>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderNesting method
     *
     * @return void
     */
    public function testRenderNesting()
    {
        $output = $this->view->render('nesting', false);

        $expected = <<<EXPECTED
<table>
  <thead>
    <tr>
      <th>
        Column 1
      </th>
      <th>
        Column 2
      </th>
      <th>
        Column 3
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        Cell 1
      </td>
      <td>
        Cell 2
      </td>
      <td>
        Cell 3
      </td>
    </tr>
  </tbody>
</table>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderBlockExpansion method
     *
     * @return void
     */
    public function testRenderBlockExpansion()
    {
        $output = $this->view->render('block_expansion', false);

        $expected = <<<EXPECTED
<nav>
  <ul>
    <li>
      <a href="#">
        Item 1
      </a>
    </li>
    <li>
      <a href="#">
        <i class="fa fa-gear"></i>
        Item 2
      </a>
    </li>
    <li>
      <a href="#">
        Item 3
      </a>
    </li>
    <li>
      <a href="#">
        Item 4
      </a>
    </li>
  </ul>
</nav>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderVariables method
     *
     * @return void
     */
    public function testRenderVariables()
    {
        $id = 'div1';
        $this->view->set(compact('id'));
        $output = $this->view->render('variables', false);

        $expected = <<<EXPECTED
<div class="class-a class-b class-c" id="div1"></div>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderMixins method
     *
     * @return void
     */
    public function testRenderMixins()
    {
        $output = $this->view->render('mixins', false);
        
        $expected = <<<EXPECTED
<a class="btn default">
  Default Button</a>


<a class="btn primary">
  Primary Button</a>


<a class="btn info">
  Info Button</a>


<a class="btn danger">
  Danger Button</a>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderHtml5 method
     *
     * @return void
     */
    public function testRenderHtml5()
    {
        $output = $this->view->render('html5', false);
        
        $expected = <<<EXPECTED
<!DOCTYPE html>
<!-- these should be left open -->
<hr>
<img>
<link>
<area>
<!-- These should repeat -->
<a disabled="disabled" selected="selected" checked="checked">
  Some link
</a>
<!-- this should self-close -->
<some-element></some-element>
<!-- this shouldn't self-close -->
<some-element>
  Some Content
</some-element>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderXml method
     *
     * @return void
     */
    public function testRenderXml()
    {
        $output = $this->view->render('xml', false);
        
        $expected = <<<EXPECTED
<?xml version="1.0" encoding="utf-8"?>
<!-- these should be (self)-closed -->
<hr />
<img />
<link />
<area />
<!-- These shouldn't repeat -->
<a disabled="" selected="" checked="">
  Some link
</a>
<!-- this should self-close -->
<some-element />
<!-- this shouldn't self-close -->
<some-element>
  Some Content
</some-element>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderXhtml method
     *
     * @return void
     */
    public function testRenderXhtml()
    {
        $output = $this->view->render('xhtml', false);
        
        $expected = <<<EXPECTED
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- these should (self)-close -->
<hr />
<img />
<link />
<area />
<!-- These should repeat -->
<a disabled="disabled" selected="selected" checked="checked">
  Some link
</a>
<!-- this should self-close -->
<some-element></some-element>
<!-- this shouldn't self-close -->
<some-element>
  Some Content
</some-element>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderAttributes method
     *
     * @return void
     */
    public function testRenderAttributes()
    {
        $output = $this->view->render('attributes', false);
        
        $expected = <<<EXPECTED
<a href="google.de" target="_blank" title="Google">
  Google
</a>
<a href="google.de" target="_blank" title="Google">
  Google
</a>
<a href="google.de" target="_blank" title="Google">
  Google
</a>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderBlocks method
     *
     * @return void
     */
    public function testRenderBlocks()
    {
        $output = $this->view->render('blocks', false);
        
        $expected = <<<EXPECTED
<h1>
  This will be the main header!
</h1>
<h2>
  My Content
</h2>
<p>
  This is my content
</p>
<p>
  This is also content
</p>

<script src="script1.js"></script>
<script src="script2.js"></script>
<script src="script3.js"></script>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderExpressions method
     *
     * @return void
     */
    public function testRenderExpressions()
    {
        $pageTitle = 'Some Page Title';
        $this->view->set(compact('pageTitle'));
        $output = $this->view->render('expressions', false);
        
        $expected = <<<EXPECTED
<h1 class="page-title">
  Some Page Title</h1>
<p>
  And our page title today is:
  Some Page Title  !
</p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderEscaping method
     *
     * @return void
     */
    public function testRenderEscaping()
    {
        $output = $this->view->render('escaping', false);
        
        $expected = <<<EXPECTED
<p>
  This is a string and &lt;a href=&quot;#&quot;&gt;this is &lt;b&gt;HTML&lt;/b&gt;&lt;/a&gt;</p>
<p>
  This is a string and <a href="#">this is <b>HTML</b></a></p>
<a title="This is a string and &lt;a href=&quot;#&quot;&gt;this is &lt;b&gt;HTML&lt;/b&gt;&lt;/a&gt;"></a>
<a title="This is a string and <a href="#">this is <b>HTML</b></a>"></a>
<p>
  I am in a string This is a string and &lt;a href=&quot;#&quot;&gt;this is &lt;b&gt;HTML&lt;/b&gt;&lt;/a&gt;</p>
<p>
  I am in a string This is a string and <a href="#">this is <b>HTML</b></a></p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderCrossAssignments method
     *
     * @return void
     */
    public function testRenderCrossAssignments()
    {
        $output = $this->view->render('cross_assignments', false);
        
        $expected = <<<EXPECTED
<a class="btn btn-default"></a>
<a></a>
<a href="http://host/sub-url/file.html"></a>
<div style="width: 100%; background: red"></div>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderComments method
     *
     * @return void
     */
    public function testRenderComments()
    {
        $output = $this->view->render('comments', false);
        
        $expected = <<<EXPECTED
<!-- This will be compiled to a HTML comment and will be visible in client output -->
<!-- 
  you can easily
  go one level deeper
  and span a comment
  across multiple
  lines
 -->
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderCode method
     *
     * @return void
     */
    public function testRenderCode()
    {
        $output = $this->view->render('code', false);
        
        $expected = <<<EXPECTED
<p>
  Do something
</p>

<p>
  Do something else
</p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderText method
     *
     * @return void
     */
    public function testRenderText()
    {
        $output = $this->view->render('text', false);
        
        $expected = <<<EXPECTED
<a>
  This is normal text
</a>
<p>
  Nested text needs a | prefix
  or the first word will end up
  as the tag.
</p>
<p>
  Make a text-block with a dot (.).
  This text can span
  over multiple lines freely.
</p>
<script>
  no.need();
  to.prepend('anything');
</script>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderMarkup method
     *
     * @return void
     */
    public function testRenderMarkup()
    {
        $output = $this->view->render('markup', false);
        
        $expected = <<<EXPECTED
<p>
  This is a Paragraph.
</p>
<p>But you can also use normal HTML!</p>
<strong>Notice that everything starting with < will be rendered as-is</strong>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderInheritance method
     *
     * @return void
     */
    public function testRenderInheritance()
    {
        $output = $this->view->render('inheritance', false);
        
        $expected = <<<EXPECTED
<!DOCTYPE html>
<html>
  <head>
    <title>
      Title goes here
    </title>
  </head>
  <body>
    
    <p>
      This here will replace the "content"-block in the master-layout!
    </p>
  </body>
</html>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderIncludes method
     *
     * @return void
     */
    public function testRenderIncludes()
    {
        $output = $this->view->render('includes', false);
        
        $expected = <<<EXPECTED
<h1>
  Hello world!
</h1>
php
<!-- will be compiled to  correctly -->
<style>
@charset "utf-8";

 body {
 font-size: 20px;
 }</style>

<!-- will be compiled to <style>..included content...</style> -->
<script>
function (init) {

 init(window.jQuery, window, document);

 } (function ($, window, document) {

 $(function() {
 alert('jQuery loaded!');
 });

 });</script>

<!-- will be compiled to <script>...included content...</script> -->
<h1>Hello from MarkDown</h1>
<!-- will be compiled from markdown -->
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderConditionals method
     *
     * @return void
     */
    public function testRenderConditionals()
    {
        $output = $this->view->render('conditionals', false);
        
        $expected = <<<EXPECTED
  <p>
    Do something else
  </p>
  <p class="success">
    Success!
  </p>
  <p>
    It's one!
  </p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderSwitchCase method
     *
     * @return void
     */
    public function testRenderSwitchCase()
    {
        $output = $this->view->render('switch_case', false);
        
        $expected = <<<EXPECTED
    <p>
      Do the default thing
    </p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderLoops method
     *
     * @return void
     */
    public function testRenderLoops()
    {
        $items = ['a', 'b', 'c'];
        $this->view->set(compact('items'));
        $output = $this->view->render('loops', false);
        
        $expected = <<<EXPECTED
  <p>
    Item at 0 is a!
  </p>

  <p>
    Item at 1 is b!
  </p>

  <p>
    Item at 2 is c!
  </p>

  <p>
    Item is a!
  </p>

  <p>
    Item is b!
  </p>

  <p>
    Item is c!
  </p>

  <p>
    Do something until \$i is 5
  </p>
  

  <p>
    Do something until \$i is 5
  </p>
  

  <p>
    Do something until \$i is 5
  </p>
  

  <p>
    Do something until \$i is 5
  </p>
  

  <p>
    Do something until \$i is 5
  </p>
  


  <p>
    Do something with 0  </p>
  
  <p>
    Do something with 1  </p>
  
  <p>
    Do something with 2  </p>
  
  <p>
    Do something with 3  </p>
  

  <p>
    Do something with 0  </p>

  <p>
    Do something with 1  </p>

  <p>
    Do something with 2  </p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderInterpolation method
     *
     * @return void
     */
    public function testRenderInterpolation()
    {
        $user = ['name' => 'John Doe'];
        $this->view->set(compact('user'));
        $output = $this->view->render('interpolation', false);
        
        $expected = <<<EXPECTED
<p>
  Hello, John Doe, how are you today?
</p>
<p>
  I'm in a really long text, but I need a link!
  I can simply use 
  <a href="pug-interpolation.html">
    Pug Interpolation!
  </a>
</p>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderFilters method
     *
     * @return void
     */
    public function testRenderFilters()
    {
        $output = $this->view->render('filters', false);
        
        $expected = <<<EXPECTED
<style>
body, html {
 height: 100%;

 color: black;

 }</style>

<script>
if (someThing) {
 doSomething();

 }</script>

Done something
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderMixinBlocks method
     *
     * @return void
     */
    public function testRenderMixinBlocks()
    {
        $output = $this->view->render('mixin_blocks', false);
        
        $expected = <<<EXPECTED
<header class="article-header">
  Article 1</header>
<article>
      
<p>
  The content of my first article
</p>
  </article>


<header class="article-header">
  Article 2</header>
<article>
      
<p>
  The content of my second article
</p>
  </article>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderVariadics method
     *
     * @return void
     */
    public function testRenderVariadics()
    {
        $output = $this->view->render('variadics', false);
        
        $expected = <<<EXPECTED
  <header>
      </header>
  <article>
      </article>

  <header>
      </header>
  <article>
      </article>

  <header>
      </header>
  <article>
      </article>

  <header>
      </header>
  <article>
      </article>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderNamedMixinParameters method
     *
     * @return void
     */
    public function testRenderNamedMixinParameters()
    {
        $output = $this->view->render('named_mixin_parameters', false);
        
        $expected = <<<EXPECTED
<table>
  <!-- ... something -->
  <thead>
    <tr></tr>
  </thead>
  <th>
    search query  </th>
  <th>
    id:desc  </th>
  <th>
    100  </th>
  <th>
    0  </th>
</table>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderAttributeStacking method
     *
     * @return void
     */
    public function testRenderAttributeStacking()
    {
        $output = $this->view->render('attribute_stacking', false);
        
        $expected = <<<EXPECTED
<a href="http://host/path/file"></a>
<a class="btn btn-default btn-lg"></a>
<div style="width: 100%; height: 50%; background: red"></div>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderVariableAccess method
     *
     * @return void
     */
    public function testRenderVariableAccess()
    {
        $output = $this->view->render('variable_access', false);
        
        $expected = <<<EXPECTED
100Array
(
    [0] => value1
    [1] => value2
    [key1] => value1
    [key2] => value2
    [key3] => value3
)
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderMarkdown method
     *
     * @return void
     */
    public function testRenderMarkdown()
    {
        $output = $this->view->render('markdown', false);
        
        $expected = <<<EXPECTED
<!-- You can use :md or :markdown -->
<h1>Welcome!</h1>
<p><strong>This</strong> right here is an <em>awesome</em> Markdown powered template.</p>
<ul>
<li>
<p>This</p>
</li>
<li>
<p>is</p>
</li>
<li>Tale Jade!</li>
</ul>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderForwarding method
     *
     * @return void
     */
    public function testRenderForwarding()
    {
        $output = $this->view->render('forwarding', false);
        
        $expected = <<<EXPECTED
<a class="btn btn-default">
  Default Button</a>


<a class="btn btn-primary">
  Primary Button</a>


<a class="btn btn-info">
  Info Button</a>


<a class="btn btn-danger">
  Danger Button</a>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderWithLayout method
     *
     * @return void
     */
    public function testRenderWithLayout()
    {
        $output = $this->view->render('with_layout');
        
        $expected = <<<EXPECTED
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="lt-ie7"> <endif-->
<!--[if IE 7]>     <html class="lt-ie8"> <endif-->
<!--[if IE 8]>     <html class="lt-ie9"> <endif-->
<!--[if gt IE 8]><!-->
<html>
<!--<endif-->
<head>
  <meta charset="utf-8"/>  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>  <meta name="description" content=""/>  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1"/>  
  <title>
    CakePHP: the rapid development php framework:   </title>
  <link href="favicon.ico" type="image/x-icon" rel="icon"/><link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>  
  <link rel="stylesheet" href="application.css" media="screen, projection"/>  
  <!--[if lt IE 9]><script src="assets/components_premium/con-material-adui/dist/assets/html5shiv/html5shiv.min.js"></script>
  <endif-->
    </head>
<body>
  <h1>
  Hello New York!
</h1>  <footer>
    &copy; 2016
    <strong>
      
      <a href="http://github.com/coolops" target="_new">
        CoolOps
      </a>
    </strong>
    All rights reserved.
  </footer>
    
  <script src="application.js"></script>  
  </body>
</html>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }

    /**
     * testRenderUseHelpers method
     *
     * @return void
     */
    public function testRenderUseHelpers()
    {
        $output = $this->view->render('use_helpers');
        
        $expected = <<<EXPECTED
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="lt-ie7"> <endif-->
<!--[if IE 7]>     <html class="lt-ie8"> <endif-->
<!--[if IE 8]>     <html class="lt-ie9"> <endif-->
<!--[if gt IE 8]><!-->
<html>
<!--<endif-->
<head>
  <meta charset="utf-8"/>  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>  <meta name="description" content=""/>  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1"/>  
  <title>
    CakePHP: the rapid development php framework:   </title>
  <link href="favicon.ico" type="image/x-icon" rel="icon"/><link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>  
  <link rel="stylesheet" href="application.css" media="screen, projection"/>  
  <!--[if lt IE 9]><script src="assets/components_premium/con-material-adui/dist/assets/html5shiv/html5shiv.min.js"></script>
  <endif-->
    </head>
<body>
  <a>
  <img src="logo.png" alt=""/></a>
  <footer>
    &copy; 2016
    <strong>
      
      <a href="http://github.com/coolops" target="_new">
        CoolOps
      </a>
    </strong>
    All rights reserved.
  </footer>
    
  <script src="application.js"></script>  
  <script>
//<![CDATA[
alert('hi browser');

//]]>
</script></body>
</html>
EXPECTED;
        $this->assertSame(trim($expected), trim($output));
    }
}