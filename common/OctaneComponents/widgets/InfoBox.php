<?php
/**
 * Created by OctaneLab.
 * Date: 23.03.2018
 */

namespace common\OctaneComponents\widgets;


use common\OctaneComponents\components\Icon;

class InfoBox
{

    /**
     * @param string $title
     * @param string $details
     * @param string $icon - Icon name
     * @param string $bg - aqua, red, green, yellow
     * @return string
     */
    public static function brief($title = 'Hey!', $details = '123', $icon = 'check', $bg = 'aqua')
    {
        return '
        <div class="info-box">
                <span class="info-box-icon bg-'.$bg.'">
                    '.Icon::i($icon).'
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">'.$title.'</span>
                    <span class="info-box-number">'.$details.'</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->';
    }

    /**
     * @param string $title
     * @param string $details
     * @param string $pre
     * @param string $p
     * @param string $icon
     * @param string $bg
     * @return string
     */
    public static function progress($title = 'Yay!', $details = '123', $pre = 'Cool feature!', $p = '50', $icon = 'check', $bg = 'red')
    {
        return '
        <!-- Info Boxes Style 2 -->
            <div class="info-box bg-'.$bg.'">
                <span class="info-box-icon">
                    '.Icon::i($icon).'
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">'.$title.'</span>
                    <span class="info-box-number">'.$details.'</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: '.$p.'%"></div>
                    </div>
                    <span class="progress-description">
                '.$pre.'
              </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->';
    }

}