<?php
/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Поведение, которое необходимо добавлять к ORM модулю сущности у которой добавляются категории
 *
 * @package application.modules.category
 * @since 2.0
 */
class PluginLike_ModuleLike_BehaviorModule extends Behavior
{
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    protected $aParams = array(
        'target_type' => '',
    );
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'module_orm_GetItemsByFilter_after'  => array(
            'CallbackGetItemsByFilterAfter',
            1000
        ),
        'module_orm_GetItemsByFilter_before' => array(
            'CallbackGetItemsByFilterBefore',
            1000
        )
    );
    
    /**
     * Модифицирует результат ORM запроса
     *
     * @param $aParams
     */
    public function CallbackGetItemsByFilterBefore($aParams)
    {
        if($oEntity = Engine::GetEntity($aParams['sEntityFull'])){
            if($oBehaviorLike = $oEntity->GetBehavior('like')){
                $sTargetType = $oBehaviorLike->getParam('target_type');
            }
        }
        
        $aFilter = $this->PluginLike_Like_RewriteFilter(
            $aParams['aFilter'], 
            $aParams['sEntityFull'],
            $sTargetType);
        
        $aParams['aFilter'] = $aFilter;
    }


    /**
     * Модифицирует фильтр в ORM запросе
     *
     * @param $aParams
     */
    public function CallbackGetItemsByFilterAfter($aParams)
    {
        if(!$oUserCurrent = $this->User_GetUserCurrent()){
            return;
        }
        
        if(!$aParams['aEntities']){
            return;
        }
        
        if($oBehaviorLike = array_shift($aParams['aEntities'])->GetBehavior('like')){
            $sTargetType = $oBehaviorLike->getParam('target_type');
        }
        
        $aEntities = $aParams['aEntities'];
        
        $this->PluginLike_Like_AttachUserLikes($aEntities, $sTargetType, $oUserCurrent->getId());
    }

    
    
}