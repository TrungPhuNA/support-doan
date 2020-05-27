import RunCommon from './../common/run_common';
import {loadCss} from "../common/lazyload_file";
import 'jquery-modal'
var Blog = {
    init(){
        this.loadCssLazy();
    },
    loadCssLazy()
    {
        if (typeof CSS != 'undefined')
        {
            loadCss(CSS);
        }
    }
};
$(function () {
    Blog.init();
    RunCommon.init();
});
