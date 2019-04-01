<?php

class PluginLike_ModuleLike extends ModuleORM
{
    
    const TYPE_LIKE = 1;
    const TYPE_DISLIKE = 2;
    
    public function Init() {
        parent::Init(); 
    }
    
    public function AttachUserLikes($aEntityItems, $sTargetType, $iUserId) {
        if (!is_array($aEntityItems)) {
            $aEntityItems = array($aEntityItems);
        }
        $aEntitiesId = array();
        foreach ($aEntityItems as $oEntity) {
            $aEntitiesId[] = $oEntity->getId();
        }
        
        if(!$oTarget = $this->GetTargetByCode($sTargetType)){
            return false;
        }
        
        $aLikes = $this->GetLikeItemsByFilter([
            'user_id' => $iUserId,
            'type_id' => $oTarget->getId(),
            'type'  => self::TYPE_LIKE,
            'target_id in' => $aEntitiesId,
            '#index-from' => 'target_id'
        ]);
        
        $aEntityIdsUserLike = array_keys($aLikes);
        
        foreach ($aEntityItems as $oEntity) {
            $oEntity->setUserLike(in_array($oEntity->getId(), $aEntityIdsUserLike));
        }
    }
    
    public function CreateTarget($sEntity, $sCode, $sTitle) {
        
        $oTarget = Engine::GetEntity('PluginLike_Like_Target', [
            'code'   => $sCode,
            'title'  => $sTitle
        ]);
        
        return $oTarget->Save();
    }
    
    public function Like( $iUserId, $sTargetType, $iTargetId) {
        
        if(!$oTarget = $this->GetTargetByCode($sTargetType)){
            return;
        }
        
        $oLike = Engine::GetEntity('PluginLike_Like_Like', [
            'user_id' => $iUserId,
            'type_id' => $oTarget->getId(),
            'target_id' => $iTargetId,
            'type' => 1
        ]);
        
        if(!$oLike->_Validate()){
            return $oLike->_getValidateError();
        }
        
        return $oLike->Save();
    }
    
    public function RemoveLike( $iUserId, $sTargetType, $iTargetId) {
        
        if(!$oTarget = $this->GetTargetByCode($sTargetType)){
            return;
        }
        
        $oLike = $this->GetLikeByFilter( [
            'user_id' => $iUserId,
            'type_id' => $oTarget->getId(),
            'target_id' => $iTargetId
        ]);
        if(!$oLike){
            return false;
        }
        return $oLike->Delete();
    }
    
    public function RewriteFilter($aFilter, $sEntityFull, $sTargetType)
    {
//        if (!isset($aFilter['#with']) or !in_array('like', $aFilter['#with'])) {
//            return $aFilter;
//        }
        
        $oEntitySample = Engine::GetEntity($sEntityFull);

        if (!isset($aFilter['#join'])) {
            $aFilter['#join'] = array();
        }

        if (!isset($aFilter['#select'])) {
            $aFilter['#select'] = array();
        }

        $sJoin = " LEFT JOIN (SELECT count(*) as count_like, l.target_id FROM `" 
            . Config::Get('db.table.like_like') . "` as l JOIN `" 
            . Config::Get('db.table.like_like_target') . "` as lt "
            . "ON l.type_id = lt.id WHERE lt.code = '{$sTargetType}' GROUP BY l.target_id) as c "
            . "ON t.`{$oEntitySample->_getPrimaryKey()}` = c.target_id ";
            
        $aFilter['#join'][] = $sJoin;
        if (count($aFilter['#select'])) {
            $aFilter['#select'][] = "distinct t.`{$oEntitySample->_getPrimaryKey()}`";
        } else {
            $aFilter['#select'][] = "distinct t.`{$oEntitySample->_getPrimaryKey()}`";
            $aFilter['#select'][] = 't.*';
            $aFilter['#select'][] = 'c.count_like';
        }
        
        return $aFilter;
    }
    
    public function GetCountForTarget($sTargetType, $iTargetId) {
        if(!$oTarget = $this->GetTargetByCode($sTargetType)){
            return 0;
        }
        
        return $this->GetCountFromLikeByFilter( [
            'type_id' => $oTarget->getId(),
            'target_id' => $iTargetId
        ]);
    }
    
    public function IsLikeUser($iUserId, $sTargetType, $iTargetId) {
        if(!$oTarget = $this->GetTargetByCode($sTargetType)){
            return 0;
        }
        
        return $oLike = $this->GetLikeByFilter( [
            'user_id' => $iUserId,
            'type_id' => $oTarget->getId(),
            'target_id' => $iTargetId
        ]);
        
        if($oLike){
            return ($oLike->getState() == 1);
        }
        
        return false;
    }
}