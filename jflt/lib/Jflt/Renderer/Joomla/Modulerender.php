<?php

// no direct access
defined('JFLT_EXEC') or die('Restricted access');

class Jflt_Renderer_Joomla_Modulerender
{

    // wrapper for modules display
    public function display($positionStub, $chrome = 'standard')
    {
        
        global $jflt;

        $output = '';
        $positions = $jflt->getPositions();
        $position_renders = array();
        $position_sizers = array();
        
        

        if (isset($positions[$positionStub]))
        {
           
            $letters = 'a';
            foreach ($positions[$positionStub] as $key => $value)
            {
                 
                $posName = $positionStub . '-' . $letters . '';
                $gridSize = $value;
                $contents = '';
                $modules = JModuleHelper::getModules($posName);
                
                if (!empty($modules) && count($modules) > 0)
                {
                    
                    $contents .= '<jdoc:include type="modules" name="' . $posName . '" style="' . $chrome . '" />' . "\n";
                }
                $position_renders[$posName] = $contents;
                $position_sizers[$posName] = $gridSize;
                $letters++;
            }
        }


        $position_renders = array_filter($position_renders, create_function('$o', 'return !empty($o);'));

        $end = end(array_keys($position_renders)); //ultimo modulo da posi��o
        $start = reset(array_keys($position_renders)); //primeiro modulo da posi�ao

        /* adicionando classes extras */
        foreach ($position_renders as $position => $posValue)
        {
            $contents = "";
            $contents = $posValue;
            $gridSize = $position_sizers[$position];

            $extraClass = '';
            if ($position == $start)
                $extraClass = "first";
            if ($position == $end)
                $extraClass = "last";
            if ($position == $start && $position == $end)
                $extraClass = "first last";

            $extraClass = 'grid_' . $gridSize . ' ' . $extraClass;
            $output .= $this->render(array('moduleName' => $position, 'contents' => $contents, 'gridSize' => $gridSize, 'extraClass' => $extraClass));
        }

        return $output;
    }

    /**
     * @param array $params todos os parametros necessários para renderizar o layout , com dados associados da seguinte forma  '«NOME-DO-PARAMETRO»' => «VALOR-DO-PARAMETRO»
     * @return conteudo html
     */
    /* cada renderer responsável pela renderização do seu layout */
    public function render($params = array())
    {
        $output = '';
        $output.= '<div class="' . $params["extraClass"] . '">';

        $output.= '<div id="' . $params["moduleName"] . '">';
        $output.=$params["contents"];
        $output.="</div>";

        $output.="</div>";
        return $output;
    }

}
