<?php

class ArtyUserTitles_Listener
{
    public static function initDependencies()
    {        
        XenForo_Template_Helper_Core::$helperCallbacks['usertitle'] = array('ArtyUserTitles_TemplateHelperCore', 'helperUserTitle');
    }
}