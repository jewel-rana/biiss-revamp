<?php

use Illuminate\Support\Collection;
use Modules\Media\Entities\Media;
use Modules\Media\MediaService;
use Modules\Media\Repository\MediaRepository;
use Modules\Menu\Entities\Menu;
use Modules\Menu\MenuService;
use Modules\Menu\Repository\MenuRepository;
use Modules\Page\Entities\Page;
use Modules\Page\PageService;
use Modules\Page\Repository\PageRepository;
use Modules\Setting\OptionService;

function getOption($key, $default = null)
{
    return app(OptionService::class)->get($key, $default) ?? $default;
}

function getMenu($name = 'top_menu')
{
    $menus = new MenuService(new MenuRepository(new Menu()));
    return $menus->getMenu($name);
}

function getSlider($slider = 1)
{
    $sliders = new SliderService(new SliderRepository(new Slider()), new MediaService(new MediaRepository(new Media())));
    return $sliders->getSliders()->firstWhere('id', $slider) ?? null;
}

function getServices($service = 'service'): ? Collection
{
    return null;
}

function getDeals($deal_type = 'main'): ?Collection
{
    $deals = new DealService(new DealRepository(new Deal()));
    return $deals->getDeals()->where('deal_type', $deal_type) ?? null;
}

function getPageAttributes($pageID, $attribute): string
{
    $service = new PageService(new PageRepository(new Page()));
    return $service->getAttributes($pageID, $attribute);
}

function getPageAttribute($pageID, $attribute): string
{
    $service = new PageService(new PageRepository(new Page()));
    return $service->getAttributes($pageID, $attribute)->firstWhere('label', $attribute)->content;
}

function prettyPrint( $json ): string
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                $level--;
                $ends_line_level = NULL;
                $new_line_level = $level;
                break;

                case '{': case '[':
                $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                $char = "";
                $ends_line_level = $new_line_level;
                $new_line_level = NULL;
                break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }

    return $result;
}
