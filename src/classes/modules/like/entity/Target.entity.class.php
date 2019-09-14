<?php

class PluginLike_ModuleLike_EntityTarget extends EntityORM
{
    protected $aRelations = array(
        'likes' => array( self::RELATION_TYPE_HAS_MANY, 'PluginLike_ModuleLike_EntityLike', 'type_id' )
    );
    
    public function getCountLikes() {
        return $this->PluginLike_Like_GetCountFromLikeByFilter(['type_id' => $this->getId()]);
    }
    
    public function getLikesForUser($oUser){
        return $this->PluginLike_Like_GetLikeItemsByFilter([
            'type_id' => $this->getId(),
            'user_id' => $oUser->getId(),
            '#index-from' => 'target_id'
        ]);
    }
        
}