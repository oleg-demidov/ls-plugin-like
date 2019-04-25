<?php


class PluginLike_HookMenuProfile extends Hook{
    public function RegisterHook()
    {
        $this->AddHook('engine_init_complete', 'NavProfile');      
    }

    /**
     * Добавляем в главное меню 
     */
    public function NavProfile($aParams)
    {
        if(!$oUser = $this->User_GetUserCurrent()){
            return false;
        }
        
        $oMenuProfile = $this->Menu_Get('profile');
        $oMenuUser = $this->Menu_Get('user');        
        
        $oItem = Engine::GetEntity("ModuleMenu_EntityItem", [
            'name' => 'favourites',
            'title' => 'plugin.like.nav.text',
            'url' => 'favourites/'.$oUser->getLogin(),
            'count' => $this->PluginLike_Like_GetCountFromLikeByFilter(['user_id' => $oUser->getId()])
        ]);
        
        $oMenuProfile->appendChild($oItem);
        $oMenuUser->appendChild($oItem);
        
    }
    
}
