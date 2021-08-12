<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model\Config\Source;

class AnimationType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $effects = [
            [
                'label' => 'None',
                'value' => ''
            ]
            , ['label' => __('Attention Seekers'), 'value' => [
                ['label' => 'bounce', 'value' => 'bounce'],
                ['label' => 'flash', 'value' => 'flash'],
                ['label' => 'pulse', 'value' => 'pulse'],
                ['label' => 'rubberBand', 'value' => 'rubberBand'],
                ['label' => 'shake', 'value' => 'shake'],
                ['label' => 'swing', 'value' => 'swing'],
                ['label' => 'tada', 'value' => 'tada'],
                ['label' => 'wobble', 'value' => 'wobble'],
                ['label' => 'jello', 'value' => 'jello']
            ]],
            ['label' => __('Bouncing Entrances'), 'value' => [
                ['label' => 'bounceIn', 'value' => 'bounceIn'],
                ['label' => 'bounceInDown', 'value' => 'bounceInDown'],
                ['label' => 'bounceInLeft', 'value' => 'bounceInLeft'],
                ['label' => 'bounceInRight', 'value' => 'bounceInRight'],
                ['label' => 'bounceInUp', 'value' => 'bounceInUp']
            ]],
            ['label' => __('Fading Entrances'), 'value' => [
                ['label' => 'fadeIn', 'value' => 'fadeIn'],
                ['label' => 'fadeInDown', 'value' => 'fadeInDown'],
                ['label' => 'fadeInDownBig', 'value' => 'fadeInDownBig'],
                ['label' => 'fadeInLeft', 'value' => 'fadeInLeft'],
                ['label' => 'fadeInLeftBig', 'value' => 'fadeInLeftBig'],
                ['label' => 'fadeInRight', 'value' => 'fadeInRight'],
                ['label' => 'fadeInRightBig', 'value' => 'fadeInRightBig'],
                ['label' => 'fadeInUp', 'value' => 'fadeInUp'],
                ['label' => 'fadeInUpBig', 'value' => 'fadeInUpBig']
            ]],
            ['label' => __('Flippers'), 'value' => [
                ['label' => 'flip', 'value' => 'flip'],
                ['label' => 'flipInX', 'value' => 'flipInX'],
                ['label' => 'flipInY', 'value' => 'flipInY'],
            ]],
            ['label' => __('Lightspeed'), 'value' => [
                ['label' => 'lightSpeedIn', 'value' => 'lightSpeedIn'],
            ]],
            ['label' => __('Rotating Entrances'), 'value' => [
                ['label' => 'rotateIn', 'value' => 'rotateIn'],
                ['label' => 'rotateInDownLeft', 'value' => 'rotateInDownLeft'],
                ['label' => 'rotateInDownRight', 'value' => 'rotateInDownRight'],
                ['label' => 'rotateInUpLeft', 'value' => 'rotateInUpLeft'],
                ['label' => 'rotateInUpRight', 'value' => 'rotateInUpRight']
            ]],
            ['label' => __('Sliding Entrances'), 'value' => [
                ['label' => 'slideInUp', 'value' => 'slideInUp'],
                ['label' => 'slideInDown', 'value' => 'slideInDown'],
                ['label' => 'slideInLeft', 'value' => 'slideInLeft'],
                ['label' => 'slideInRight', 'value' => 'slideInRight']
            ]],
            ['label' => __('Zoom Entrances'), 'value' => [
                ['label' => 'zoomIn', 'value' => 'zoomIn'],
                ['label' => 'zoomInDown', 'value' => 'zoomInDown'],
                ['label' => 'zoomInLeft', 'value' => 'zoomInLeft'],
                ['label' => 'zoomInRight', 'value' => 'zoomInRight'],
                ['label' => 'zoomInUp', 'value' => 'zoomInUp']
            ]],
            ['label' => __('Specials'), 'value' => [
                ['label' => 'hinge', 'value' => 'hinge'],
                ['label' => 'rollIn', 'value' => 'rollIn'],
            ]]
        ];
        array_unshift($effects, [
            'value' => '',
            'label' => '',
        ]);
        return $effects;
    }
}
