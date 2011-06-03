
<?php

// no direct access
defined('JFLT_EXEC') or die('Restricted index access');

require_once (realpath(dirname(__FILE__)) . DS . 'Exception.php');
//For load classes
require_once (realpath(dirname(__FILE__)) . DS . 'Core' . DS . 'Loader.php');


JfltImport('Jflt_Core_Adapter_Interface');

class jflt
{

    var $adapter; //Adapter , permite ao jflt! trabalhar com CMS diferentes
    var $_pageIsHome;
    var $_params_content;
    var $_cms; //sistema usado , joomla , wordpress etc
    var $_params_ini; //param.ini do template
    var $basePath; //diretório base do joomla!
    var $baseUrl; //url base do joomla!
    var $templateName; //nome do template
    var $templateUrl; //url para o template atual («URL-BASE»/templates/«TEMPLATE-NAME»)
    var $templatePath; //diretório do template
    var $jfltPath; //diretório do arquivo atual («TEMPLATE-NAME»/lib/jflt)
    var $jfltUrl; //url para o diretorio da biblioteca jflt («URL»/lib/jflt)
    var $layoutSchemas = array();
    var $mainbodySchemas = array();
    var $pushPullSchemas = array();
    var $mainbodySchemasCombos = array();
    var $presets = array();
    var $originalPresets = array();
    var $customPresets = array();
    var $dontsetinmenuitem = array();
    var $currentMenuTree;
    public $positions;
    var $altindex = false;
    var $browser; //Browser do usuário
    var $platform; // S.O do usuário
    var $_scripts = array();
    var $_styles = array();
    // Hold an instance of the class
    private static $instance;

