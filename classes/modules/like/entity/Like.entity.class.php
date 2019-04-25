<?php

class PluginLike_ModuleLike_EntityLike extends EntityORM
{
    
    protected $aRelations = array(
        'target' => array( self::RELATION_TYPE_BELONGS_TO, 'PluginWiki_ModuleWiki_EntityTarget', 'type_id' )
    );
    
    protected $aValidateRules = [
        ['type_id target_id user_id', 'exists']
    ];
    
    public function ValidateExists($sValue, $aParams) {
        if($this->PluginLike_Like_GetLikeByFilter([
            'type_id' =>  $this->getTypeId(), 
            'target_id' =>  $this->getTargetId(), 
            'user_id' =>  $this->getUserId()
        ])){
            return $this->Lang_Get('plugin.like.like.notices.error_validate_exists');
        }
        return true;
    }
    
    public function getEntity() {
        
    }
}