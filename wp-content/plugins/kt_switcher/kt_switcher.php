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

    var $image_url;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'kt_switcher_scripts' ));
        add_action( 'wp_footer', array( $this, 'kt_switcher_footer' ));
        $this->assets = plugins_url( '/assets/', __FILE__);
    }
    /**
     * Add scripts
     *
     *
     */
    function kt_switcher_scripts(){
        wp_enqueue_style( 'kt-switcher', plugins_url( '/assets/css/kt-switcher.css', __FILE__ ) );
        wp_enqueue_script( 'kt-switcher', plugins_url( '/assets/js/kt-switcher.js', __FILE__ ), array( 'jquery' ) );
    }

    function kt_switcher_footer(){


        ?>
        <div class="demo-overlay"></div>
        <div class="switcher">
            <a href="#" class="switcher-toggle"><i class="fa fa-cog fa-spin"></i></a>

            <div class="switcher-inner">

                <div class="switcher-head">
                    Style Selector
                </div>


                <div class="switcher-panel">

                    <div class="form-group">
                        <label>Theme Color</label>
                        <div id="switcher_color" class="clearfix">
                            <a data-color="c4b498" href="<?php echo $this->assets; ?>skins/color-6dab3c.css" style="background-color: #6dab3c;">#6dab3c</a>
                            <a data-color="e34444" href="<?php echo $this->assets; ?>skins/color-e34444.css" style="background-color: #e34444">#e34444</a>
                            <a data-color="17a7f1" href="<?php echo $this->assets; ?>skins/color-17a7f1.css" style="background-color: #17a7f1;">#17a7f1</a>
                            <a data-color="2fc961" href="<?php echo $this->assets; ?>skins/color-2fc961.css" style="background-color: #2fc961;">#2fc961</a>
                            <a data-color="5e36e1" href="<?php echo $this->assets; ?>skins/color-5e36e1.css" style="background-color: #5e36e1;">#5e36e1</a>
                            <a data-color="f3bb25" href="<?php echo $this->assets; ?>skins/color-f3bb25.css" style="background-color: #f3bb25;">#f3bb25</a>
                            <a data-color="17a7f1" href="<?php echo $this->assets; ?>skins/color-17a7f1.css" style="background-color: #17a7f1;">#17a7f1</a>
                            <a data-color="2fc961" href="<?php echo $this->assets; ?>skins/color-2fc961.css" style="background-color: #2fc961;">#2fc961</a>
                        </div>
                        <p>You can also sellect color codes via admin theme options</p>
                    </div>
                    <div class="form-group">
                        <label for="switcher_layout">Layout options</label>
                        <select name="layout" id="switcher_layout" autocomplete="off">
                            <option value="wide" selected="selected">Full Width</option>
                            <option value="boxed">Boxed Mod</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Boxed background examples</label>
                        <div id="switcher_background">
                            <a href="#" data-repeat="repeat"><img src="<?php echo $this->assets; ?>patterns/congruent_pentagon.png" alt=""/></a>
                            <a href="#" data-repeat="no-repeat"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/></a>
                            <a href="#" data-repeat="repeat"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/></a>
                            <a href="#" data-repeat="repeat"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/></a>
                            <a href="#" data-repeat="repeat"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/></a>
                        </div>
                    </div>
                </div>


                <div class="switcher-footer">
                    <label>See other demos</label>
                    <div id="other_demos" class="clearfix">
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/congruent_pentagon.png" alt=""/> <span>View</span></a>
                        </div>
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/> <span>View</span></a>
                        </div>
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/> <span>View</span></a>
                        </div>
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/> <span>View</span></a>
                        </div>
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/> <span>View</span></a>
                        </div>
                        <div class="demo-item">
                            <a href="#"><img src="<?php echo $this->assets; ?>patterns/criss-xcross.png" alt=""/> <span>View</span></a>
                        </div>
                    </div>
                </div>
                </div>

        </div>
        <?php
    }
}


$kt_switcher = new KT_SWITCHER();


