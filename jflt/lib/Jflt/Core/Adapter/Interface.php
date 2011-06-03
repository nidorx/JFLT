<?php

// bloqueando acessos diretos
defined('JFLT_EXEC') or die('Restricted access');
interface Jflt_Core_Adapter_Interface
{

    //obtem a instacia do objeto adapter
    public static function get();

    /*
     * Obtem o nome do adapter
     */

    public function getName();

    /*
     * obtem o template atual
     */

    public function getTemplate();



    /*
     * Obtém o diretório base do sistema
     */

    public function getBasePath();


    /*
     * Obtém o diretório do template
     */

    public function getTemplatePath($templateName);


    /*
     * Obtém a URL base do sistem
     */

    public function getBaseUrl();


    /*
     * Obtém a URL do template (usado em algumas requisições AJAX)
     */

    public function getTemplateUrl($baseUrl, $templateName);

    /**
     * Verifica se está na página inicial
     */
    public function isPageHome();

    /**
     * Obtem o nome do site
     * @return String Nome do site
     */
    public function getSiteName();

    /**
     * Obtem a URL atual 
     * @return String Url 
     */
    public function getUrl();

    /**
     * Conta o numero de modulos que existem em uma posicao especifica
     * @return Int Quantidade de modulos dentro de «$positionStub»
     */
    public function countModules($positionStub, $positions);
}
