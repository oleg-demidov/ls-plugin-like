<?php
/**
 * 
 * @author Oleg Demidov
 *
 */

namespace LS\Plugin;
use Plugin;


class PluginLike extends Plugin
{
    
    public function Init()
    { 
//        $this->Lang_AddLangJs([
//            'plugin.wiki.markitup.punkt'
//        ]);
//        
        $this->Component_Add('like:like');

        $this->Viewer_AppendScript(Plugin::GetTemplatePath('like'). '/assets/js/init.js');
    }

    public function Activate()
    {
        
        return true;
    }

    public function Deactivate()
    {
        
        return true;
    }
    
    public function Remove()
    {
        
        return true;
    }
}