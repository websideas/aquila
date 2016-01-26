<?php
/*
Plugin Name: KiteThemes demo switcher
Description: KiteThemes demo switcher
Author: KiteThemes
Author URI: http://kitethemes.com
Version: 1.0
Text Domain: kt_switcher
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/



class KT_SWITCHER
{

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'kt_switcher_scripts' ));
        add_action( 'wp_footer', array( $this, 'kt_switcher_footer' ));
    }
    /**
     * Add scripts
     *
     *
     */
    function kt_switcher_scripts(){
        wp_enqueue_style( 'kt-switcher-css', plugins_url( '/assets/css/kt-switcher.css', __FILE__ ) );
        wp_enqueue_script( 'kt-switcher-js', plugins_url( '/assets/js/kt-switcher.js', __FILE__ ), array( 'jquery' ) );
    }

    function kt_switcher_footer(){

        $home_url = get_home_url();

        ?>

        <div class="switcher">
            <a href="#" class="switcher-toggle"><i class="fa fa-cogs"></i></a>

            <div class="switcher-head">
                <a title="Buy Theme Now" href="#" class="button btn-buy">Buy Theme Now</a>
            </div>

            Reset

            <div class="switcher-panel">
                <div class="switcher-heading">Color examples</div>

                <div class="form-group">
                    Demo versions
                </div>

                <div class="form-group">
                    <label>Theme Color</label>
                    <div id="switcher_color">
                        <a data-color="c4b498" href="#" style="background-color: rgb(196, 180, 152);">#c4b498</a>
                        <a data-color="e34444" href="#" class="active color" style="background-color: rgb(227, 68, 68);">#e34444</a>
                        <a data-color="17a7f1" href="#" style="background-color: rgb(23, 167, 241);">#17a7f1</a>
                        <a data-color="2fc961" href="#" style="background-color: rgb(47, 201, 97);">#2fc961</a>
                        <a data-color="5e36e1" href="#" style="background-color: rgb(94, 54, 225);">#5e36e1</a>
                        <a data-color="f3bb25" href="#" style="background-color: rgb(243, 187, 37);">#f3bb25</a>
                    </div>
                    <p>You can also sellect color codes via admin theme options</p>
                </div>
                <div class="form-group">
                    <label for="switcher_layout">Layout options</label>
                    <select name="layout" id="switcher_layout">
                        <option value="wide">Full Width</option>
                        <option value="boxed">Boxed Mod</option>
                    </select>
                </div>
                <div>
                    <label>Boxed background examples</label>
                    <div id="switcher_background">
                        <a href="#" class="active"></a>
                    </div>
                </div>

                Body font
                Source Sans Pro

                Header font
                Source Sans Pro

            </div>
        </div>
        <?php
    }
}


$kt_switcher = new KT_SWITCHER();