    // The singleton method
    public static function get()
    {
        if (!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    // A private constructor; prevents direct creation of object
    private function __construct()
    {
        define("JFLT_EXEC", "yes", true);

        $this->_loadAdapter();


        if ($this->adapter->getName() == "joomla")
        {

            $doc = & JFactory::getDocument();
            $this->document = & $doc;
        }


        $this->_getBrowser();

        $this->_getPlatform();


        $this->templateName = $this->_getTemplateName();

        $this->basePath = $this->_getBasePath();
        $this->jfltPath = realpath(dirname(__FILE__) . DS);
        $this->templatePath = $this->_getTemplatePath();

        $this->baseUrl = $this->_getBaseUrl();
        $this->templateUrl = $this->_getTemplateUrl();
        $this->jfltUrl = $this->templateUrl . "/lib/jflt";


        if (!$this->_getParams())
        {
            /* TODO get defaults */
        }
        $this->positions = $this->getPositions(); /* TODO */
        $this->_pageIsHome = $this->_isPageHome(); /* TODO */
    }

    /*
      <<------------------------------------------------------------------------------
      Métodos
      ------------------------------------------------------------------------------>>
     */

    /**
     * Obtem o diretorio base do sistema
     */
    private function _getBasePath()
    {
        return $this->adapter->getBasePath();
    }

    /**
     * Obtem a URL base do sistema
     */
    private function _getBaseUrl()
    {
        return $this->adapter->getBaseUrl();
    }

    /**
     * Obem o brownser usado pelo usuário
     * 
     * @return object jfltBrowser(){}
     */
    private function _getBrowser()
    {
        JfltImport('Jflt_Core_Browser');
        $this->browser = Jflt_Core_Browser::get();
    }

    /**
     * Carrega o conteudo do arquivo params.ini
     * @param  $gantry
     * @return void
     */
    private function _getParams()
    {
        $this->_params_content = "";
        if ($this->_loadParamsContent())
        {
            //$this->_params_ini = new JParameter($this->_params_content);joomla
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * Obem a plataforma do usuário
     * @return object jfltPlatform(){}
     */
    public function _getPlatform()
    {
        JfltImport('Jflt_Core_Platform');
        $this->platform = Jflt_Core_Platform::get();
    }

    /**
     * @return
     */
    function _getTemplateName()
    {
        return $this->adapter->getTemplate();
    }

    /**
     * Obtem o diretorio base do sistema 
     */
    private function _getTemplatePath()
    {
        return $this->adapter->getTemplatePath($this->templateName);
    }

    /**
     * Obtem a URL para o template (usado em AJAX)
     */
    private function _getTemplateUrl()
    {
        return $this->adapter->getTemplateUrl($this->baseUrl, $this->templateName);
    }

    /**
     * verifica se é a pagina inicial
     * @return true se for a página inicial
     */
    private function _isPageHome()
    {
        return $this->adapter->isPageHome();
    }

    /**
     * Carrega o adaptador para o CMS usado , permite ao jflt trabalhar com
     * CMS diferentes
     */
    private function _loadAdapter()
    {
        if (defined('_JEXEC'))
        {//joomla
            JfltImport('Jflt_Adapter_Joomla');
            $this->adapter = Jflt_Adapter_Joomla::get();
        }

        $this->_cms = $this->adapter->getName();
    }

    /**
     * Carrega o conteudo do arquivo params.ini
     * @return true or false
     */
    private function _loadParamsContent()
    {
        $params_file = $this->templatePath . DS . 'params.ini';
        if (is_readable($params_file))
        {
            ///$this->_params_content = file_get_contents($params_file);joomla
            $this->_params_ini = parse_ini_file($params_file); //jflt
            return true;
        }
        return false;
    }

    public function addScript($url, $type='text/javascript')
    {
        $this->_scripts[] = '<script type="' . $type . '" src="' . $url . '"></script>';
    }

    public function addStyleSheet($url, $rel='stylesheet', $type='text/css')
    {
        $this->_styles[] = '<link rel="' . $rel . '" href="' . $url . '" type="' . $type . '" />';
    }

    public function displayHead()
    {
        /* TODO: permitir buscar todos os scripts padrão do joomla */
        foreach ($this->_scripts as $script)
        {
            echo ($script);
        }
        foreach ($this->_styles as $style)
        {
            echo ($style);
        }
    }

    /**
     * @return
     * estrutura Array
      (
      [top] => Array
      (
      [0] => 6
      [1] => 3
      [2] => 3
      )

      [header] => Array
      (
      [0] => 12
      )
      )
     */
    function getPositions()
    {
        //$positions = $this->_params_ini->_registry["_default"]["data"];//joomla
        $positions = $this->_params_ini; //jflt
        $positionsArray = Array();
        foreach ($positions as $position => $value)
        {
            $posName = explode("Position", $position);
            $positionsArray[$posName[0]] = explode("-", $value);
        }
        return $positionsArray;
    }

    /**
     * Verifica se existem módulos ativos na posição «$positionStub»
     * @param  $positionStub exemplo `top`
     * @return int quantidade de modulos numa posição
     */
    public function countModules($positionStub)
    {
        if (defined('jflt_END'))
            return 0;
        return $this->adapter->countModules($positionStub, $this->positions);
    }

    /**
     *  Exibe os módulos do MainBody(levemente diferente dos outros módulos)
     */
    public function displayMainbody($positionMain='main', $chrome = 'standard')
    {
        if (defined('jflt_END'))
            return;
        $cms = $this->_cms;

        $mainRenderClass = 'Jflt_Renderer_' . ucfirst(strtolower($cms)) . '_Mainrender';
        $mainRender = JfltLoad($mainRenderClass);

        return $mainRender->display($chrome);
    }

    /**
     * Exibe os módulos na posição
     * @return
     */
    public function displayModules($positionStub, $chrome = 'standard')
    {
        if (defined('jflt_END'))
            return;
        $cms = $this->_cms;

        $moduleRenderClass = 'Jflt_Renderer_' . ucfirst(strtolower($cms)) . '_Modulerender';
        $moduleRender = JfltLoad($moduleRenderClass);
        return $moduleRender->display($positionStub, $chrome);
    }

    /**
     * Obem a url atual
     * @return URL
     */
    function getCurrentURL()
    {
        return $this->adapter->getUrl();
    }

    /**
     * @return true se for a página inicial
     */
    public function isHome()
    {
        return $this->_pageIsHome;
    }

    function sitename()
    {
        return $this->adapter->getSiteName();
    }

}

