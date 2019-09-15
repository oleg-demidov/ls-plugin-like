<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['like_like_target'] = '___db.table.prefix___like_target';
$config['$root$']['db']['table']['like_like'] = '___db.table.prefix___like';

/**
 * Роутинг
 */
$config['$root$']['router']['page']['like'] = 'PluginLike_ActionLike';
$config['$root$']['router']['page']['favourites'] = 'PluginLike_ActionFavourites';

$config['favourites']['per_page'] = 10;
$config['favourites']['view_page_count'] = 5;

$config['$root$']['block']['userProfileFavourite'] = array(
    'action' => array(
        'favourites'
    ),
    'blocks' => array(
        'left' => array(
            'component@user.block-photo'    => array('priority' => 100),
            'menuProfile'      => array('priority' => 99),
            'component@user.block-actions'  => array('priority' => 98),
        )
    )
);

return $config;