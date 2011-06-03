<?php

/**
 * @package humrum
 * @subpackage  core.adapters
 * @version 0.2.0 Dezembro 2010
 * @author Alex Rodin - contato@alexrodin.com (email,msn,gtalk)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * humrum! template system usa o Framework Joomla (http://www.joomla.org), um cms GNU/GPLv2
 *
 * 
 */
// bloqueando acessos diretos
defined('JFLT_EXEC') or die('Restricted access');

class Jflt_Adapter_Joomla implements Jflt_Core_Adapter_Interface
{

    /**
     *
     * @var string 
     */
    public static $name = "joomla";
    /**
     *
     * @var Jflt_Adapter_Joomla 
     */
    private static $instance;

    /**
     *
     * @return Jflt_Adapter_Joomla 
     */
    public static function get()
    {
        if (!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     *
     * @return string 
     */
    public function getName()
    {
        return self::$name;
    }

    public function getTemplate()
    {
        global $mainframe;
        $session = & JFactory::getSession();
        $template = null;
        if (!$mainframe->isAdmin())
        {
            $app = &JApplication::getInstance('site', array(), 'J');
            $template = $app->getTemplate();
        } else
        {
            if (array_key_exists('cid', $_REQUEST))
            {
                $template = $_REQUEST['cid'][0];
            } else
            {
                $template = $session->get('humrum-current-template');
            }
        }
        $session->set('humrum-current-template', $template);
        return $template;
    }

    public function getBasePath()
    {
        return JPATH_ROOT;
    }

    public function getTemplatePath($templateName)
    {
        return JPATH_ROOT . DS . 'templates' . DS . $templateName;
        ;
    }

    public function getBaseUrl()
    {
        return JURI::root(true) . "/";
    }

    public function getTemplateUrl($baseUrl, $templateName)
    {
        return $baseUrl . 'templates' . "/" . $templateName;
    }

    public function isPageHome()
    {
        $menu = & JSite::getMenu();
        if ($menu->getActive() == $menu->getDefault())
        {
            return true;
        } else
        {
            return false;
        };
    }

    public function getSiteName()
    {
        $config = new JConfig();
        return $config->sitename;
    }

    public function getUrl()
    {
        $cururl = JRequest::getURI();
        if (($pos = strpos($cururl, "index.php")) !== false)
        {
            $cururl = substr($cururl, $pos);
        }
        $cururl = JRoute::_($cururl, true, 0);
        return $cururl;
    }

    public function countModules($positionStub, $positions)
    {
        global $mainframe;
        $doc = & JFactory::getDocument();
        $document = & $doc;

        $count = 0;
        foreach ($positions as $positionName => $positionValues)
        {
            if ($positionStub == $positionName)
            {
                $letters = 'a';
                foreach ($positionValues as $key => $value)
                {
                    $posName = $positionName . '-' . $letters . '';
                    if (!$mainframe->isAdmin())
                    {//TODO: tornar multi CMS
                        if ($document->countModules($posName))
                        {
                            $count++;
                        }
                    }
                    $letters++;
                }
            }
        }
        return $count;
    }

}

?>
