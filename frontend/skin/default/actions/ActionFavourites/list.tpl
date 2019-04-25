{**
 * Отзывы
 *}
{extends 'layouts/layout.base.tpl'}


{block 'layout_page_title'}
    <h2 class="page-header">{lang "plugin.like.favourites.title"}</h2>
{/block}
                    
{block 'layout_content'}
    
    {if $aTargets}
        {$itemsTarget = []}
        {foreach $aTargets as $oTarget}
            {$itemsTarget[] = [
                count   => $oTarget->getCountLikes(),
                name    => $oTarget->getCode(),
                text    => $oTarget->getTitle(),
                url     => {router page="favourites/{$oUserProfile->getLogin()}/{$oTarget->getCode()}"}
            ]}
        {/foreach}


        {component "bs-nav" 
            activeItem = $oTargetActive->getCode()
            bmods = "tabs"
            items = $itemsTarget}

    {/if}
    {if $aEntities}
        <table class="table mt-3 mb-0">
            
            <tbody>
                {foreach $aEntities as $oEntity}
                    <tr>
                        <th>{$oEntity->getId()}</th>
                        <td><a href="{$oEntity->getUrl()}">{$oEntity->like->getTitle()}</a></td>
                        <td>
                            {component "like:like.remove" 
                                target  = $oEntity
                                bmods = "outline-danger" }
                        </td>
                    </tr>
                {/foreach}
                
            </tbody>
        </table><hr class="mt-0" >

        
        {component 'bs-pagination' 
            total   = $aPaging['iCountPage'] 
            padding = 2
            showPager=true
            classes = "mt-3"
            current= $aPaging['iCurrentPage']  
            url="{$aPaging['sBaseUrl']}/page__page__" }
    {else}
        {component "blankslate" 
            classes = "mt-3"
            text    = {lang "plugin.like.favourites.blankslate.text" target=$oTarget->getTitle()}}
    {/if}
{/block}