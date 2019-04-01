<?php

class PluginLike_ModuleLike_EntityLike extends EntityORM
{
    
    protected $aRelations = array(
        'target' => array( self::RELATION_TYPE_BELONGS_TO, 'PluginWiki_ModuleWiki_EntityTarget', 'target_id' )
    );
    
   
}