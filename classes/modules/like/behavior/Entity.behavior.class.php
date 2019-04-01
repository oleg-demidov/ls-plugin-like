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
 * Поведение, которое необходимо добавлять к сущности (entity) у которой добавляются категории
 *
 * @package application.modules.category
 * @since 2.0
 */
class PluginLike_ModuleLike_BehaviorEntity extends Behavior
{
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    protected $aParams = array(
        // Уникальный код
        'target_type'                    => '',
        // Колбек для сообщения о нажатии нравится.
        // Указывать можно строкой с полным вызовом метода модуля, например, "PluginArticle_Main_GetCountArticle"
        'callback_like'          => null,
    );
    
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'after_delete'   => 'CallbackAfterDelete'
    );
    

    /**
     * Инициализация
     */
    protected function Init()
    {
        parent::Init();
        
    }

    /**
     * Коллбэк
     * Выполняется после удаления сущности
     */
    public function CallbackAfterDelete()
    {
        $this->PluginLike_Like_RemoveLikesByTargetId(
            $this->getParam('target_type'), 
            $this->oObject->_getPrimaryKeyValue()
        );
    }

    
    /**
     * Возвращает сущности
     *
     * @return array
     */
    public function getList($sType = PluginLike_ModuleLike::TYPE_LIKE)
    {
        if(!$oTarget = $this->PluginLike_Like_GetTargetByCode($this->getParam('target_type'))){
            return;
        }
        return $this->PluginLike_Like_GetLikeItemsByFilter([
            'type_id' => $oTarget->getId(), 
            'target_id' => $this->oObject->_getPrimaryKeyValue(),
            'type' => $sType
        ]);
    }

    /**
     * Возвращает количество лайков
     *
     * @return array
     */
    public function getCount($sType = PluginLike_ModuleLike::TYPE_LIKE)
    {
        if(!$oTarget = $this->PluginLike_Like_GetTargetByCode($this->getParam('target_type'))){
            return;
        }
        return $this->PluginLike_Like_GetCountFromLikeByFilter([
            'type_id' => $oTarget->getId(), 
            'target_id' => $this->oObject->_getPrimaryKeyValue(),
            'type' => $sType
        ]);
    }

    
}