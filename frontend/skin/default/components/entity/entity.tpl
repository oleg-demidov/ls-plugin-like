
{component_define_params params=[ 'oEntity', 'classes', 'attributes' ]}

<div class="{$classes}" {cattr list=$attributes} >
    {$oEntity->like->getTitle()}
</div>