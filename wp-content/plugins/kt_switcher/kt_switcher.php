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
                <div class="switcher-head">Style Selector</div>
                <div class="switcher-panel">
                    <div class="form-group">
                        <label>Theme Color</label>
                        <div id="switcher_color" class="clearfix" data-path="<?php echo $this->assets; ?>skins/">
                            <a data-color="22dcce" href="#" style="background-color: #22dcce;">#22dcce</a>
                            <a data-color="75d69c" href="#" style="background-color: #75d69c">#75d69c</a>
                            <a data-color="6dab3c" href="#" style="background-color: #6dab3c">#6dab3c</a>
                            <a data-color="f4524d" href="#" style="background-color: #f4524d">#f4524d</a>
                            <a data-color="f7be68" href="#" style="background-color: #f7be68">#f7be68</a>
                            <a data-color="f79468" href="#" style="background-color: #f79468">#f79468</a>
                            <a data-color="b97ebb" href="#" style="background-color: #b97ebb">#b97ebb</a>
                            <a data-color="8d6dc4" href="#" style="background-color: #8d6dc4">#8d6dc4</a>
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


