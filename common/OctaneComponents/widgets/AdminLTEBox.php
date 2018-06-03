<?php

namespace common\OctaneComponents\widgets;


class AdminLTEBox
{
    /**
     * @param array $config
     *  'border'    string color of box border " primary / success / warning / danger / ect. "
     *  'title'     string title of box
     *  'collapsed' boolen if true, box will be collapsed with plus btn,
     *                     if false, box will be not collapsed with minus btn
     *  'tools'     array extra btn
     * @return string
     */
    public static function begin( array $config = [ ] )
    {
        if ( isset( $config[ 'border' ] ) ) {
            $border = $config[ 'border' ];
        } else {
            $border = 'danger';
        }
        
        if ( isset( $config[ 'title' ] ) ) {
            $title = "<h3 class='box-title'>" . $config[ 'title' ] . "</h3>";
        } else {
            $title = '';
        }
        
        if ( isset( $config[ 'collapsed' ] ) && $config[ 'collapsed' ] ) {
            $collapsed = 'collapsed-box';
        } else {
            $collapsed = '';
        }
        
        $top = "<div class='box box-{$border} {$collapsed}'>
        <div class='box-header with-border'>
            {$title}
            <div class='box-tools pull-right'>";
        if ( isset( $config[ 'tools' ] ) ) {
            foreach ( $config[ 'tools' ] as $tool ) {
                $top .= $tool;
            }
        }
        if ( isset( $config[ 'collapsed' ] ) && $config[ 'collapsed' ] ) {
            $top .= '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>';
        } elseif ( isset( $config[ 'collapsed' ] ) && !$config[ 'collapsed' ] ) {
            $top .= '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>';
        }
        
        $top .= "</div></div>
        <!-- /.box-header -->
        <div class='box-body'>";
        
        
        return $top;
    }
    
    public static function end()
    {
        return '</div>
        <!-- ./box-body -->
        <div class="box-footer">
            <div class="row">
            
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-footer -->
    </div>';
    }
}