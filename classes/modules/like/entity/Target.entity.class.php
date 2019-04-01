<?php

class PluginLike_ModuleLike_EntityTarget extends EntityORM
{
    protected $aRelations = array(
        'likes' => array( self::RELATION_TYPE_HAS_MANY, 'PluginLike_ModuleLike_EntityLike', 'target_id' )
    );
        
}